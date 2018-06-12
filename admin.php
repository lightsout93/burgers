<?php
include('config.php');
include('auth.php');

$id = array_search('Показать заказы', $_POST);
if (!$id) {
    getUsers();
} else {
    getOrders($id);
}
