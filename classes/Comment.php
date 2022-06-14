<?php

class Comment
{

    private int $id;
    private ?int $parentId;
    private string $name;
    private string $content;
    private string $date;
    private array $children;

    public function __construct(int $id, ?int $parentId, string $name, string $content,
                                string $date, array $children)
    {
        $this->id = $id;
        $this->parentId = $parentId;
        $this->name = $name;
        $this->content = $content;
        $this->date = $date;
        $this->children = [];
    }

    private function setId(int $id):void
    {
        $this->id = $id;
    }

    public function getId():int
    {
        return $this->id;
    }

    private function setParentId(?int $parentId):void
    {
        $this->parentId = $parentId;
    }

    public function getParentId():?int
    {
        return $this->parentId;
    }

    private function setName(string $name):void
    {
        $this->name = $name;
    }

    public function getName():string
    {
        return $this->name;
    }

    private function setContent(string $content):void
    {
        $this->content = $content;
    }

    public function getContent():string
    {
        return $this->content;
    }

    private function setDate(string $date):void
    {
        $this->date = $date;
    }

    public function getDate():string
    {
        return $this->date;
    }

    public function setChildren(array $children):void
    {
        $this->children = $children;
    }

    public function getChildren():array
    {
        return $this->children;
    }

    public function dateInterval(DateTime $originDate): string
    {

        $currentDate = date_create(date('Y-m-d H:i:s'));
        $interval = date_diff($originDate, $currentDate);

        if ($interval->format('%y')) {
            $date = $interval->format("%y year(s) ago");
        } elseif ($interval->format('%m')) {
            $date = $interval->format('%m month(s) ago');
        } elseif ($interval->format('%d')) {
            $date = $interval->format('%d day(s) ago');
        } elseif ($interval->format('%h') >= 1) {
            $date = $interval->format('%h hour(s) ago');
        } elseif ($interval->format('%i') < 1) {
            $date = $interval->format('just now');
        } else {
            $date = $interval->format('%i minute(s) ago');
        }

        return $date;

    }


}