# BankID

### Packagist.org
https://packagist.org/packages/hajarrashidi/bankid
```bash
composer require hajarrashidi/bankid
```

## Description:

PHP Composer package for BankID, supports v6.0 with QR and App link support. 

## [Web service API:](https://www.bankid.com/utvecklare/guider/teknisk-integrationsguide/webbservice-api)
- **BankID v6.0 production** 
- **BankID v6.0 development** 

## Requirements:

* [Composer](https://getcomposer.org/)
* PHP >= 7.2

## [Interface description:](https://www.bankid.com/utvecklare/guider/teknisk-integrationsguide/webbservice-api)

- [x] /auth
- [x] /collect
- [x] /cancel
- [x] /sign
- [x] /phone/auth
- [x] /phone/sign
- [ ] Errors

## Helper methods:

- [x] QR-code generator
- [x] App-link generator 

---

## Code example:
```php
<?php
// If you don't have Composer autoload
require_once __DIR__ . '/vendor/autoload.php';

use BankID\v_6_0\Bankid_6_0_dev;

$bankid = new Bankid_6_0_dev([
    'verify' => false,
    'headers' => [
        'Content-Type' => 'application/json',
    ],
    'cert' => __DIR__ . '/bankid_test_cert.pem'
]);

$response = $bankid->auth([ 'endUserIp' => "127.0.0.1" ]);
//$response = $bankid->sign([ 'endUserIp' => "127.0.0.1", 'userVisibleData' => base64_encode("hello") ]);
//$response = $bankid->phoneSign([ 'personalNumber' => "111122334444", "userVisibleData" => base64_encode("hello"), "callInitiator" => "user"]);
//$response = $bankid->phoneAuth([ 'personalNumber' => "111122334444", "callInitiator" => "user"]);

var_dump($response);
```
financial support:
https://patreon.com/hajarrashidi
