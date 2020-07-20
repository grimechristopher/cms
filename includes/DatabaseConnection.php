<?php
$pdo = new PDO('mysql:host=localhost;dbname=cms;charset=utf8', '_username_', '_password_');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);