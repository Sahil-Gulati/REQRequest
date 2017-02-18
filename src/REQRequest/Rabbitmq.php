<?php
namespace REQRequest;
\REQRequest\Rabbitmq_Loader::registerLoader();
/**
 * @author Sahil Gulati <sahil.gulati1991@outlook.com>
 * @method array getCompleteInfo() Get complete information of the rabbitmq
 * @method array listExtensions() Get list of extensions of the rabbitmq management
 * @method array getExtensions() Get list of extensions of the rabbitmq management
 * @method array whoami() Get information on particular user
 * @method array getExchangeInfo(String $vhost,String $exchange_name) Get queue information on the basis of queue name and virtual host
 * Queues
 * @method array getQueues(String $vhost) Get list of all queues present in particular virtual host if vhost is empty all queues will be returned
 * @method array listQueues(String $vhost) Get list of all queues present in particular virtual host if vhost is empty all queues will be returned
 * @method array getQueueInfo(String $vhost,String $queue_name) Get queue information on the basis of queue name and virtual host
 * @method void createQueue(String $queue_name, Boolean $durable,Boolean $auto_delete) Creates queue in the given vhost
 * @method void makeQueue(String $queue_name, Boolean $durable=true,Boolean $auto_delete=true) Creates queue in the given vhost
 * @method void deleteQueue(String $queue_name) Delete queue in the given vhost
 * @method void removeQueue(String $queue_name) Delete queue in the given vhost
 * @method void purgeQueue(String $queue_name) Delete queue in the given vhost
 * @method void getMessage(String $vhost,String $queue_name,Boolean $redeliver,Int $count,String $encoding) Gets a message from a queue
 * @method void retrieveMessage(String $vhost,String $queue_name,Boolean $redeliver,Int $count,String $encoding) Gets a message from a queue
 * Exchanges
 * @method array getExchanges(String $vhost) Get list of all exchanges present in particular virtual host if vhost is empty all exchanges will be returned
 * @method array listExchanges(String $vhost) Get list of all exchanges present in particular virtual host if vhost is empty all exchanges will be returned
 * @method void createExchange(String $exchange_name, String $type, Boolean $durable,Boolean $auto_delete) Creates exchange in the given vhost
 * @method void makeExchange(String $exchange_name, String $type, Boolean $durable=true,Boolean $auto_delete=true) Creates exchange in the given vhost
 * @method void deleteExchange(String $exchange_name) Delete exchanges in the gtiven vhost
 * @method void removeExchange(String $exchange_name) Delete exchanges in the given vhost
 * VHosts
 * @method array getVHosts() Get list of all vhosts present
 * @method array listVHosts() Get list of all vhosts present
 * Parameters
 * @method array getParameters(String $component) Get list of all parameters present
 * @method array listParameters(String $component) Get list of all parameters present
 * Policies
 * @method array getPolicies(String $vhost) Get list of all policies present
 * @method array listPolicies(String $vhost) Get list of all policies present
 * @method array getPolicyInfo(String $vhost, String $name) Get policy information according to information specified via parameters.
 * @method array deletePolicy(String $vhost, String $name) Delete a policy from given virtual host and name.
 * @method array removePolicy(String $vhost, String $name) Delete a policy from given virtual host and name.
 * @method array setPolicy(String $vhost, String $name, String $pattern, Array $definition, Int $priority,String $apply_to) Creates a policy in a given virtual host.
 * @method array createPolicy(String $vhost, String $name, String $pattern, Array $definition, Int $priority,String $apply_to)  Creates a policy in a given virtual host.
 * Permissions
 * @method array getVHostsPermissions(String $vhost) Get list of all permissions present in vhosts
 * @method array listVHostsPermissions(String $vhost) Get list of all permissions present in vhosts
 * @method array getPermissions(String $vhost,String $username) Get permissions for all users
 * @method array listPermissions(String $vhost,String $username) Get permissions for all users
 * @method array createUserPermissions(String $vhost,String $username,String $configureRegex,String $readRegex,String $writeRegex) Set user's permission
 * @method array setUserPermissions(String $vhost,String $username,String $configureRegex,String $readRegex,String $writeRegex) Set user's permission
 * @method array removeUserPermissions(String $vhost,String $username,String $configureRegex,String $readRegex,String $writeRegex) Set user's permission
 * @method array unsetUserPermissions(String $vhost,String $username,String $configureRegex,String $readRegex,String $writeRegex) Set user's permission
 * @method array deleteUserPermissions(String $vhost,String $username,String $configureRegex,String $readRegex,String $writeRegex) Set user's permission
 * Users
 * @method array getUsers() Get list of all users present
 * @method array listUsers() Get list of all users present
 * @method array getUserInfo(String $username) Get user information for a particular user
 * @method array setUserInfo(String $username,String $password,String $tag) Create user of rabbitmq and sets its information
 * @method array createUser(String $username,String $password,String $tag) Create user of rabbitmq and sets its information
 * @method array deleteUser(String $username) Delete a username
 * @method array removeUser(String $username) Delete a username
 * Binding
 * @method array getBindings(String $vhost) Get list of all bindings
 * @method array listBindings(String $vhost) Get list of all bindings
 * @method void bind(String $vhost,String $exchange_name,String $queue_name, String $routing_key) Creates binding between an exchange and a queue with the given routing key
 * @method void createBinding(String $vhost,String $exchange_name,String $queue_name, String $routing_key) Creates binding between an exchange and a queue with the given routing key
 * @method void makeBinding(String $vhost,String $exchange_name,String $queue_name, String $routing_key) Creates binding between an exchange and a queue with the given routing key
 */
class Rabbitmq extends \REQRequest\Request
{
    public function __construct($login="guest",$password="guest",$host="localhost",$port=15672,$virtualHost="/")
    {
        parent::__construct($login, $password, $host, $port, $virtualHost);
    }

    public function __call($functionName, array $arguments=array())
    {
        if(in_array($functionName, \REQRequest\Constants::$validFunctions))
        {
            $functionName=\REQRequest\Constants::getCallableFunction($functionName);
            return call_user_func_array(array($this,$functionName), $arguments);
        }
    }
}
class Rabbitmq_Loader
{
    public static function registerLoader()
    {
        spl_autoload_register(array("\REQRequest\Rabbitmq_Loader","loader"));
    }
    public static function loader($className)
    {
        $classPath=rtrim(dirname(__FILE__),__NAMESPACE__);
        $className=str_replace("\\", "/", $className);
        $filePath=$classPath.$className.".php";
        if(file_exists($filePath))
        {
            require_once $filePath;
        }
    }
}