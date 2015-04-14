<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 3/31/2015
 * Time: 9:57 PM
 */

class Friendship extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site)
    {
        parent::__construct($site, "Friendship");
    }
    public function checkFriend($curruser, $user){
        $sql=<<<SQL
SELECT * FROM $this->tablename
WHERE ((senderID = ? and recipientID = ?) or
(recipientID = ? and senderID = ?)) and pending = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($curruser,$user, $user, $curruser, NULL));
        if($statement->rowCount() === 0) {
            return false;
        }
        else {
            return true;
        }

    }
    public function requestFriend($curruser, $user){
        $sql=<<<SQL
        INSERT INTO $this->tableName(senderID, recipientID)
        VALUES (?,?)
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($curruser, $user));

        return true;

    }
}