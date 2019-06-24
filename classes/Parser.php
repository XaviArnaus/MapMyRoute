<?php

class Parser {

    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function instantiateMarkers($event_file_content) {
        $markers = [];
        $json_source = json_decode($event_file_content, false);
        foreach($json_source as $json_marker) {
            $current_marker = new Marker(
                $json_marker->lat,
                $json_marker->lng,
                isset($json_marker->origin) ?
                    $json_marker->origin :
                    $this->config->getParam("visitors_origin")['default'],
                $json_marker->timestamp
            );
            if (isset($json_marker->name)) {
                $current_marker->name = $json_marker->name;
            }
            $markers[]=$current_marker;
        }
        return $markers;
    }
}