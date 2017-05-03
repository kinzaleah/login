<!DOCTYPE html>

<html>
    <head>
    <title>My first PHP Website</title>
    </head>
    <body>
        <?php
            echo "<p>Hello World!</p>";
        ?>

        <p><a href ="login.php">Click here to log in</a></p>
        <p><a href ="register.php">Click here to register</a></p>
    </body>
</html>

<?php
//pdo stuff
$host = 'localhost:3306';
$db   = 'login';
$user = 'root';
$pass = 'root';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);





?>
