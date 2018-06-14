<?php
include('config.php');
include('db.php');

$id = array_search('Показать заказы', $_POST);
if (!$id) {
    getUsers();
} else {
    getOrders($id);
}
