<?php

session_start();
require_once("../Model/dbConfig.php");


session_destroy();
header("Location: ../View/login.html");
exit;


?>