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
    private $endpoint = "http://api.wannads.com/v2/";

    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    public function getSurveyUser($subId)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "surveys/users?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result;
    }

    public function createSurveyUser($subId, $user)
    {
        $surveyUserData = array(
            "sub_id" => $subId,
            "email" => $user['email'],
            "gender" => $user['gender'],
            "birthyear" => $user['birthyear'],
            "first_name" => $user['first_name'],
            "last_name" => $user['last_name'],
            "zip" => $user['zip'],
            "education_level" => $user['education_level'],
            "occupation" => $user['occupation'],
            "children_under18" => $user['children_under18'],
            "marital_status" => $user['marital_status'],
            "phone" => $user['phone'],
            "address" => $user['address'],
            "country" => $user['country']
        );


        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "surveys/users?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "POST", $surveyUserData);

        return $result;
    }

    public function updateSurveyUser($subId, $user)
    {
        $surveyUserData = array(
            "sub_id" => $subId,
            "email" => $user['email'],
            "gender" => $user['gender'],
            "birthyear" => $user['birthyear'],
            "first_name" => $user['first_name'],
            "last_name" => $user['last_name'],
            "zip" => $user['zip'],
            "education_level" => $user['education_level'],
            "occupation" => $user['occupation'],
            "children_under18" => $user['children_under18'],
            "marital_status" => $user['marital_status'],
            "phone" => $user['phone'],
            "address" => $user['address'],
            "country" => $user['country']
        );


        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "surveys/users?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "PUT", $surveyUserData);

        return $result;
    }

    public function deleteSurveyUser($subId)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "surveys/users?" . http_build_query($urlParams);

        $this->makeRequest($url, "DELETE");
    }

    public function getSurveys($subId)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "surveys?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result;
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

        if (function_exists('curl_init') && function_exists('curl_setopt')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            if ($method == "POST") {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            } else if ($method == "PUT") {
                curl_setopt($ch, CURLOPT_PUT, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            } else if ($method == "DELETE") {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            $result = curl_exec($ch);

            curl_close($ch);
        } else {

            if ($method == "PUT" || $method == "POST") {
                $result = file_get_contents($url, null, stream_context_create(array(
                    'http' => array(
                        'protocol_version' => 1.1,
                        'user_agent' => 'PHP-MCAPI/2.0',
                        'method' => $method,
                        'header' => "Content-type: application/json\r\n" . "Connection: close\r\n" . "Content-length: " . strlen($json_data) . "\r\n",
                        'content' => $json_data,
                    ),
                )));
            } else {
                $result = file_get_contents($url, null, stream_context_create(array(
                    'http' => array(
                        'protocol_version' => 1.1,
                        'user_agent' => 'PHP-MCAPI/2.0',
                        'method' => $method,
                        'header' => "Content-type: application/json\r\n" . "Connection: close\r\n" . "Content-length: " . strlen($json_data) . "\r\n"
                    ),
                )));
            }

        }


        return $result ? json_decode($result, true) : false;
    }

    private function dd($var)
    {
        var_dump($var);
        exit();

    }

}