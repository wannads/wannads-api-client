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

    private $endpointProd = "https://api.wannads.com/v2/";
    private $endpointStaging = "http://wanfront-staging.wannads.com:8080/wannads-api-1.0-SNAPSHOT/v2/";
    private $endpointLocal = "http://localhost:8080/v2/";

    private $endpoint = "https://api.wannads.com/v2/";

    public function __construct($apiKey, $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /////////////////////////////// OFFERS ////////////////////////////////////////////


    public function getOffers($subId, $country, $ip, $fingerprint, $device, $category, $gender, $age, $payment, $extra = [])
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

        try {
            if (!empty($extra) && is_array($extra)) {

                $urlParamsExtra = http_build_query($extra);

                if (!empty($urlParamsExtra) && !empty($result) && is_array($result)) {
                    foreach ($result as &$offer) {
                        if (is_array($offer) && array_key_exists('offer_url', $offer)) {
                            if (strpos($offer["offer_url"], '?') !== false) {
                                $offer["offer_url"] = $offer["offer_url"] . "&" . $urlParamsExtra;
                            } else {
                                $offer["offer_url"] = $offer["offer_url"] . "?" . $urlParamsExtra;
                            }
                        }
                    }
                }

            }
        } catch (\Exception $e) {

        }

        return $result;

    }

    ////////////////////////////// SURVEYS ////////////////////////////////////////////

    public function getSurveyUser($subId, $byEmail = false)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId,
            "by_email" => $byEmail ? "true" : "false"
        ];

        $url = $this->endpoint . "surveys/users?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result;
    }

    public function createSurveyUser($subId, $user, $ip = null)
    {
        $surveyUserData = array(
            "sub_id" => $subId,
            "email" => $user['email'],
            "gender" => $user['gender'],
            "birthyear" => $user['birthyear'],
            "dob" => array_key_exists("dob", $user) ? $user['dob'] : "",
            "first_name" => $user['first_name'],
            "last_name" => $user['last_name'],
            "zip" => $user['zip'],
            "education_level" => $user['education_level'],
            "occupation" => $user['occupation'],
            "children_under18" => $user['children_under18'],
            "marital_status" => $user['marital_status'],
            "country" => $user['country'],
            "register_ip" => null,
            "lang2" => $user['lang2'],
            "email_notifications" => $user["email_notifications"],
            "answers" => !empty($user['answers']) ? $user['answers'] : array()
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
            "dob" => array_key_exists("dob", $user) ? $user['dob'] : "",
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

        $result = $this->makeRequest($url, "DELETE");

        return $result;
    }

    public function getSurveys($subId, $isMobile, $ip, $fp = null, $extra = [], $fp2 = null)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId,
            "is_mobile" => $isMobile,
            "ip" => $ip,
            "fp" => $fp,
            "fp2" => $fp2,
        ];

        $url = $this->endpoint . "surveys?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET", [],20);

        try {
            if (!empty($extra) && is_array($extra)) {

                $urlParamsExtra = http_build_query($extra);

                if (!empty($urlParamsExtra) && !empty($result) && is_array($result)) {
                    foreach ($result as &$survey) {
                        if (is_array($survey) && array_key_exists('offer_url', $survey)) {
                            if (strpos($survey["offer_url"], '?') !== false) {
                                $survey["offer_url"] = $survey["offer_url"] . "&" . $urlParamsExtra;
                            } else {
                                $survey["offer_url"] = $survey["offer_url"] . "?" . $urlParamsExtra;
                            }

                        }
                    }
                }

            }
        } catch (\Exception $e) {

        }

        return $result;
    }

    public function getSurveysBell($subId, $isMobile, $ip, $fp = null, $extra = [], $fp2 = null)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId,
            "is_mobile" => $isMobile,
            "ip" => $ip,
            "fp" => $fp,
            "fp2" => $fp2,
        ];

        $url = $this->endpoint . "surveys/bell?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET", [],20);

        try {
            if (!empty($extra) && is_array($extra)) {

                $urlParamsExtra = http_build_query($extra);

                if (!empty($urlParamsExtra) && !empty($result) && is_array($result)) {
                    foreach ($result as &$survey) {
                        if (is_array($survey) && array_key_exists('offer_url', $survey)) {
                            if (strpos($survey["offer_url"], '?') !== false) {
                                $survey["offer_url"] = $survey["offer_url"] . "&" . $urlParamsExtra;
                            } else {
                                $survey["offer_url"] = $survey["offer_url"] . "?" . $urlParamsExtra;
                            }

                        }
                    }
                }

            }
        } catch (\Exception $e) {

        }

        return $result;
    }

    public function getSurveysByProvider($providerKey, $subId, $isMobile, $ip, $fp = null, $extra = [], $fp2 = null)
    {
        $urlParams = [
            "provider_key" => $providerKey,
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId,
            "is_mobile" => $isMobile,
            "ip" => $ip,
            "fp" => $fp,
            "fp2" => $fp2,
        ];

        $url = $this->endpoint . "surveys/prv?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET", [],20);

        try {
            if (!empty($extra) && is_array($extra)) {

                $urlParamsExtra = http_build_query($extra);

                if (!empty($urlParamsExtra) && !empty($result) && is_array($result)) {
                    foreach ($result as &$survey) {
                        if (is_array($survey) && array_key_exists('offer_url', $survey)) {
                            if (strpos($survey["offer_url"], '?') !== false) {
                                $survey["offer_url"] = $survey["offer_url"] . "&" . $urlParamsExtra;
                            } else {
                                $survey["offer_url"] = $survey["offer_url"] . "?" . $urlParamsExtra;
                            }

                        }
                    }
                }

            }
        } catch (\Exception $e) {

        }

        return $result;
    }

    public function getNextSurvey($subId, $minimunPayout, $domain = "", $isMobile, $ip, $fp = null, $fp2 = null, $subId2 = null, $subId3 = null, $subId4 = null, $subId5 = null, $subId6 = null)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId,
            "minimun_payout" => $minimunPayout,
            "domain" => $domain,
            "is_mobile" => $isMobile,
            "ip" => $ip,
            "fp" => $fp,
            "fp2" => $fp2,
            "sub_id2" => $subId2,
            "sub_id3" => $subId3,
            "sub_id4" => $subId4,
            "sub_id5" => $subId5,
            "sub_id6" => $subId6,
        ];

        $url = $this->endpoint . "surveys/next?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET", [],20);

        return $result;
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

        return $result;
    }

    public function getUserProfileQuestionsOptions($code, $questionId)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "code" => $code,
            "question_id" => $questionId
        ];

        $url = $this->endpoint . "surveys/questions/options?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result;
    }

    public function getUserNextProfileQuestions($subId, $number)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId,
            "number" => $number
        ];

        $url = $this->endpoint . "surveys/questions/next?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result;
    }

    public function getCountryLanguages($country)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "country" => $country
        ];

        $url = $this->endpoint . "surveys/questions/countrylanguages?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result;
    }

    // CLAIMS

    public function getClaimsClicks($subId)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "claims/clicks?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result;
    }


    public function getClaimsPendingOffers($subId)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "claims/pending?" . http_build_query($urlParams);

        $result = $this->makeRequest($url, "GET");

        return $result;
    }

    public function getClaimsCreditedOffers($subId)
    {
        $urlParams = [
            "api_key" => $this->apiKey,
            "api_secret" => $this->apiSecret,
            "sub_id" => $subId
        ];

        $url = $this->endpoint . "claims/credited?" . http_build_query($urlParams);

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
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); //curl_setopt($ch, CURLOPT_PUT, true); con esto no funciona :S
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            } else if ($method == "DELETE") {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);

            $result = curl_exec($ch);
            $info = curl_getinfo($ch);

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