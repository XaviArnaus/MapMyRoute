<?php

require_once "objects/Marker.php";

class Parser {

    public function instantiateMarkers($event_file_content) {
        $markers = [];
        $json_source = json_decode($event_file_content, false);
        foreach($json_source as $json_marker) {
            $current_marker = new Marker(
                $json_marker->lat,
                $json_marker->lng,
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