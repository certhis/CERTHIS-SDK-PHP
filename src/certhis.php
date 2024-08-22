<?php

namespace Certhis\Sdk;

class Certhis
{
    public $api;
    public $apikey;

    public function __construct($api = 'https://api.certhis.io', $apikey = null)
    {
     
        $this->api = $api;
        $this->apikey = $apikey;
    
    }

}