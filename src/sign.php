<?php

namespace Certhis\Sdk;

use Certhis\Sdk\Certhis;
use Certhis\Sdk\curl;

class Sign
{

    private $certhis;


    //constructor
    public function __construct($Certhis)
    {
        $this->certhis = $Certhis;
    }


    //get sign 
    public function get($wallet)
    {

        $curl = new curl($this->certhis->api, $this->certhis->apikey);

        $data = [
            'wallet' => $wallet
        ];

        try {
            $response = $curl->get('/sign', $data);

            $response = $response['data'];
        } catch (\Exception $e) {
            return $e->getMessage();
        }



        return $response;
    }


    public function check($wallet, $signature)
    {

        $curl = new curl($this->certhis->api, $this->certhis->apikey);

        $data = [
            'wallet' => $wallet,
            'sign_message' => $signature
        ];

        try {
            $response = $curl->get('/check', $data);

            //check if key connexion is exist
            if (!array_key_exists('connexion', $response)) {
                $response['connexion'] = false;
            }

            if ($response['connexion'] != 'true') {
                $response = false;
            } else {
                $response = true;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $response;
    }


}