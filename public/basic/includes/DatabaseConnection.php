<?php
    $pdo = new PDO('mysql:host=localhost;dbname=php_study;charset=utf8', 'jaeho', '1234');

    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);