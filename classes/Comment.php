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

    public function getId():int
    {
        return $this->id;
    }

    public function getParentId():?int
    {
        return $this->parentId;
    }

    public function setName(string $name):void
    {
        $this->name = $name;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getContent():string
    {
        return $this->content;
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