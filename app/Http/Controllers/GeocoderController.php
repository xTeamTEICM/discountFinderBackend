<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;


class GeocoderController extends Controller
{
    private $url = 'https://maps.googleapis.com/maps/api/geocode/json';
    private $key = '?key=';
    private $lang = '&language=';
    private $latlng = '&latlng=';
    private $lat;
    private $log;

    private $city = 'Άγνωστο';

    /**
     * GeocoderController constructor.
     * @param $lat
     * @param $log
     * @param $lang
     */
    public function __construct($lat, $log, $lang)
    {
        $this->key .= env('GOOGLE_API_KEY', 'default');
        $this->lat = $lat;
        $this->log = $log;
        $this->lang .= $lang;
        $this->callGoogleAPI();
    }


    /**
     *
     */
    private function callGoogleAPI()
    {
        $client = new Client();
        $buildedURL = $this->url;
        $buildedURL .= $this->key;
        $buildedURL .= $this->lang;
        $buildedURL .= $this->latlng;
        $buildedURL .= $this->lat . ',' . $this->log;

        $response = json_decode($client->get($buildedURL)->getBody());
        $results = $response->results[1];
        $address_components = $results->address_components;

        // Find only city
        foreach ($address_components as $address_component) {
            if (isset($address_component->types)) {
                foreach ($address_component->types as $type) {
                    if ($type == 'administrative_area_level_3') {
                        $this->city = $address_component->long_name;
                        break;
                    }
                }
            }
        }

    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
}
