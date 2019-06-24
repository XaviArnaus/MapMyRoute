<?php

class VisitorsLogging
{
    const DEFAULT_TEMPLATE = "log_%s.json";
    private $logs_path = "";
    private $file_name = "";
    private $service = "http://www.geoplugin.net/xml.gp?ip=%s";

    public function __construct(Config $config)  {
        $this->logs_path = $config->getParam("logs_path", "logs");
        $this->createLogsPath();
        $this->suggestFilename($config);
    }

    public function log($origin = 'default') {
        $visits_stack = $this->getCurrentEventLogs();

        $visits_stack[]=Visit::fromXmlVisitorData(
            $this->getVisitorDataFromIp(
                $this->getIP()
            )
        )->setOrigin($origin);

        $this->writeLogStack($visits_stack);
    }

    public function getCurrentEventLogs() {
        if (
            file_exists($this->logs_path) &&
            is_dir($this->logs_path) &&
            file_exists($this->logs_path . DIRECTORY_SEPARATOR . $this->file_name)
        ) {
            $log_events = [];
            $log_stack = file_get_contents(
                $this->logs_path . DIRECTORY_SEPARATOR . $this->file_name
            );
            $json_source = json_decode($log_stack, false);
            foreach($json_source as $json_log) {
                $log_events[]=Visit::fromObject($json_log);
            }
            return $log_events;
        } else {
            file_put_contents(
                $this->logs_path . DIRECTORY_SEPARATOR . $this->file_name,
                json_encode([])
            );
            return [];
        }
    }

    private function writeLogStack($log_stack) {
        $prepared_result = array_map(function (Visit $visit) {
                return $visit->toObject();
            },
            $log_stack
        );
        $jsonized = json_encode($prepared_result, JSON_PRETTY_PRINT);
        return file_put_contents($this->getLogsPath(true), $jsonized);
    }

    private function suggestFilename(Config $config) {
        $this->file_name = sprintf(
            self::DEFAULT_TEMPLATE,
            Strings::filter_filename($config->getParam("current_event_name"))
        );
    }

    private function createLogsPath() {
        if (file_exists($this->getLogsPath(false))) return;

        if (!mkdir($this->getLogsPath(false), 0777, true)) {
            throw new RuntimeException("Could not create events dir. Check permissions!");
        }
    }

    private function getLogsPath($with_filename = true) {
        if ($with_filename) return $this->logs_path . DIRECTORY_SEPARATOR . $this->file_name;
        else return $this->logs_path . DIRECTORY_SEPARATOR;
    }

    private function getVisitorDataFromIp($ip) {
        return simplexml_load_file(
            sprintf($this->service, $ip)
        );
    }

    private function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}