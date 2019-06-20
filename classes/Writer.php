<?php

require_once "Strings.php";

class Writer {
    const DEFAULT_TEMPLATE = "event_%s.json";
    private $events_path = "";
    private $file_name = "";

    public function __construct(Config $config)  {
        $this->events_path = $config->getParam("events_path", "events");
        $this->createEventsPath();
        $this->suggestFilename($config);
    }

    public function writeResults($result) {
        $prepared_result = array_map(function (Marker $marker) {
                return $marker->toObject();
            },
            $result
        );
        $jsonized = json_encode($prepared_result, JSON_PRETTY_PRINT);
        return file_put_contents($this->getEventsPath(true), $jsonized);
    }

    private function suggestFilename(Config $config) {
        $template = $config->getParam("filename_template", self::DEFAULT_TEMPLATE);
        $this->file_name = sprintf($template, Strings::filter_filename($config->getParam("current_event_name")));
    }

    private function createEventsPath() {
        if (file_exists($this->getEventsPath(false))) return;

        if (!mkdir($this->getEventsPath(false), 0777, true)) {
            throw new RuntimeException("Could not create events dir. Check permissions!");
        }
    }

    private function getEventsPath($with_filename = true) {
        if ($with_filename) return $this->events_path . DIRECTORY_SEPARATOR . $this->file_name;
        else return $this->events_path . DIRECTORY_SEPARATOR;
    }
}