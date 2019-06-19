<?php

require_once "String.php";

class Reader {

    private $events_path = "";
    private $event_filename_template = "";
    private $parser = null;
    private $config;

    public function __construct(Config $config, Parser $parser) {
        $this->events_path = $config->getParam("events_path", "events");
        $this->event_filename_template  = $config->getParam("filename_template", "event_%s.json");
        $this->parser = $parser;
        $this->config = $config;
    }

    public function getCurrentEvent($event_name) {
        $filename = $this->getFileFromEventName($event_name);

        if (
            file_exists($this->events_path) &&
            is_dir($this->events_path) &&
            file_exists($this->events_path . DIRECTORY_SEPARATOR
                . sprintf($this->event_filename_template, $filename))
        ) {
            return $this->parser->instantiateMarkers(
                file_get_contents(
                    $this->events_path . DIRECTORY_SEPARATOR .
                    sprintf($this->event_filename_template, $filename)
                )
            ); 
        } else {
            if($this->config->getParam("on_events_file_not_found_create_new", false)) {
                file_put_contents(
                    $this->events_path . DIRECTORY_SEPARATOR
                    . sprintf($this->event_filename_template, $filename),
                    json_encode([])
                );
                return [];
            } else {
                throw new RuntimeException("Error getting the event: " .
                    $this->events_path . DIRECTORY_SEPARATOR .
                    sprintf($this->event_filename_template, $filename)
                );
            }
        }
    }

    private function getFileFromEventName($event_name) {
        return String::filter_filename($event_name);
    }
}