<?php

function connect()
{
    $pdo = new PDO('mysql:'.HOST.';'.DBNAME, USER, PASS);
    return $pdo;
}

function authUser($data)
{
    $pdo = connect();
    $email = $data['email'];
    $emailDB = $pdo->query("SELECT email FROM users WHERE email = '$email'")->fetch(PDO::FETCH_ASSOC);
    if (empty($emailDB)) {
        $stmt = $pdo->prepare("INSERT INTO `users` (name, phone, email) VALUES (?, ?, ?)");
        $stmt->execute(array($data['name'], $data['phone'], $data['email']));
    }
    $userID = $pdo->query("SELECT id FROM users WHERE email = '$email'")->fetch(PDO::FETCH_ASSOC)['id'];
    $stmt = $pdo->prepare("INSERT INTO `orders` (user_id, street, home, part, appt, floor, comment, payment, callback)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($userID, $data['street'], $data['home'], $data['part'], $data['appt'], $data['floor'],
        $data['comment'], $data['payment'], $data['callback']));
    return $userID;
}

function sendMail($userID)
{
    $pdo = connect();
    $resultOrder = $pdo->query("SELECT * FROM orders WHERE user_id = $userID ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    $orderNumber = $pdo->query("SELECT * FROM orders WHERE user_id  = $userID")->rowCount();
    $payment = ($resultOrder['payment'] == "on") ? 'Оплата наличными.' : 'Оплата картой.';
    $callback = ($resultOrder['callback'] == "on") ? 'Мы вам перезвоним.' : '';
    switch ($orderNumber) {
        case "1":
            $orderNumber = 'Это ваш первый заказ.';
            break;
        default:
            $orderNumber = "Это уже ваш $orderNumber заказ.";
    }
    $orderNumberMail = ($orderNumber == 1) ? 'Это ваш первый заказ.' : "Это уже ваш $orderNumber заказ.";

    $mail = "Заказ №{$resultOrder['id']}
Ваш заказ будет доставлен по адресу: Ул. {$resultOrder['street']} {$resultOrder['home']} кв. {$resultOrder['part']}, корпус {$resultOrder['appt']}, этаж {$resultOrder['floor']}.
Ваш заказ: DarkBeefBurger за 500 рублей, 1 шт. $payment 
$orderNumberMail $callback
Дата и время заказа: {$resultOrder['date_order']}";
    file_put_contents('mail.txt', $mail);
}

function getUsers()
{
    $pdo = connect();
    $usersData = $pdo->query("SELECT * FROM users");
    echo "<table border='1'><tr><td>Имя пользователя</td><td>Телефон</td><td>Email</td><td>Заказы</td></tr>";
    foreach ($usersData as $key => $value) : ?>
        <tr>
            <td><?= $value['name'] ?></td>
            <td><?= $value['phone'] ?></td>
            <td><?= $value['email'] ?></td>
            <td>
                <form action="admin.php" method="get">
                    <input type='submit' name="<?= $value['id'] ?>" formmethod="post"
                           value="Показать заказы">
                </form>
            </td>
        </tr>
    <?php endforeach;
    echo '</table>';
}

function getOrders($id)
{
    $pdo = connect();
    $email = $pdo->query("SELECT email FROM users WHERE id = $id")->fetch(PDO::FETCH_ASSOC);
    $dataOrders = $pdo->query("SELECT * FROM orders WHERE  user_id = $id");
    echo "Заказы пользователя с E-mail: {$email['email']}  "; ?>
    <form action="admin.php" method="get">
        <input type='submit' name="back" formmethod="post"
               value="Назад">
    </form>
    <?php
    echo "<table border='1'><tr><td>Номер заказа</td><td>Адрес</td><td>Комментарий</td></tr>";
    if (array_search('Назад', $_POST)) {
        unset($_POST);
    }
    foreach ($dataOrders as $value) : ?>
        <tr>
            <td><?= $value['id'] ?></td>
            <td><?php echo "Ул. {$value['street']} {$value['home']} кв. {$value['part']}, корпус {$value['appt']}, этаж {$value['floor']}" ?></td>
            <td><?= $value['comment'] ?></td>
        </tr>
    <?php endforeach;
    echo '</table>';
}