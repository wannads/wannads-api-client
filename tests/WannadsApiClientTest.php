<?php


/**
 * Created by IntelliJ IDEA.
 * User: newuni
 * Date: 16/12/15
 * Time: 19:14
 */
class WannadsApiClientTest extends PHPUnit_Framework_TestCase
{

    private $apiKey = "54c679ed6e976224761456";
    private $apiSecret = "7e5de9a696";
    private $subId = "";

    public function testGeSurveyUser()
    {

        $client = new \Wannads\WannadsApiClient($this->apiKey, $this->apiSecret);

        $result = $client->getSurveyUser($this->subId);

        $this->assertNotNull($result);
    }

//    public function testGetOffers()
//    {
//
//        $client = new \Wannads\WannadsApiClient($this->apiKey, $this->apiSecret);
//
//        $country = "ES";
//        $ip = "";
//        $fingerprint = "";
//        $device = []; // desktop, iphone, ipad, android, empty for all
//        $category = ["dailysurveys"]; // all, dailysurveys, surveys, signups, downloads, pinsubmit, purchase, dating, mobileapps
//        $gender = ""; // female, male, female
//        $payment = ""; // all, yes, no
//
//        $result = $client->getOffers($this->subId, $country, $ip, $fingerprint, $device, $category, $gender, $payment);
//
//        $this->assertNotEmpty($result);
//    }

    public function testGetCountryLanguages()
    {

        $client = new \Wannads\WannadsApiClient($this->apiKey, $this->apiSecret);

        $country = "ES";
        $result = $client->getCountryLanguages($country);

        $this->assertNotEmpty($result);
    }



}