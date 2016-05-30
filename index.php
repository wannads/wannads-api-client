<?php

require "vendor/autoload.php";

$apiKey = "54c679ed6e976224761456";
$apiSecret = "7e5de9a696";
$subId = "xx1";

$client = new \Wannads\WannadsApiClient($apiKey, $apiSecret);

$result = $client->deleteSurveyUser($subId);

var_dump($result);

