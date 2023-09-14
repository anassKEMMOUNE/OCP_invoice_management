<?php

session_start();
require_once("../Model/dbConfig.php");

session_unset();
session_destroy();
header("Location: ../View/login.html");
exit;


?>