<?php

namespace Wannads;

/**
 * User: newuni
 * Date: 16/12/15
 * Time: 16:25
 */
class WannadsApiClient
{

    private $apiKey;
    private $apiSecret;
    private $endpoint = "http://api.wannads.com";

    public function __construct($apiKey, $apiSecret)
    {
        if (empty($config)) {
            return null;
        }

        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;

    }

    public function getSurveyUser($subId)
    {

        $urlParams = [
            "api_key" => "",
            "api_secret" => "",
            "sub_id" => ""
        ];


        $url = $this->endpoint . "/surveys/?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result;
    }

    public function insertSurveyUser($user)
    {

    }

    public function updateSurveyUser($subId, $user)
    {

    }

    public function deleteSurveyUser($subId)
    {

    }

    /**
     * Performs the underlying HTTP request. Not very exciting
     * @param  string $method The API method to be called
     * @param  array $args Assoc array of parameters to be passed
     * @return array          Assoc array of decoded result
     */
    private function makeRequest($url, $method, $args = array(), $timeout = 10)
    {
        $json_data = json_encode($args);

        $result = file_get_contents($url, null, stream_context_create(array(
            'http' => array(
                'protocol_version' => 1.1,
                'user_agent' => 'PHP-MCAPI/2.0',
                'method' => $method,
                'header' => "Content-type: application/json\r\n" .
                    "Connection: close\r\n" .
                    "Content-length: " . strlen($json_data) . "\r\n",
                'content' => $json_data,
            ),
        )));

        return $result ? json_decode($result, true) : false;
    }

}