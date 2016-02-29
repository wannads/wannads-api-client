# Wannads API PHP Client

http://test.api.wannads.com

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
$offers = $wannadsApiClient->getOffers($subId, $country, $ip, $fingerprint, $device, $category, $gender, $payment);
```

Available Parameters

| Name        | Type | Description           | Posible values  | Required  |
| ------------|:---|:-------------:|:------------:|:----:|
| $subId      | string |Corresponds to your unique user identifier. If this parameter is included the IP parameter is required |  | * |
| $country     | string |  Filters the list of offers to show just the offers available for that country. If the optional parameters sub_id and ip are included, this one is ignored and the country is obtained with the ip      |   null | * |
| $ip | string|   IP of the user.    |    null | * |
| $fingerprint | string |   Fingerprint of the user    |    null | no |
| $device | array() | Filters the list of offers to show the offers available to that device.     |    null | no |
| $category | array() |  	Filters the list of offers with offers of that category only     |    signups,surveys,iphoneapps,ipadapps,androidapps,dailysurveys,downloads | no |
| $gender | string | Filters the list of offers to show the ones availables only to that gender      |    null | no | 
| $payment | string | Filters the offers to show only the offers that require or not payment      |    null | no |

Response

```json
{
    "categories": [
      {
        "id": "8",
        "name": "A name"
      }
    ],
    "completed": 0,
    "conversion_point": "3",
    "conversion_time": {
      "id": 1,
      "description": "in minutes"
    },
    "description": "As team boss of a racing team you are responsible for all aspects of racing.",
    "device_completion_filter": "all",
    "device_view_filter": "all",
    "id": 12491,
    "payment_required": "0",
    "title": "UnitedGP - iPhone",
    "url_img": "http://www.example.org/a.png",
    "offer_url": "http://www.offer.org/",
    "revenue": 1.3,
    "currency": "USD",
    "virtual_currency_value": 25.2,
    "virtual_currency": "Tokens"
  }
```

#### Surveys

Create Wannads Surveys user.

```php
<?php

use WannadsApiClient;

$wannadsApiClient = new WannadsApiClient(API_KEY, API_SECRET);
$user = $wannadsApiClient->createSurveyUser($userId, $data);
```

Update Wannads Surveys user.

```php
<?php

use WannadsApiClient;

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

# TEST launch

```bash
phpunit --bootstrap vendor/autoload.php tests/WannadsApiClientTest.php
```