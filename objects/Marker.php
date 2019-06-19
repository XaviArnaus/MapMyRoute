<?php

class Marker {
    public $latitude;
    public $longitude;
    public $name;

    public function __construct($latitude, $longitude) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function toString() {
        if ($this->name != null) {
            return "{lat: " . $this->latitude . ", lng: " . $this->longitude . ", name: '" . $this->name . "'}";
        } else {
            return "{lat: " . $this->latitude . ", lng: " . $this->longitude . "}";
        }
    }
}