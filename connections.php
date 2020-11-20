<?php
$_DATABASE['host'] = '63070092-db.mysql.database.azure.com';
$_DATABASE['database'] = 'itflab';
$_DATABASE['username'] = 'tigerza117@63070092-db';
$_DATABASE['password'] = '0880880880Za';
$_DATABASE['port'] = "3306";
$_DATABASE['charset'] = 'utf8mb4';
//You can't connection XD Azure close my db
$options = [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES => false,
];

$_DATABASE['dsn'] = "mysql:host=" . $_DATABASE['host'] . ";dbname=" . $_DATABASE['database'] . ";charset=" . $_DATABASE['charset'] . ";port=" . $_DATABASE['port'];
try {
    $conn = new \PDO($_DATABASE['dsn'], $_DATABASE['username'], $_DATABASE['password'], $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}
