<?php

$mysqli = new mysqli("127.0.0.1:3306", "u329960370_pizza",
    "", "u329960370_pizza_house");
if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
    exit();
}
