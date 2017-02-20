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
$result=$request->listQueues();
print_r($result);
?>

```

##List of methods and description

Method Name | Alias | Description
------------|-------|------------
getQueues($vhost)|listQueues(...)|To get of list of queues in all vhosts or in a given vhost.
createQueue($queueName,$durable,$autoDelete)|makeQueue(...)|To create a queue with given parameters
deleteQueue($queueName)|removeQueue(...)|To remove queue a specified queue
