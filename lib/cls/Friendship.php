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
SELECT * FROM $this->tableName
WHERE ((senderID = ? and recipientID = ?) or
(recipientID = ? and senderID = ?)) and pending = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($curruser,$user, $curruser, $user, '0'));
        if($statement->rowCount() === 0) {
            return false;
        }
        else {
            return true;
        }

    }
    public function requestFriend($curruser, $user){
        $sql=<<<SQL
        INSERT INTO $this->tableName(senderID, recipientID, pending)
        VALUES (?,?,?)
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($curruser, $user, '1'));

        return true;

    }

    /**
     * This takes a userID and returns an array of
     * that users friends.
     * @param $userid UserID who you want the friend list for
     */
    public function getFriend($userid) {
        $sql=<<<SQL
SELECT * FROM $this->tableName
WHERE (senderID = ? OR recipientID = ?) AND pending = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid, $userid, '0'));

        if($statement->rowCount() === 0) {
            return null;
        }

        $result = array();  // Empty initial array
        foreach($statement as $row) {
            // Need to check if the userid that was passed in is the sender or
            // the recipient. Then we can add the other value to the result array
            if($row['senderID'] == $userid && !in_array($row['recipientID'], $result))
            {
                $result[] = $row['recipientID'];
            }
            else if($row['recipientID'] == $userid && !in_array($row['senderID'], $result))
            {
                $result[] = $row['senderID'];
            }
            //$result[] = $row;
        }

        return $result;
    }

    public function getPendingFriend($userid) {
        $sql=<<<SQL
SELECT senderID FROM $this->tableName
WHERE recipientID = ? AND pending = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid, '1'));

        $result = array();  // Empty initial array
        foreach($statement as $row) {
            $result[] = $row['senderID'];
        }

        return $result;
    }

    public function acceptFriend($recipientID, $senderID) {
        $sql=<<<SQL
UPDATE $this->tableName
SET pending=?
WHERE senderID = ? AND recipientID = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array('0', $senderID, $recipientID));
    }

    public function declineFriend($recipientID, $senderID) {
        $sql=<<<SQL
DELETE FROM $this->tableName
WHERE senderID = ? AND recipientID = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($senderID, $recipientID));
    }
}