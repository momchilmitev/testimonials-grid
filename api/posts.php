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

if ($_SERVER['REQUEST_URI'] == '/posts' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = $_POST;
    $postID = addPost($input, $dbConnection);

    if ($postID) {
        $input['id'] = $postID;
        $input['link'] = "/posts/$postID";
    }

    echo json_encode($input);
}

function getAllPosts($db)
{
    $statement = $db->prepare('SELECT * FROM posts');
    $statement->execute();
    $result = $statement->setFetchMode(PDO::FETCH_ASSOC);
    return $statement->fetchAll();
}

function addPost($postData, $db)
{
    $sql = "INSERT INTO posts (title, status, content, user_id) VALUES (:title, :status, :content, :user_id)";

    $statement = $db->prepare($sql);
    bindValues($statement, $postData);
    $statement->execute();

    return $db->lastInsertId();
}

function bindValues($statement, $params)
{
    $allowedFields = ['title', 'status', 'content', 'user_id'];

    foreach ($params as $param => $value) {
        if (in_array($param, $allowedFields)) {
            $statement->bindValue(':' . $param, $value);
        }
    }

    return $statement;
}
