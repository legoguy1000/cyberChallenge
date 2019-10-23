<?php
require_once(__DIR__.'/includes.php');


shell_exec("composer install");
shell_exec("composer dump-autoload");

?>
