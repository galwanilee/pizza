<?php
include_once 'db.php';
if (isset($_POST['phone']) && isset($_POST['password'])) {
    if ($result = $mysqli->query("SELECT * FROM users;")) {
        $data = [];
        foreach ($result as $row) {
            if ($row["phone"] == $_POST['phone'] && $row["password"] == $_POST['password']) {
                $data['id_user'] = $row["id_user"];
                $data['phone'] = $row["phone"];
                $data['name'] = $row["name"];
                $data['password'] = $row["password"];
            }
        }
        if ($data === []) {
            echo 'error';
        } else {
            echo json_encode($data);
        }
    } else {
        echo 'error';
    }
}