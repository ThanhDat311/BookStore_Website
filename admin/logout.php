<?php
require_once dirname(__DIR__) . '/config/app.php';
session_start();
session_unset();
session_destroy();
header('Location: ' . APP_URL . '/authentication-login.php');
exit();