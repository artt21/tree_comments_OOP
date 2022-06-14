<?php

class Model{

    private Database $database;

    public function __construct(Database $database){
        $this->database = $database;
    }

    public function getComments(): array
    {

        $sql = "SELECT * FROM comments ORDER BY parent_id ASC, `date` ASC";
        $statement = $this->database->query($sql);
        while($commentData = $statement->fetch()){
            $comments[$commentData['id']] = new Comment($commentData['id'], $commentData['parent_id'],
                $commentData['name'], $commentData['content'], $commentData['date'], []);
        }

        return $comments;

    }

    public function sortComments(array $comments, ?int $parentId = null): array
    {

        $arr = [];

        foreach ($comments as $comment){
            if($comment->getParentId() == $parentId){
                $children = $this->sortComments($comments, $comment->getId());
                if ($children){
                    $comment->setChildren($children);
                }
                $arr[] = $comment;
            }
        }

        return $arr;

    }

    public function addComment(string $name, string $content, ?int $parentId = null): void
    {

        $sql = "INSERT INTO comments (name, content, parent_id) VALUES (:name, :content, :parent_id)";
        $statement = $this->database->query($sql, [$name, $content, $parentId]);
        $statement->bindParam("name", $name);
        $statement->bindParam("content", $content);
        $statement->bindParam("parent_id", $parentId);
        $statement->execute();

    }

    public function dataValidation(): array
    {

        $errorMessage = [];

        $name = trim($_POST['name']);
        $content = trim($_POST['content']);
        $allowedSymbols = "/^[a-zA-Z0-9-',.:!_? ]*$/";
        $nameLength = 50;
        $contentLength = 1000;

        if (mb_strlen($name) > $nameLength) {
            $errorMessage['name'] = "Name should have less than 30 symbols";
        }
        if (mb_strlen($content) > $contentLength) {
            $errorMessage['content'] = "Commentary should have less than 1000 symbols";
        }
        if (empty($name)) {
            $errorMessage['name'] = "Enter your name";
        }
        if (empty($content)) {
            $errorMessage['content'] = "Enter your commentary";
        }
        if (!preg_match($allowedSymbols, $name)) {
            $errorMessage['name'] = "Such symbols are not allowed";
        }
        if (!preg_match($allowedSymbols, $content)) {
            $errorMessage['content'] = "Such symbols are not allowed";
        }

        return $errorMessage;

    }

}

