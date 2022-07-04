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

}

