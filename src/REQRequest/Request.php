<?php
namespace REQRequest;
/**
 * This class's role is to generate request URL and send request for the particular action
 * @author Sahil Gulati <sahil.gulati1991@outlook.com>
 */
class Request
{
    private static $login="guest";
    private static $password="guest";
    private static $host="localhost";
    private static $port=15672;
    private static $virtualHost="/";
    
    /**
     * This will only initiate variables
     * @param String $login
     * @param String $password
     * @param String $host
     * @param String $port
     * @param String $virtualHost
     */
    public function __construct($login="guest",$password="guest",$host="localhost",$port=15672,$virtualHost="/")
    {
        self::$login=$login;
        self::$password=$password;
        self::$host=$host;
        self::$port=$port;
        self::$virtualHost=$virtualHost;
    }
    
    protected static function __request($uri,$requestMethod="GET",array $postFields=array())
    {
        $url="http://".self::$host.":".  self::$port.$uri;
        $curlResource=  curl_init();
        curl_setopt($curlResource, CURLOPT_URL, $url);
        curl_setopt($curlResource, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlResource, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($curlResource, CURLOPT_USERNAME, self::$login);
        curl_setopt($curlResource, CURLOPT_PASSWORD, self::$password);
        if(is_array($postFields) && count($postFields)>0 & $requestMethod!='GET')
        {
            curl_setopt($curlResource, CURLOPT_POSTFIELDS, json_encode($postFields));
            curl_setopt($curlResource, CURLOPT_CUSTOMREQUEST, $requestMethod);
        }
        return curl_exec($curlResource);
    }
    
    private static function generateUri($functionName,$requestMethod="GET",array $postFields=array())
    {
        $appendUri="";
        switch ($functionName)
        {
            case "list_users":
            case "list_extensions":
            case "get_info":
            case "whoami":
                return \REQRequest\Constants::getUrl($functionName);
            case "get_message";
                return \REQRequest\Constants::getUrl($functionName)."/".  urlencode($postFields["vhost"])."/".$postFields["name"]."/get";
            case "list_queues":
            case "list_exchanges":
            case "list_policies":
            case "list_bindings":
                $appendUri=!empty($postFields["vhost"]) ? "/".urlencode($postFields["vhost"]) : "";
            case "list_vhosts":
                return \REQRequest\Constants::getUrl($functionName).$appendUri;
            case "create_queue":
            case "delete_queue":
            case "create_exchange":
            case "delete_exchange":
            case "create_policy":
            case "delete_policy":
            case "queue_info":
            case "exchange_info":
            case "get_policy_info":
            case "list_user_permissions":
            case "unset_user_permissions":
            case "set_user_permissions":
                return \REQRequest\Constants::getUrl($functionName)."/".  urlencode($postFields["vhost"])."/".$postFields["name"];
            case "create_binding":
                return \REQRequest\Constants::getUrl($functionName)."/".  urlencode($postFields["vhost"])."/e/".$postFields["exchange"]."/q/".$postFields["queue"];
            case "list_permissions":
                return \REQRequest\Constants::getUrl($functionName)."/".  urlencode($postFields["vhost"])."/permissions";
            case "delete_user":
            case "get_user_info":
            case "set_user_info":
                return \REQRequest\Constants::getUrl($functionName)."/".  urlencode($postFields["name"]);
            case "list_parameters":
                $appendUri=!empty($postFields["name"]) ? "/".$postFields["name"] : "";
                return \REQRequest\Constants::getUrl($functionName). $appendUri;
            case "purge_queue":
                
                
        }
    }
    
    private static function getResult($functionName,$requestMethod="GET",array $postFields=array())
    {
        switch ($functionName)
        {
            case "list_users":
            case "list_queues":
            case "list_vhosts":
            case "list_permissions":
            case "list_parameters":
            case "list_policies":
            case "list_extensions":
            case "list_user_permissions":
            case "unset_user_permissions":
            case "list_exchanges":
            case "list_bindings":
            case "create_binding":
            case "create_policy":
            case "create_queue":
            case "queue_info":
            case "exchange_info":
            case "delete_queue":
            case "delete_exchange":
            case "delete_user":
            case "create_exchange":
            case "create_policy":
            case "delete_policy":
            case "purge_queue":
            case "get_message":
            case "get_info":
            case "get_user_info":
            case "get_policy_info":
            case "set_user_permissions":
            case "set_user_info":
            case "whoami":
            return self::__request(
                    self::generateUri(
                        $functionName,
                        $requestMethod,
                        $postFields),
                    $requestMethod,
                    $postFields);
            
        }
    }
    protected function list_queues($virtualHost="")
    {
        $list=array();
        $result=json_decode(self::getResult(__FUNCTION__,"GET",array("vhost" => $virtualHost)));
        foreach ($result as $queueInfo)
        {
            $list[$queueInfo->vhost][]=$queueInfo->name;
        }
        return $list;
    }
    protected function list_vhosts()
    {
        $list=array();
        $response=self::getResult(__FUNCTION__);
        foreach ($response as $vhostInfo)
        {
            $list[]=$vhostInfo->name;
        }
        return $list;
    }
    protected function list_exchanges($virtualHost="")
    {
        $list=array();
        $response=  json_decode(self::getResult(__FUNCTION__,"GET",array("vhost"=>$virtualHost)));
        foreach ($response as $vhostInfo)
        {
            $vhostInfo->name=!empty($vhostInfo->name) ? $vhostInfo->name : "amq.default";
            $list[$vhostInfo->vhost][]=$vhostInfo->name;
        }
        return $list;
    }
    protected function list_bindings($virtualHost="")
    {
        $list=array();
        $result= self::getResult(__FUNCTION__, "GET",array("vhost"=>$virtualHost));
        $result=json_decode($result);
        if(is_array($result) && count($result)>0)
        {
            foreach($result as $bindingsData)
            {
                $bindingsData->source = empty($bindingsData->source) ? "amq.default" : $bindingsData->source;
                $list[$bindingsData->vhost]["exchange_and_".$bindingsData->destination_type][$bindingsData->destination][]=array(
                                                                                                    "exchange"=>$bindingsData->source,
                                                                                                    "routing_key"=>$bindingsData->routing_key);
            }
        }
        return $list;
    }
    protected function list_users()
    {
        $result= self::getResult(__FUNCTION__, "GET");
        $result=json_decode($result);
        return $result;
    }
    protected function list_extensions()
    {
        $result= self::getResult(__FUNCTION__, "GET");
        $result=json_decode($result,true);
        return $result;
    }
    protected function create_queue($queueName,$durable=true,$auto_delete=true)
    {
        return self::getResult(__FUNCTION__,"PUT",  array(
            "vhost"=>  self::$virtualHost,
            "name"=>$queueName,
            "durable"=>$durable,
            "auto_delete"=>$auto_delete));
    }
    protected function create_exchange($exchangeName,$type="direct",$durable=true,$auto_delete=true)
    {
        return self::getResult(__FUNCTION__,"PUT",  array(
            "vhost"=>  self::$virtualHost,
            "name"=>$exchangeName,
            "type"=>$type,
            "durable"=>$durable,
            "auto_delete"=>$auto_delete));
    }
    protected function create_binding($vhost,$exchangeName,$queueName,$routingKey="",$arguments=array())
    {
        if(!empty($vhost) && !empty($exchangeName) && !empty($queueName))
        {
            return self::getResult(__FUNCTION__, "POST", array(
                "vhost"=>$vhost,
                "exchange"=>$exchangeName,
                "queue"=>$queueName,
                "routing_key"=>$routingKey
            ));
        }
        return false;
    }
    protected function create_policy($vhost,$policyName,$pattern="",array $definition=array(),$priority=0,$apply_to="all")
    {
        if(!empty($vhost) && !empty($policyName) && !empty($pattern) && count($definition)>0)
        {
            return self::getResult(__FUNCTION__, "PUT", array(
                "vhost"=>$vhost,
                "name"=>$policyName,
                "priority"=>$priority,
                "apply-to"=>$apply_to,
                "pattern"=>$pattern,
                "definition"=>$definition
            ));
        }
    }
    protected function delete_exchange($exchangeName)
    {
        $result= self::getResult(__FUNCTION__, "DELETE",array(
            "name"=>$exchangeName
        ));
        return $result;
    }
    protected function delete_queue($queueName)
    {
        $result= self::getResult(__FUNCTION__, "DELETE",array(
            "name"=>$queueName
        ));
        return $result;
    }
    protected function delete_policy($vhost,$policyName)
    {
        if(!empty($vhost) && !empty($policyName))
        {
            $result= self::getResult(__FUNCTION__, "DELETE",array(
                "vhost"=>$vhost,
                "name"=>$policyName
            ));
        }
        return false;
    }
    protected function delete_user($username)
    {
        if(!empty($username))
        {
            $result= self::getResult(__FUNCTION__, "DELETE",array(
                "name"=>$username
            ));
            return $result;
        }
        return false;
    }
    protected function purge_queue()
    {
        
    }
    protected function queue_info($vhost,$queueName)
    {
        $result= self::getResult(__FUNCTION__, "GET",array(
            "name"=>$queueName,
            "vhost"=>$vhost
        ));
        return json_decode($result,true);
    }
    protected function exchange_info($vhost="",$exchangeName="")
    {
        if(empty($exchangeName))
            return false;
        $result= self::getResult(__FUNCTION__, "GET",array(
            "name"=>$exchangeName,
            "vhost"=>$vhost
        ));
        return json_decode($result,true);
    }
    protected function get_message($vhost,$queue_name,$requeue=true,$count=1,$encoding="auto")
    {
        if(empty($queue_name))
            return false;
        $result=  self::getResult(__FUNCTION__,"POST",array("vhost"=>$vhost,"name"=>$queue_name,"requeue"=>$requeue,"count"=>$count,"encoding"=>$encoding));
        return json_decode($result,true);
    }
    protected function get_info()
    {
        $result=self::getResult(__FUNCTION__);
        return json_decode($result,true);
    }
    protected function whoami()
    {
        $result=self::getResult(__FUNCTION__);
        return json_decode($result,true);
    }
    protected function list_permissions($vhost)
    {
        if(empty($vhost))
        {
            return false;
        }
        $result=self::getResult(__FUNCTION__,"GET",array("vhost"=>$vhost));
        return json_decode($result,true);
    }
    protected function list_user_permissions($vhost,$user)
    {
        if(empty($vhost) || empty($user))
        {
            return false;
        }
        $result=self::getResult(__FUNCTION__,"GET",array("vhost"=>$vhost,"name"=>$user));
        return json_decode($result,true);
    }
    protected function set_user_permissions($vhost,$user,$configure=".*",$read=".*",$write=".*")
    {
        if(empty($vhost) || empty($user))
        {
            return false;
        }
        $result=self::getResult(__FUNCTION__,"PUT",array("vhost"=>$vhost,"name"=>$user,"configure"=>$configure,"read"=>$read,"write"=>$write));
        return json_decode($result,true);
    }
    
    protected function set_user_info($username,$password,$tags="monitoring")
    {
        if(empty($password) || empty($username))
        {
            return false;
        }
        $result=self::getResult(__FUNCTION__,"PUT",array("password"=>$password,"name"=>$username,"tags"=>$tags));
        return json_decode($result,true);
    }
    protected function unset_user_permissions($vhost,$user,$configure="",$read="",$write="")
    {
        if(empty($vhost) || empty($user))
        {
            return false;
        }
        $result=self::getResult(__FUNCTION__,"DELETE",array("vhost"=>$vhost,"name"=>$user,"configure"=>$configure,"read"=>$read,"write"=>$write));
        return json_decode($result,true);
    }
    protected function list_parameters($component="")
    {
        $result=self::getResult(__FUNCTION__,"GET",array(
            "name"=>$component
        ));
        return json_decode($result,true);
    }
    protected function list_policies($vhost="")
    {
        $result=self::getResult(__FUNCTION__,"GET",array("vhost"=>$vhost));
        return json_decode($result,true);
    }
    protected function get_policy_info($vhost="" , $name="")
    {
        if(empty($vhost)|| empty($name))
        {
            return false;
        }
        $result=self::getResult(__FUNCTION__,"GET",array("vhost"=>$vhost,"name"=>$name));
        return json_decode($result,true);
    }
    protected function get_user_info($username="")
    {
        if(!empty($username))
        {
            $result=self::getResult(__FUNCTION__,"GET",array("name"=>$username));
            return json_decode($result,true);
        }
    }
}