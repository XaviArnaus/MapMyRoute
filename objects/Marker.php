<?php

class Marker {
    public $latitude;
    public $longitude;

    public function __construct($latitude, $longitude) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function toString() {
        return "{lat: " . $this->latitude . ", lng: " . $this->longitude . "}";
    }
}