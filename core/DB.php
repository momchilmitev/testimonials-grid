<?php

class DB
{
    public function connect($db)
    {
        try {
            $conn = new PDO("mysql:host={$db['host']};dbname=blog", $db['user'], $db['password']);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}
