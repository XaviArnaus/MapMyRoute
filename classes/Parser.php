<?php

require_once "objects/Marker.php";

class Parser {

    public function instantiateMarkers($event_file_content) {
        $markers = [];
        $json_source = json_decode($event_file_content, false);
        foreach($json_source as $json_marker) {
            $markers[]= new Marker(
                $json_marker->lat,
                $json_marker->long
            );
        }
        return $markers;
    }
}