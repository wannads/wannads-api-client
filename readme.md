# Wannads API PHP Client

Read the [API documentation](https://wannads.zendesk.com/hc/en-us/articles/205210471-Offers-API) 

Explore [API Online](http://test.api.wannads.com)


## Installation

Run the following command to install the package and add it as a requirement to your project's `composer.json`:

```bash
composer require wannads/wannads-api-client
```

## Usage

#### Offers

List offers.

```php
<?php

use WannadsApiClient;

$wannadsApiClient = new WannadsApiClient(API_KEY, API_SECRET);
$offers = $wannadsApiClient->getOffers($subId, $country, $ip, $fingerprint, $device, $category, $gender, $age, $payment);
```

Available Parameters

| Name         | Type    | Description                                                                                                                                                       | Example values  | Required  |
| -----------  |:---     |:-------------:                                                                                                                                                    |:------------:   |:----:     |
| $subId       | string  |  Corresponds to your unique user identifier. If this parameter is included the IP parameter is required.                                                           |  D4sH3r         | *         |
| $country     | string  | List available offers for a country (ISO2). If the optional parameters $subId and $ip are included, this one is ignored and the country is obtained with the $ip.  |   ES            | * |
| $ip          | string  | IP of the user.                                                                                                                                                   |    84.122.73.80 | * |
| $fingerprint | string  | Fingerprint of the user. Use  [Valve/fingerprintjs2](https://github.com/Valve/fingerprintjs2/ "fingerprintjs2") library to calculate it.                          | a2cc3b61a276e5b7f55028c0ed5919ea | no |
| $device      | array() | Filters the list of offers to show the offers available to that device.                                                                                           |    desktop | no |
| $category    | array() | Filters the list of offers with offers of that category only.                                                                                                     | signups, surveys | no |
| $gender      | string  | Filters the list of offers to show the ones availables only to that gender.                                                                                        |   m | no | 
| $age         | integer  | Filters the list of offers to show the ones availables only to the age of the user.                                                                                        |   22 | no | 
| $payment     | string  | Filters the offers to show only the offers that require or not payment.                                                                                            |    no | no |

* If $subId is included the $ip is required and $country will be ignored.

Visit our [documentation](https://wannads.zendesk.com/hc/en-us/articles/205210471-Offers-API) to see all the available options.

Result

```php
array(
      [
        "categories" => [],
        "completed" => 0,
        "conversion_point" => "Registrate con una tarjeta de crédito válida y manten tu cuenta activa.",
        "conversion_time" => ["id" => 1],
        "description" => "7 dias de prueba gratis!",
        "id" => 71403,
        "payment_required" => "no",
        "title" => "High quality movies!",
        "img_url" => "//statics3.tokenads.com/upload/pDaVH1M5LTCb7onqMhTT.jpg",
        "offer_url" => "https://www.wannads.com/wtrck?cId=71403&apiKey=2452b43bea8be8c1.28247523&userId=55267",
        "revenue" => 4.053,
        "currency" => "USD",
        "virtual_currency_value" => 283.71,
        "virtual_currency" => "points",
      ],
      [
        "categories" => [],
        "completed" => 0,
        "conversion_point" => "Descarga, instala y empieza a usar para recibir.",
        "conversion_time" => ["id" => 1],
        "id" => 120611,
        "payment_required" => "no",
        "title" => "eDreams - Prenota Voli economici, Hotel e Auto",
        "img_url" => "//statics3.woobi.com/upload/PkzLouOF3SUjLA30EW7x.jpg",
        "offer_url" => "https://www.wannads.com/wtrck?cId=120611&apiKey=2452b43bea8be8c1.28247523&userId=55267",
        "revenue" => 0.122,
        "currency" => "USD",
        "virtual_currency_value" => 8.575,
        "virtual_currency" => "points",
      ]
  )
```

#### Surveys

Create Wannads Surveys user.

lang2 https://en.wikipedia.org/wiki/List_of_ISO_639-2_codes

```php
<?php

use WannadsApiClient;

$data = [
                    "email" => "name@test.com",
                    "gender" => "male",
                    "birthyear" => 1987,
                    "first_name" => "Peter",
                    "last_name" => "Garcia",
                    "zip" => 48002,
                    "education_level" => 3,
                    "occupation" => 2,
                    "children_under18" => 1,
                    "marital_status" => 1,
                    "country" => $country,
                    "lang2" => "ENG",
                    "answers" => []
        ];

$wannadsApiClient = new WannadsApiClient(API_KEY, API_SECRET);
$user = $wannadsApiClient->createSurveyUser($userId, $data);
```

Result

```php
<?php

array( 
  "sub_id" => "55267test",
  "email" => "name@test.com",
  "gender" => "m",
  "birthyear" => 1995,
  "first_name" => "Test1",
  "last_name" => "borrar2",
  "zip" => "48010",
  "education_level" => 1,
  "occupation" => 2,
  "children_under18" => 0,
  "marital_status" => 1,
  "country" => "ES",
  "lang" => "SPA",
  "lang2" => "ENG"
)
```

Update Wannads Surveys user.

```php
<?php

use WannadsApiClient;

$data = [
                    "email" => "name@test.com",
                    "gender" => "male",
                    "birthyear" => 1987,
                    "first_name" => "Peter",
                    "last_name" => "Garcia",
                    "zip" => 48002,
                    "education_level" => 3,
                    "occupation" => 2,
                    "children_under18" => 1,
                    "marital_status" => 1,
                    "country" => $country,
                    "lang2" => "ENG",
                    "answers" => [21=> 1, 22 => ["1", "2"], 42 => 30]
        ];

$wannadsApiClient = new WannadsApiClient(API_KEY, API_SECRET);
$user = $wannadsApiClient->updateSurveyUser($userId, $data);
```

Get user data from Wannads Surveys.

```php
<?php

use WannadsApiClient;

$wannadsApiClient = new WannadsApiClient(API_KEY, API_SECRET);
$user = $wannadsApiClient->getSurveyUser($userId);
```

Result
```php
array (
  'sub_id' => '735635622',
  'email' => 'dummy@gmail.com',
  'gender' => 'm',
  'birthyear' => 1985,
  'first_name' => 'Max',
  'last_name' => 'Rockatansky',
  'zip' => '42180',
  'education_level' => 2,
  'occupation' => 3,
  'children_under18' => 2,
  'marital_status' => 3,
  'lang' => 'SPA',
  'lang2' => 'ENG',
  'country' => 'ES',
  'answers' =>
            array (
                
                [
                  'question_id' => 641,
                  'options' => ['28325']
                ],
                [
                  'question_id' => 15297,
                  'options' => ['29656']
                ],
                [
                  'question_id' => 642,
                  'options' => ['28330']
                ],
                [
                  'question_id' => 643,
                  'options' => ['28366', '28368']
                ]
            ),
)
```

Delete user from Wannads Surveys.

```php
<?php

use WannadsApiClient;

$wannadsApiClient = new WannadsApiClient(API_KEY, API_SECRET);
$result = $wannadsApiClient->deleteSurveyUser($userId);
```

Get available surveys for a user.

```php
<?php

use WannadsApiClient;

$wannadsApiClient = new WannadsApiClient(API_KEY, API_SECRET);
$surveys = $wannadsApiClient->getSurveys($userId);
```

Result

```php
array(
      [
        "id" => "2159251",
        "title" => "Temas de consumo",
        "description" => "",
        "loi"=> 22,
        "revenue" => 0.7,
        "virtual_currency_value" => 49,
        "virtual_currency" => "points",
        "img_url" => "http://wannads.imgix.net/https%3A%2F%2Fs3-eu-west-1.amazonaws.com%2Fwannads-bucket%2Fcampaigns%2FINTLsurvey-api-3.png?ixlib=java-1.1.0&s=7425961f628c33da6c17fb96f75b3acf",
        "offer_url" => "https://www.wannads.com/prclk/59b10f705e44466fb4e4fbe3bd0b0f0e",
        "expiry_date" => "2016-03-07T10:54:16+0000",
        "currency" => "USD"
      ],
      [
        "id" => "2159312",
        "title" => "Opinión sobre concesionarios",
        "description" => "",
        "loi"=> 5,
        "revenue" => 0.5,
        "virtual_currency_value" => 37,
        "virtual_currency" => "points",
        "img_url" => "http://wannads.imgix.net/https%3A%2F%2Fs3-eu-west-1.amazonaws.com%2Fwannads-bucket%2Fcampaigns%2FINTLsurvey-api-3.png?ixlib=java-1.1.0&s=7425961f628c33da6c17fb96f75b3acf",
        "offer_url" => "https://www.wannads.com/prclk/59b10f705e44466fb4e4fbe3bd0b0f0e",
        "expiry_date" => "2016-03-07T10:54:16+0000",
        "currency" => "EUR"
      ]
  )
```

Get optional survey users questions.
[View codes](https://wannads.zendesk.com/hc/en-us/articles/208187985)

```php
<?php

use WannadsApiClient;

$wannadsApiClient = new WannadsApiClient(API_KEY, API_SECRET);
$questions = $wannadsApiClient->getUserProfileQuestions($code);
```

Result

```php
array(
      [
        {
          "id": 42,
          "name": "AGE",
          "question_text": "Por favor, indique su edad.",
          "question_type": "Numeric - Open-end"
        },
        {
          "id": 43,
          "name": "GENDER",
          "question_text": "¿Es usted…?",
          "question_type": "Single Punch"
        },
        {
          "id": 632,
          "name": "STANDARD_RELATIONSHIP",
          "question_text": "¿Cuál es su estado?",
          "question_type": "Single Punch"
        },
        {
          "id": 633,
          "name": "STANDARD_EDUCATION",
          "question_text": "¿Cuál es su nivel de educación?",
          "question_type": "Single Punch"
        },
        {
          "id": 638,
          "name": "STANDARD_PRIMARY_DECISION_MAKER",
          "question_text": "En su hogar, ¿es usted la persona que toma la mayoría de las decisiones de compra cotidiana?",
          "question_type": "Single Punch"
        }
      ]
  )
```

Get optional survey users questions options.

```php
<?php

use WannadsApiClient;

$wannadsApiClient = new WannadsApiClient(API_KEY, API_SECRET);
$questionOptions = $wannadsApiClient->getUserProfileQuestionsOptions($code, $questionId);
```

Result

```php
array(
      [
        {
          "id": 28287,
          "question_id": 632,
          "option_text": "Soltero/a, nunca he estado casado/a"
        },
        {
          "id": 28288,
          "question_id": 632,
          "option_text": "Casado/a"
        },
        {
          "id": 28289,
          "question_id": 632,
          "option_text": "Separado/a, divorciado/a o viudo/a"
        },
        {
          "id": 28290,
          "question_id": 632,
          "option_text": "Pareja de hecho / sala de estar con alguien"
        },
        {
          "id": 28291,
          "question_id": 632,
          "option_text": "Prefiero no contestar"
        }
      ]
  )
```

# TEST launch

```bash
phpunit --bootstrap vendor/autoload.php tests/WannadsApiClientTest.php
```