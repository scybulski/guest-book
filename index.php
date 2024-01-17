<?php

$connection = new PDO('mysql:host=mysql;dbname=guestbook', 'root', 'root');

echo "<pre>";
print_r($connection->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN));
echo "</pre>";
