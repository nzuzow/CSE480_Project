<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 3/28/15
 * Time: 4:49 PM
 */

class UserInterests extends Table {
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "User_Interests");
    }

    /**
     * Add interests for a user
     * @param $userid The userid the interests belong to
     * @param $interests The string of interests the user entered
     */
    public function addInterests($userid, $interests) {
        $sql =<<<SQL
INSERT INTO $this->tableName(userID, interest)
VALUES(?, ?)
SQL;
        // Need to split up interest by commas
        $interests_arr = explode(",",$interests);

        foreach($interests_arr as $item) {
            // remove extra whitespace
            $item = trim($item);

            $statement = $this->pdo()->prepare($sql);
            $statement->execute(array($userid, $item));
        }
    }

    public function getInterests($userid) {
        $sql =<<<SQL
SELECT interest FROM $this->tableName
WHERE userID = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));

        $result = array();  // Empty initial array
        foreach($statement as $row) {
            $result[] = $row;
        }

        return $result;

    }

    public function deleteInterests($userid) {
        $sql =<<<SQL
DELETE FROM $this->tableName
WHERE userID = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($userid));

        return true;

    }

}