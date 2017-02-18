<?php
namespace REQRequest;
/**
 * @author Sahil Gulati <sahil.gulati1991@outlook.com>
 */
class Constants
{
    public static $validFunctions=array(
        "listQueues",
        "getQueues",
        "listVHosts",
        "getVHosts",
        "listExchanges",
        "getExchanges",
        "createQueue",
        "makeQueue",
        "createExchange",
        "makeExchange",
        "getBindings",
        "listBindings",
        "deleteExchange",
        "removeExchange",
        "deleteQueue",
        "removeQueue",
        "getQueueInfo",
        "getExchangeInfo",
        "getMessage",
        "retrieveMessage",
        "getCompleteInfo",
        "bind",
        "createBinding",
        "makeBinding",
        "whoami",
        "getUsers",
        "listUsers",
        "getVHostsPermissions",
        "listVHostsPermissions",
        "getPermissions",
        "listPermissions",
        "createUserPermissions",
        "setUserPermissions",
        "removeUserPermissions",
        "unsetUserPermissions",
        "deleteUserPermissions",
        "getComponents",
        "getParameters",
        "listParameters",
        "getPolicies",
        "listPolicies",
        "getPolicyInfo",
        "setPolicy",
        "createPolicy",
        "deletePolicy",
        "removePolicy",
        "listExtensions",
        "getExtensions",
        "deleteUser",
        "removeUser",
        "getUserInfo",
        "setUserInfo",
        "createUser",
        "purgeQueue"
    );
    public static function getUrl($functionName)
    {
        switch ($functionName)
        {
            case "list_extensions":
                return "/api/extensions";
            case "list_users":
            case "delete_user":
            case "get_user_info":
            case "set_user_info":
                return "/api/users";
            case "list_queues":
            case "create_queue":
            case "delete_queue";
            case "queue_info":    
            case "get_message":    
            case "purge_queue":    
                return "/api/queues";
            case "list_vhosts":
            case "list_permissions":
                return "/api/vhosts";
            case "list_exchanges":
            case "create_exchange":
            case "delete_exchange":
            case "exchange_info":
                return "/api/exchanges";
            case "create_binding":
            case "list_bindings":
                return "/api/bindings";
            case "get_info":
                return "/api/overview";
            case "whoami":
                return "/api/whoami";
            case "list_user_permissions":
            case "unset_user_permissions":
            case "set_user_permissions":
                return "/api/permissions";
            case "list_parameters":
                return "/api/parameters";
            case "get_policy_info":
            case "list_policies":
            case "create_policy":
            case "delete_policy":
                return "/api/policies";
        }
    }
    public static function getCallableFunction($functionName)
    {
        switch ($functionName)
        {
            case "listQueues":
            case "getQueues":
                return "list_queues";
            case "listVHosts":
            case "getVHosts":
                return "list_vhosts";
            case "listExchanges":
            case "getExchanges":
                return "list_exchanges";
            case "getBindings":
            case "listBindings":
                return "list_bindings";
            case "createQueue":
            case "makeQueue":
                return "create_queue";
            case "createExchange":
            case "makeExchange":
                return "create_exchange";
            case "deleteQueue":
            case "removeQueue":
                return "delete_queue";
            case "deleteExchange":
            case "removeExchange":
                return "delete_exchange";
            case "getQueueInfo":
                return "queue_info";
            case "getExchangeInfo":
                return "exchange_info";
            case "getMessage":
            case "retrieveMessage":
                return "get_message";
            case "getCompleteInfo":
                return "get_info";
            case "bind":
            case "createBinding":
            case "makeBinding":
                return "create_binding";
            case "whoami":
                return "whoami";
            case "getUsers":
            case "listUsers":
                return "list_users";
            case "getVHostsPermissions":
            case "listVHostsPermissions":
                return "list_permissions";
            case "getPermissions":
            case "listPermissions":
                return "list_user_permissions";
            case "createUserPermissions":
            case "setUserPermissions":
                return "set_user_permissions";
            case "removeUserPermissions":
            case "setUserPermissions":
            case "unsetUserPermissions":
            case "removeUserPermissions":
                return "unset_user_permissions";
            case "getParameters":
            case "listParameters":
                return "list_parameters";
            case "getPolicies":
            case "listPolicies":
                return "list_policies";
            case "getPolicyInfo":
                return "get_policy_info";
            case "setPolicy":
            case "createPolicy":
                return "create_policy";
            case "deletePolicy":
            case "removePolicy":
                return "delete_policy";
            case "getExtensions":
            case "listExtensions":
                return "list_extensions";
            case "removeUser":  
            case "deleteUser":  
                return "delete_user";
            case "getUserInfo":  
                return "get_user_info";
            case "setUserInfo":  
            case "createUser":  
                return "set_user_info";
            case "purgeQueue":  
                return "purge_queue";
        }
    }
    
}