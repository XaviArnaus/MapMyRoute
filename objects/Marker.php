<?php

class Marker {
    public $latitude;
    public $longitude;
    public $name;
    public $timestamp;

    public function __construct($latitude, $longitude, $timestamp = null) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->timestamp = $timestamp == null ? date("d/m/Y H:i:s") : $timestamp;
    }

    public function toString() {
        if ($this->name != null) {
            return "{timestamp: '" . $this->timestamp . "', lat: " . $this->latitude . ", lng: " . $this->longitude . ", name: '" . $this->name . "'}";
        } else {
            return "{timestamp: '" . $this->timestamp . "', lat: " . $this->latitude . ", lng: " . $this->longitude . "}";
        }
    }

    public function toArray() {
        $result = [
            "timestamp" => $this->timestamp,
            "lat" => $this->latitude,
            "lng" => $this->longitude
        ];

        if ($this->name != null) {
            $result['name']= $this->name;
        }

        return $result;
    }

    public function toObject() {
        return (object)$this->toArray();
    }
}