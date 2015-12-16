<?php


/**
 * Created by IntelliJ IDEA.
 * User: newuni
 * Date: 16/12/15
 * Time: 19:14
 */
class WannadsApiClientTest extends PHPUnit_Framework_TestCase
{

    private $apiKey = "54d29b5e56de3225111124";
    private $apiSecret = "59bed3e5d6";
    private $subId = "Chizaa93";

    public function testGeSurveyUser()
    {

        $client = new \Wannads\WannadsApiClient($this->apiKey, $this->apiSecret);

        $result = $client->getSurveyUser($this->subId);

        $this->assertNotNull($result);
    }

}