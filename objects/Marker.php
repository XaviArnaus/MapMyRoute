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

    public function applyTimezoneCorrection(Config $config) {
        $timezone_correction = $config->getParam("timezone_displacement");

        $pieces = null;
        preg_match('/([+-])([0-9])/', $timezone_correction, $pieces);
        $timestamp = DateTime::createFromFormat("d/m/Y H:i:s", $this->timestamp);
        if($pieces[1]=="+") {
            $timestamp->add(new DateInterval("PT{$pieces[2]}H"));
        } elseif($pieces[1]=="-") {
            $timestamp->sub(new DateInterval("PT{$pieces[2]}H"));
        } else {
            // Do nothing.
        }
        $this->timestamp = $timestamp->format('Y-m-d H:i:s');
    }
}