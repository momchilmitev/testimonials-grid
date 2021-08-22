<?php

require(__DIR__ . '/../config.php');

$url = $_SERVER['REQUEST_URI'];

if (stripos($url, '/') !== 0) {
    $url = "/$url";
}

$dbInstance = new DB();
$dbConnection = $dbInstance->connect($db);

if ($_SERVER['REQUEST_URI'] == '/posts' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $posts = getAllPosts($dbConnection);
    echo json_encode($posts);
}

function getAllPosts($db)
{
    $statement = $db->prepare('SELECT * FROM posts');
    $statement->execute();
    $result = $statement->setFetchMode(PDO::FETCH_ASSOC);
    return $statement->fetchAll();
}
