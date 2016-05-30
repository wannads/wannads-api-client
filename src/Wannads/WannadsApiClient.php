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

    private $endpointProd = "http://api.wannads.com/v2/";
    private $endpointStaging = "http://wanfront-staging.wannads.com:8080/wannads-api-1.0-SNAPSHOT/v2/";
    private $endpointLocal = "http://localhost:8080/v2/";

    private $endpoint = "http://wanfront-staging.wannads.com:8080/wannads-api-1.0-SNAPSHOT/v2/";

    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /////////////////////////////// OFFERS ////////////////////////////////////////////


    public function getOffers($subId, $country, $ip, $fingerprint, $device, $category, $gender, $age, $payment)
    {

        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId,
            "country" => $country,
            "ip" => $ip,
            "fingerprint" => $fingerprint,
            "device" => implode(",", $device),
            "category" => implode(",", $category),
            "gender" => $gender,
            "age" => $age,
            "payment" => $payment
        ];

        $url = $this->endpoint . "offers?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result["result"];

    }

    ////////////////////////////// SURVEYS ////////////////////////////////////////////

    public function getSurveyUser($subId)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "surveys/users?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result["result"];
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
            "country" => $user['country'],
            "lang2" => $user['lang2'],
            "answers" => !empty($user['answers']) ? $user['answers'] : array()
        );

        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "surveys/users?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "POST", $surveyUserData);

        return $result["result"];
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
            "answers" => !empty($user['answers']) ? $user['answers'] : array()
        );


        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "surveys/users?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "PUT", $surveyUserData);

        return $result["result"];
    }

    public function deleteSurveyUser($subId)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "surveys/users?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "DELETE");

        if($result["client"] == "curl"){
            $result = $result["responseHeaders"]["http_code"] == "200" ? true : false;
        }else if($result["client"] == "fgc"){
            $responseHeaders = $this->parseHeaders($result["responseHeaders"]);
            $result = $responseHeaders["reponse_code"] == "200" ? true : false;
        }

        return $result;
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

        return $result["result"];
    }

    public function getUserProfileQuestions($code)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "code" => $code
        ];

        $url = $this->endpoint . "surveys/questions?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result["result"];
    }

    public function getUserProfileQuestionsOptions($code, $questionId)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "code" => $code,
            "question_id" => $questionId
        ];

        $url = $this->endpoint . "surveys/questions?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result["result"];
    }


    /**
     * Performs the underlying HTTP request. Not very exciting
     * @param  string $method The API method to be called
     * @param  array $args Assoc array of parameters to be passed
     * @return array          Assoc array of decoded result
     */
    private function makeRequest($url, $method, $args = array(), $timeout = 10)
    {

        $responseHeaders = null;
        $client = "";

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

            $responseHeaders = curl_getinfo($ch);

            curl_close($ch);

            $client = "curl";
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

            $responseHeaders = $http_response_header;
            $client = "fgc";

        }

        $objReturn = array(
            "result" => $result ? json_decode($result, true) : false,
            "responseHeaders" =>$responseHeaders,
            "client" => $client
        );

        return $objReturn;
    }

    private function parseHeaders( $headers )
    {
        $head = array();
        foreach( $headers as $k=>$v )
        {
            $t = explode( ':', $v, 2 );
            if( isset( $t[1] ) )
                $head[ trim($t[0]) ] = trim( $t[1] );
            else
            {
                $head[] = $v;
                if( preg_match( "#HTTP/[0-9\.]+\s+([0-9]+)#",$v, $out ) )
                    $head['reponse_code'] = intval($out[1]);
            }
        }
        return $head;
    }

    private function dd($var)
    {
        var_dump($var);
        exit();

    }

}