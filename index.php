<?php
include 'config.php';
include 'auth.php';
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if ($_POST['submit']) {
    $userID = authUser($_POST);
    sendMail($userID);
}

include 'view.php';
