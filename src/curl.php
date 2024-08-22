<?php

namespace Certhis\Sdk;

use Certhis\Sdk\certhis;

class curl
{
    private $api;
    private $apikey;

    public function __construct($api, $apikey)
    {
        $this->api = $api;
        $this->apikey = $apikey;
    }


    //post function
    public function post($url, $data)
    {
        $ch = curl_init($this->api . $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Content-Type: application/json'
        ];

        if ($this->apikey) {
            $headers[] = 'api_key:' . $this->apikey;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($result, true);

    }

    //get function

    public function get($url, $data)
    {
        $url = $url . '?' . http_build_query($data);
        $ch = curl_init($this->api . $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Content-Type: application/json'
        ];

        if ($this->apikey) {
            $headers[] = 'api_key:' . $this->apikey;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }



        curl_close($ch);

        return json_decode($result, true);
    }


}







