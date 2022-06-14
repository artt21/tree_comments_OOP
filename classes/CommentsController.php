<?php
include "Model.php";
include "Database.php";
class CommentsController
{

    private function getModel(): Model
    {

        return new Model(new Database());

    }

    public function formHandler()
    {

        if ($_SERVER['REQUEST_METHOD'] === "POST"){

            $m = new Model(new Database());
            $parentId = $_POST['parent_id'] ?? null;
            $m->addComment($_POST['name'], $_POST['content'], $parentId);
            header ("Location: ../index.php");

        }

    }



}

//$m = new Model(new Database());
//$parentId = $_POST['parent_id'] ?? null;
//$m->addComment($_POST['name'], $_POST['content'], $parentId);
//header ("Location: ../index.php");

