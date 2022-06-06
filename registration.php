<?php
include_once 'db.php';
if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['password'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $data = [];

    if ($result = $mysqli->query("INSERT INTO users(password, name, phone) "."VALUES ". "('$password','$name','$phone')")) {
        $data['phone'] = $phone;
        $data['password'] = $password;
        echo json_encode($data);
    } else {
        //echo $mysqli->error;
        echo 'error';
    }
}
