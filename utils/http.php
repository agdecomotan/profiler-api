<?php
namespace AGD\Profiler;
class Http
{
    public static function SetDefaultHeaders($method)
    {
        // HTTP headers for response
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: ' . $method);
        header('Content-Type: application/json; charset=UTF-8');
    }

    public static function HandleOption()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {     
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");         
        
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        
            exit(0);
        }
    }
  
    public static function ReturnSuccess($payload)
    {
        // Reply with successful response
        header('HTTP/1.1 200 OK');
        echo json_encode($payload);
    }
    public static function ReturnCreated($location, $payload)
    {
        // Reply with successful response
        header('HTTP/1.1 201 Created');
        header('Location: ' . $location);
        echo json_encode($payload);
    }
    public static function ReturnError($status, $payload)
    {
        // Reply with error response
        switch ($status) {
            case 400:
                header('HTTP/1.1 400 Bad Request');
                break;
            case 401:
                header('HTTP/1.1 401 Unauthorized');
                break;
            case 404:
                header('HTTP/1.1 404 Not Found');
                break;
            case 405:
                header('HTTP/1.1 405 Method Not Allowed');
                break;
            default:
                header('HTTP/1.1 500 Internal Server Error');
        }
        echo json_encode($payload);
    }
}