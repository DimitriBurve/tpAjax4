<?php

use Slim\Http\Request;
use Slim\Http\Response;


$users = [];

array_push($users,array("toto","toto"));

// Routes

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
//    die();
    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/getToken', function (Request $request, Response $response, array $args){
    $token = sha1(date('Y-m-d'));
//    die();
    return $response->withJson(array("token"=>$token));
});

$app->post('/login', function (Request $request, Response $response, array $args){
    $token = sha1(date('Y-m-d'));
    $posts_data = $request->getParsedBody();
    $id = $posts_data["id"];
    $pwd = $posts_data["pwd"];
    $tokenClient = $posts_data["token"];

    global $users;

//    var_dump($posts_data);
//    var_dump($tokenClient);
    if ($token == $tokenClient){
        $testTmp = false;
        for ($i=0; $i< sizeof($users);$i++){
            if ($users[$i][0]== $id && $users[$i][1] == $pwd){
                $testTmp =true;
                break;
            }
        }
        if ($testTmp==true) {
            $res = true;
            return $response->withJson(array("res" => $res));
        }else{
            $res = false;
            return $response->withJson(array("res"=>$res));
        }
    }else{
        $res = false;
        return $response->withJson(array("res"=>$res));
    }
});

$app->post('/register', function (Request $request, Response $response, array $args){
    $posts_data = $request->getParsedBody();
    $id = $posts_data["id"];
    $pwd = $posts_data["pwd"];

    global $users;
//    var_dump($users);
    $testTemp = true;
    for ($i = 0; $i < sizeof($users); $i++) {
        if ($users[$i][0] === $id) {
            $testTemp = true;
            break;
        }else {
            $testTemp = false;
        }
    }
    if ($testTemp == false) {
        array_push($users,array($id,$pwd));
        return $response->withJson(array("res"=>true));
    }else{
        return $response->withJson(array("res"=>false));
    }
});
