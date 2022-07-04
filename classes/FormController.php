<?php

include "../includes/autoloader.php";

class FormController
{

    private function getModel(): Model
    {

        return new Model(new Database());

    }

    private function emptyInput($name, $content): bool
    {
        if(empty($name) || empty($content)){
            $result = false;
        } else{
            $result = true;
        }
        return $result;
    }

    private function nameLength($name): bool
    {
        $nameLength = 35;
        if(mb_strlen($name) > $nameLength){
            $result = false;
        } else{
            $result = true;
        }
        return $result;
    }

    private function contentLength($content): bool
    {
        $contentLength = 999;
        if(mb_strlen($content) > $contentLength){
            $result = false;
        } else{
            $result = true;
        }
        return $result;
    }

    private function symbolsCheck($name, $content): bool
    {
        $allowedSymbols = "/^[a-zA-Z0-9-',.:!_? ]*$/";
        if(!preg_match($allowedSymbols, $name) || !preg_match($allowedSymbols, $content)){
            $result = false;
        } else{
            $result = true;
        }
        return $result;
    }

    private function validateForm($name, $content): string
    {
        $errorMessage = '';

        if(!$this->emptyInput($name, $content)){
            $errorMessage = "Please enter text in both fields";
            header("Location:../index.php?error=emptyinput");
            exit();
        }
        if(!$this->nameLength($name)){
            $errorMessage  = "Name should have less than 35 symbols";
            header("Location:../index.php?error=namelength");
            exit();
        }
        if(!$this->contentLength($content)){
            $errorMessage  = "Commentary should have less than 999 symbols";
            header("Location:../index.php?error=contentlength");
            exit();
        }
        if(!$this->symbolsCheck($name, $content)){
            $errorMessage  = "Such symbols are not allowed";
            header("Location:../index.php?error=symbolscheck");
            exit();
        }

        return $errorMessage;

    }

    public function formHandler(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST"){

            $model = $this->getModel();

            if (empty($this->validateForm($_POST['name'], $_POST['content']))){

                $parentId = $_POST['parent_id'] ?? null;
                $model->addComment($_POST['name'], $_POST['content'], $parentId);
                header ("Location: ../index.php");

            }
        }
    }

}

$formHandler = new FormController();
$formHandler->formHandler();


