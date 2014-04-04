<?php

namespace Synolia\Bundle\FullContactBundle\Services;

class FullContact {

    const USER_AGENT = 'synolia/fullcontact';

    protected $baseUri = 'https://api.fullcontact.com/';
    protected $version = 'v2';

    protected $apiKey = null;

    public $responseObject = null;
    public $responseCode = null;
    public $responseJson = null;

    /**
     * @param $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    protected function run($params = array())
    {
        if(!in_array($params['method'], $this->supportedMethods)){
            throw new \Exception(__CLASS__ . " does not support the [" . $params['method'] . "] method");
        }

        $params['apiKey'] = urlencode($this->apiKey);
        $params['style'] = 'dictionary';

        $fullUrl = $this->baseUri . $this->version . $this->resourceUri .
            '?' . http_build_query($params);

        // Open connection
        $connection = curl_init($fullUrl);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($connection, CURLOPT_USERAGENT, self::USER_AGENT);

        // Execute request
        $this->responseJson    = curl_exec($connection);
        $this->responseCode    = curl_getinfo($connection, CURLINFO_HTTP_CODE);
        $this->responseObject  = json_decode($this->responseJson);

        switch($this->responseCode) {
            case '400':
            case '403':
            case '410':
            case '422':
            case '500':
                throw new \Exception($this->responseCode . "::" . $this->responseObject->message);
                break;
        }

        return $this->responseObject;
    }
}