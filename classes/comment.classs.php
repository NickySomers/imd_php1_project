<?php
include_once("User.class.php");
class Comment
{
    //id,postId, userId, comment
    private $m_iId;
    private $m_iPostId;
    private $m_iUserId;
    private $m_sComment;

    public function __set($p_sProperty, $p_vValue)
    {
        switch ($p_sProperty) {
            case 'Id':
                $this->m_iId = $p_vValue;
                break;
            case 'postId':
                $this->m_iPostId = $p_vValue;
                break;
            case 'userId':
                $this->m_iUserId = $p_vValue;
                break;
            case 'comment':
                $this->m_sComment = $p_vValue;
                break;
        }
    }
    public function __get($p_sProperty)
    {
        switch ($p_sProperty) {
            case 'Id':
                return ($this->m_iId);
                break;
            case 'postId':
                return ($this->m_iPostId);
                break;
            case 'userId':
                return ($this->m_iUserId);
                break;
            case 'comment':
                return ($this->m_sComment);
                break;
        }
    }
    public function newComment( ){

        $conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->query("INSERT INTO posts_comments (comment , postId , userId) VALUES ( '$this->comment ', '$this->postId' , '$this->userId' )") ;


    }/*
    public function showComment($p){
        $conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $data = $conn->query("SELECT comment FROM posts_comments WHERE postId = '$p' ");
        $comment = $data->fetch(PDO::FETCH_ASSOC);

        return $comment;

    }*/
    public function deleteCommentById($id ){
        $conn = new PDO('mysql:host=localhost;dbname=imdstagram', "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->query("DELETE  FROM posts_comments WHERE id = '$id'");

    }
}
?>