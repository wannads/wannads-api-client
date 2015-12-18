# Wannads API PHP Client

http://test.api.wannads.com

## Installation

Run the following command to install the package and add it as a requirement to your project's `composer.json`:

```bash
composer require wannads/wannads-api-client
```

## Examples

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
$user = $wannadsApiClient->getSurveyUser($userId);
```

# TEST launch

```bash
phpunit --bootstrap vendor/autoload.php tests/WannadsApiClientTest.php
```