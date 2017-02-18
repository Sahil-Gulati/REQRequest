# REQRequest
REQRequest is Rabbitmq Exchange Queue Request. This library is not only bound to exchanges, queues, but you can define parameters of policy of federation, shovel etc. and it is based on Rabbitmq v3.3.4 HTTP.

##Installation
`composer require sahil-gulati/reqrequest`

<b>OR</b>
``` javascript
{
    "require": {
        "sahil-gulati/reqrequest": "^1.0"
    }
}
```
##Usage
```php
<?php

use REQRequest\Rabbitmq;
require 'vendor/autoload.php';

$request= new Rabbitmq();
print_r($request->listQueues());
?>

```
