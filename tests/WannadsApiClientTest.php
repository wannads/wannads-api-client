<?php


/**
 * Created by IntelliJ IDEA.
 * User: newuni
 * Date: 16/12/15
 * Time: 19:14
 */
class WannadsApiClientTest extends PHPUnit_Framework_TestCase
{

    private $apiKey = "2452b43bea8be8c1.28247523";
    private $apiSecret = "16413619b5";
    private $subId = "nonono2222nonono@gmail.com";

    public function testGeSurveyUser()
    {

        $client = new \Wannads\WannadsApiClient($this->apiKey, $this->apiSecret);

        $result = $client->getSurveyUser($this->subId, true);

        $this->assertNotNull($result);
    }

    public function testGetNextSurveyUser()
    {

        $client = new \Wannads\WannadsApiClient($this->apiKey, $this->apiSecret);

        $result = $client->getNextSurvey($this->subId);

        $this->assertNotNull($result);
    }

    public function testGetUserNextProfileQuestions()
    {

        $client = new \Wannads\WannadsApiClient($this->apiKey, $this->apiSecret);

        $result = $client->getUserNextProfileQuestions($this->subId, 2);

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