# Wannads API PHP Client

http://test.api.wannads.com

## Installation

Run the following command to install the package and add it as a requirement to your project's `composer.json`:

```bash
composer require wannads/wannads-api-client
```

## Examples

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