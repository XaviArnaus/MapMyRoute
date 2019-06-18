<?php

class Reader {

    const DIRECTORY_PATH_MODIFICATOR = '..' . DIRECTORY_SEPARATOR;

    private $unwanted_files = ['..', '.'];
    private $events_path = "";
    private $parser = null;

    public function __construct(Config $config, Parser $parser) {
        $this->events_path = $config->getParam("events_path", "events");
        $this->parser = $parser;
    }

    public function getCurrentEvent($event_name) {
        $filename = $this->getFileFromEventName($event_name);

        if (
            file_exists(self::DIRECTORY_PATH_MODIFICATOR . $this->events_path) &&
            is_dir(self::DIRECTORY_PATH_MODIFICATOR . $this->events_path) &&
            file_exists(self::DIRECTORY_PATH_MODIFICATOR . $filename)
        ) {
            return $this->parser::instantiateMarkers(
                file_get_contents(
                    self::DIRECTORY_PATH_MODIFICATOR . $this->events_path . DIRECTORY_SEPARATOR . $filename
                )
            ); 
        } else {
            throw new RuntimeException("Error getting the event: " . self::DIRECTORY_PATH_MODIFICATOR . $this->events_path . DIRECTORY_SEPARATOR . $filename);
        }
    }

    private function getFileFromEventName($event_name) {
        return urlencode($event_name);
    }
}