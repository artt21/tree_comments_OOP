<?php

declare(strict_types = 1);
date_default_timezone_set("America/New_York");

class Controller{

    private function getModel(): Model
    {

        return new Model(new Database());

    }

    private function getView(): View
    {
        return new View();
    }

    public function runPage(): string
    {

        $comment = $this->getModel();
        $allComments = $comment->getComments();
        $sortedComments = $comment->sortComments($allComments);
        $view = $this->getView();
        $commentsView = '<ul>' . $view->showComments($sortedComments) . '</ul>';
        $errorMessage = $_GET['error'] ?? null;

        return $view->indexPattern($commentsView, $errorMessage);

    }

}
