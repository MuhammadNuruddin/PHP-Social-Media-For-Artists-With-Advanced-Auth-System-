<?php 
require_once 'core/init.php';


$user = new User();
$user->logout();
session_unset();
session_destroy();
Redirect::to('index.php');