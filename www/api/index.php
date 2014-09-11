<?php

require_once 'DbHandler.php';
//require_once '../include/PassHash.php';
require '../Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();


/**
 * Listing all tasks of particual user
 * method GET
 * url /tasks          
 */
		$app->get('/locals', function() use ($app) {
            $response = array();
            $db = new DbHandler();
            // fetching all user tasks
            $result = $db->locales();
            $response["error"] = false;
            $response["tasks"] = array();
            // looping through result and preparing tasks array
            while ($task = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["id"] = $task["id"];
                $tmp["task"] = $task["task"];
                $tmp["status"] = $task["status"];
                $tmp["createdAt"] = $task["created_at"];
                array_push($response["tasks"], $tmp);
            }
            echoRespnse(200, $response);
        });
/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

$app->run();
?>