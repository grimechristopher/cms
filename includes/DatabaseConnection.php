<?php
$pdo = new PDO('mysql:host=localhost;dbname=cms;charset=utf8', 'root', 'pgGrime06');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);