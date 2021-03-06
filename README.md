# REQRequest
REQRequest is Rabbitmq Exchange Queue Request. This library is not only bound to exchanges, queues, but you can define parameters of policy of federation, shovel etc. and it is based on Rabbitmq v3.3.4 HTTP.

## Installation
`composer require sahil-gulati/reqrequest`

<b>OR</b>
``` javascript
{
    "require": {
        "sahil-gulati/reqrequest": "^1.0"
    }
}
```
## Usage
```php
<?php

use REQRequest\Rabbitmq;
require 'vendor/autoload.php';

$request= new Rabbitmq();
$result=$request->listQueues();
print_r($result);
?>

```

## List of methods, alias and description
Method Name | Alias | Description
------------|-------|------------
getQueues($vhost)|listQueues(...)|To get the list of queues in all vhosts or in a given vhost.
getExchanges($vhost)|listExchanges(...)| To get the list of exchanges in all vhosts or in a given vhost.
getVHosts()|listVHosts()|To get the list of vhosts
getPolicies($vhost)|listPolicies(...)| To get the list of all policies in the given vhost
getParameters($component)|listParameters(...)| To get list of all parameters present for a given component
getBindings($vhost)|listBindings(...)|To get list of all bindings
createQueue($queueName,$durable,$autoDelete)|makeQueue(...)|To create a queue with given parameters
createExchange($exchangeName,$type,$durable,$autoDelete)|makeExchange(...)|To create an exchange with given parameters
createPolicy($vhost,$name,$pattern,$definition,$priority,$applyTo)|setPolicy(...)|Creates a policy in a given virtual host.
createUserPermissions($vhost,$username,$configRegex,...)|unsetUserPermissions(...),<br/>removeUserPermissions(...)|To create a user permission with speciifed parameters.
deleteQueue($queueName)|removeQueue(...)|To remove a specified queue
deleteExchange($exchangeName)|removeExchange(...)| TO remove an specified exchange
deletePolicy($vhost,$name)|removePolicy(...)|To remove a policy with specified vhost and policy name
deleteUser($username)|removeUser(...)|To remove a specified user
purgeQueue($queueName)||Purge's a given queue.
getMessage($vhost,$queueName,$redeliver,$count,$encoding)|retrieveMessage(...)| Get no. of messages specified from a given queue
getPolicyInfo($vhost,$name)|| Get policy information according to specified parameters.
getUserInfo($username)||Get information for a particular user
getCompleteInfo()||Get complete information of the rabbitmq
.....|.....|......
