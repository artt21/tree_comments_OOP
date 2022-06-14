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
        <form action="classes/CommentsController.php" method="post">
            <div class="reply-name">
                <input type="text" name="name" placeholder="Your name" size="53">
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

}