<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 4/25/15
 * Time: 12:10 AM
 */

/**
 * Class Project, manage projects in the database
 */
class Project extends Table {
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Project");
    }

    /**
     * @param $ownerid - The id of the owner of the project
     * @param $title - Title of the new project
     * Add a new project to the database
     */
    public function addProject($ownerid, $title) {
        $sql=<<<SQL
INSERT INTO $this->tableName(ownerID, title, created)
VALUES(?, ?, ?)
SQL;
        $curr_time = new DateTime();
        $curr_time = $curr_time->format('Y-m-d H:i:s');

        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($ownerid, $title, $curr_time));
        }
        catch(Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param $ownerid - The id of the user that you are looking for
     * @return array|bool This will return an array of rows if
     * the user has current projects. Otherwise it will return false
     */
    public function getProject($ownerid) {
        $sql=<<<SQL
SELECT * FROM $this->tableName
WHERE ownerID = ?
SQL;
        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($ownerid));
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