<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 4/30/15
 * Time: 11:10 PM
 */

class Comment extends Table {
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Comment");
    }

    /**
     * @param $userid, The commenterID
     * @param $docid, The ID of the document the comment belongs to
     * @param $text, The message of the comment
     * @return bool, Returns false if an error occured, true otherwise
     */
    public function addComment($userid, $docid, $text, $createTime) {
        $sql=<<<SQL
INSERT INTO $this->tableName(commenterID, docID, created, message)
VALUES(?, ?, ?, ?)
SQL;

        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($userid, $docid, $createTime, $text));
        }
        catch(Exception $e) {
            return false;
        }

        return true;

    }

    public function getComment($docid) {
        $sql=<<<SQL
SELECT * FROM $this->tableName
WHERE docID = ?
SQL;
        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($docid));
        }
        catch(Exception $e) {
            return false;
        }

        if($statement->rowCount() === 0) {
            return false;
        }

        $result = array();  // Empty initial array
        foreach($statement as $row) {
            $result[] = $row;
        }

        return $result;
    }
}