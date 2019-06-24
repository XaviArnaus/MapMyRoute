<?php

class Marker {
    public $latitude;
    public $longitude;
    public $name;
    public $timestamp;
    public $icon = null;

    public function __construct($latitude, $longitude, $icon, $timestamp = null) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->icon = $icon;
        $this->timestamp = $timestamp == null ? date("d/m/Y H:i:s") : $timestamp;
    }

    public function toString() {
        if ($this->name != null) {
            return "{timestamp: '" . $this->timestamp .
                "', lat: " . $this->latitude .
                ", lng: " . $this->longitude .
                ", name: '" . $this->name . "'" .
                ", icon: '" . $this->icon . "'" .
                "}";
        } else {
            return "{timestamp: '" . $this->timestamp .
                "', lat: " . $this->latitude .
                ", lng: " . $this->longitude .
                ", icon: '" . $this->icon . "'" .
                "}";
        }
    }

    public function toArray() {
        $result = [
            "timestamp" => $this->timestamp,
            "lat" => $this->latitude,
            "lng" => $this->longitude,
            "icon" => $this->icon
        ];

        if ($this->name != null) {
            $result['name']= $this->name;
        }

        return $result;
    }

    public function toObject() {
        return (object)$this->toArray();
    }

    public function applyTimezoneCorrection(Config $config, $datetime_format = "d/m/Y H:i:s") {
        $timezone_correction = $config->getParam("timezone_displacement");

        $pieces = null;
        preg_match('/([+-])([0-9])/', $timezone_correction, $pieces);
        $timestamp = DateTime::createFromFormat($datetime_format, $this->timestamp);
        if($pieces[1]=="+") {
            $timestamp->add(new DateInterval("PT{$pieces[2]}H"));
        } elseif($pieces[1]=="-") {
            $timestamp->sub(new DateInterval("PT{$pieces[2]}H"));
        } else {
            // Do nothing.
        }
        $this->timestamp = $timestamp->format($datetime_format);
    }
}