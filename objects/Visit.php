<?php


class Visit
{
    public $timestamp;

    public $request_ip;
    public $city;
    public $region_code;
    public $region_name;
    public $area_code;
    public $dma_code;
    public $country_code;
    public $country_name;
    public $continent_code;
    public $continent_name;
    public $latitude;
    public $longitude;
    public $accuracy_radius;
    public $timezone;

    /**
     * Visit constructor.
     * @param $timestamp
     */
    public function __construct($timestamp = null)
    {
        $this->timestamp = $timestamp == null ? date("Y-m-d H:i:s") : $timestamp;
    }

    public function toArray() {
        $result = [];
        foreach (get_object_vars($this) as $property => $value) {
            $result[$property] = $value;
        }

        return $result;
    }

    public function toObject() {
        return (object)$this->toArray();
    }

    public static function fromObject($object) {
        $visit = new Visit();

        foreach (get_object_vars($object) as $property => $value) {
            if(property_exists($visit, $property)) {
                $visit->$property = $value;
            }
        }

        return $visit;
    }

    public static function fromXmlVisitorData($xml_data) {
        $visit = new Visit();

        $visit->request_ip = (string) $xml_data->geoplugin_request;
        $visit->city = (string) $xml_data->geoplugin_city;
        $visit->region_code = (string) $xml_data->geoplugin_regionCode;
        $visit->region_name = (string) $xml_data->geoplugin_regionName;
        $visit->area_code = (string) $xml_data->geoplugin_areaCode;
        $visit->dma_code = (string) $xml_data->geoplugin_dmaCode;
        $visit->country_code = (string) $xml_data->geoplugin_countryCode;
        $visit->country_name = (string) $xml_data->geoplugin_countryName;
        $visit->continent_code = (string) $xml_data->geoplugin_continentCode;
        $visit->continent_name = (string) $xml_data->geoplugin_continentName;
        $visit->latitude = (float) $xml_data->geoplugin_latitude;
        $visit->longitude = (float) $xml_data->geoplugin_longitude;
        $visit->accuracy_radius = (int) $xml_data->geoplugin_locationAccuracyRadius;
        $visit->timezone = (string) $xml_data->geoplugin_timezone;

        return $visit;
    }

}