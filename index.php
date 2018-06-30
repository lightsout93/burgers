<?php
include 'config.php';
include 'db.php';

error_reporting(E_ERROR | E_WARNING | E_PARSE);

if (!empty($_POST['email']) && strpos($_POST['email'], '@') !== false) {
    $userID = authUser($_POST);
    sendMail($userID, $_POST['email']);
}
$loader = new Twig_Loader_Filesystem(__DIR__.'/');
$twig = new Twig_Environment($loader);
echo $twig->render('view.html', []);
