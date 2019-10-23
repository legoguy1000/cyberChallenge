<?php
use Illuminate\Database\Capsule\Manager as Capsule;
ini_set("error_reporting", E_ALL);
ini_set("expose_php", false);



$root = __DIR__;
require_once($root.'/vendor/autoload.php');
require_once($root.'/functions/getConfigFile.php');

$capsule = new Capsule;
$capsule->addConnection(array("driver" => "mysql", "host" =>getIniProp('db_host'), "database" => getIniProp('db_name'), "username" => getIniProp('db_user'), "password" => getIniProp('db_pass')));
$capsule->setAsGlobal();
$capsule->bootEloquent();



?>
