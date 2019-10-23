<?php
require_once('app/includes.php');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$config = array();
$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$config['determineRouteBeforeAppMiddleware'] = true;
$config['db']['driver']   = 'mysql'; //your mysql server
$config['db']['host']   = getIniProp('db_host'); //your mysql server
$config['db']['user']   = getIniProp('db_user'); //your mysql server username
$config['db']['pass']   = getIniProp('db_pass'); //your mysql server password
$config['db']['dbname'] = getIniProp('db_name'); //the mysql database to use
$config['db']['charset'] = 'utf8';
$config['db']['collation'] = 'utf8_unicode_ci';
$config['db']['prefix'] = '';
 //asdf
$app = new \Slim\App(['settings' => $config]);
$app->group('/questions', function () {
  //Get all questions
  $this->get('', function ($request, $response, $args) {
    $count = $request->getParam('count') !== null ? $request->getParam('count'):5;
    $questions = CyberChallenge\Question::inRandomOrder()->limit($count)->get();
    $response = $response->withJson($questions);
    return $response;
  });
});

$app->run();

?>
