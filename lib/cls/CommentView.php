<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 4/30/15
 * Time: 11:43 PM
 */

class CommentView {
    public function __construct(Site $site) {
        $this->site = $site;
        $this->comment = new Comment($site);
    }

    /**
     * This will display comments for a document.
     */
    public function displayComments($docid) {
        $comment_arr = $this->comment->getComment($docid);

        if($comment_arr !== false && !empty($comment_arr)) {
            foreach($comment_arr as $row) {
                $userid = $row['commenterID'];
                $message = $row['message'];
                $time = $row['created'];

                $html .= "<div class='comm_contain'>";
                $html .= "<p class='comm_id'>$userid</p>";
                $html .= "<p class='comm_time'>$time</p>";
                $html .= "<hr/>";
                $html .= "<p class='comm_message'>$message</p>";
                $html .= "</div>";
            }
            return $html;
        }
    }

    private $site;
    private $comment;
}