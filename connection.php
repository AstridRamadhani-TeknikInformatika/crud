<?php
header('Access-Control-Allow-Origin: https://tugas6-pweb-git-master-astridramadhani-teknikinformatika.vercel.app');
header('Access-Control-Allow-Header: Content-Type');
header('Access-Control-Allow-Method: GET, POST, OPTION');
function getConnection()
{
    $host = 'localhost';
    $dbname = 'crud';
    $username = 'root';
    $password = '';

    try {
        $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>