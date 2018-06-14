<?php
include 'config.php';
include 'db.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE);

if (!empty($_POST['email']) && strpos($_POST['email'], '@') !== false) {
    $userID = authUser($_POST);
    sendMail($userID);
}

include 'view.php';
