<?php

class View{

    private function commentsPattern(Comment $comments): string
    {

        $name = htmlspecialchars($comments->getName(), ENT_QUOTES);
        $content = htmlspecialchars($comments->getContent(), ENT_QUOTES);
        $id = $comments->getId();
        $date = $comments->dateInterval(date_create($comments->getDate()));

        $pattern = <<<HEREDOC
<div class="comments">
                <div class="comment-added-by">
                    By <b>%s</b> <i>%s</i>
</div>
<hr>
<div class="comment-content">
    <p>%s</p>
</div>
<hr>
<div class="comments-reply-button">
    <button onclick="document.getElementById('formreply-%d').style.display='';">
        Reply
    </button>
</div>
</div>
<div class="reply-form" style="display: none" id="formreply-%d">
    <div>
        <form action="classes/FormController.php" method="post">
            <div class="reply-name">
                <input type="text" name="name" placeholder="Your name" size="49">
            </div>
            <div class="reply-comment">
                <textarea rows="2" cols="50" name="content" placeholder="Enter Comment"></textarea>
            </div>
            <div class="reply-submit">
                <button type="submit" name="submit-reply" id="submit-reply">Submit</button>
            </div>
            <input type="hidden" name="parent_id" value="%d">
        </form>
    </div>
</div>
HEREDOC;

        $pattern = sprintf($pattern, $name, $date, $content, $id, $id, $id);

        if($comments->getChildren()){
            $pattern .= '<ul>' . $this->showComments($comments->getChildren()) . '</ul>';
        }

        return $pattern;

    }

    public function showComments(array $sortedComments): string
    {

        $string = '';

        foreach($sortedComments as $comment){
            $string .= $this->commentsPattern($comment);
        }

        return $string;

    }

    public function indexPattern(string $comments, ?string $errorMessage): string
    {

        if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($errorMessage)){

            switch ($errorMessage) {
                case 'emptyinput':
                    $errorMessage = "• Please enter text in both fields";
                    break;
                case 'namelength':
                    $errorMessage = "• Name should have less than 35 symbols";
                    break;
                case 'contentlength':
                    $errorMessage = "• Commentary should have less than 999 symbols";
                    break;
                case 'symbolscheck':
                    $errorMessage = "• Such symbols are not allowed";
                    break;
            }

        }

        $startHtml = <<<HEREDOC
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tree Comments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<div class="wrapper">
    <div class="navbar">
        <a class="logo" href="/comments OOP/index.php">Tree Comments Exercise</a>
    </div>
    <div class="post">
        <h2>Random Post</h2>
        <div class="post-row">
            Is allowance instantly strangers applauded discourse so. Separate entrance welcomed sensible laughing why
            one moderate shy. We seeing piqued garden he.
            As in merry at forth least ye stood. And cold sons yet with. Delivered middleton therefore me at. Attachment
            companions man way excellence how her pianoforte.
            Conveying or northward offending admitting perfectly my. Colonel gravity get thought fat smiling add but.
            Wonder twenty hunted and put income set desire expect.
            Am cottage calling my is mistake cousins talking up. Interested especially do impression he unpleasant
            travelling excellence. All few our knew time done draw ask.
            Greatest properly off ham exercise all. Unsatiable invitation its possession nor off. All difficulty
            estimating unreserved increasing the solicitude.
        </div>
    </div>
    <div class="commentaries">
    <div class="errors">%s</div>
        <div class="comments-form">
            <h3>Leave a commentary</h3>
            <form action="classes/FormController.php" method="post">
                <div class="input">
                    <input type="text" name="name" placeholder="Your name" size="49">
                </div>
                <div class="textarea">
                    <textarea rows="4" cols="50" name="content" placeholder="Enter Comment"></textarea>
                </div>
                <div class="submit">
                    <button type="submit" name="submit_comment" id="submit_comment">Submit</button>
                </div>
            </form>
        </div>
        %s
    </div>
    <div class="footer">
        <script>
        </script>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
HEREDOC;

        return sprintf($startHtml, $errorMessage, $comments);

    }

}