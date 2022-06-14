<?php

declare(strict_types = 1);

class Controller{

    public array $errorMessage = [];

    private function getModel(): Model
    {

        return new Model(new Database());

    }

    public function runIndex(): string
    {

        $comment = $this->getModel();
        $allComments = $comment->getComments();
        $sortedComments = $comment->sortComments($allComments);
        $commentsView = new View();

        return $commentsView->showComments($sortedComments);

    }

}




