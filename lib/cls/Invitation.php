<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 4/26/2015
 * Time: 9:02 PM
 */

class Invitation extends Table
{
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Invitation");
    }
    public function inviteUser($userid, $projid, $ownerid) {
        $sql =<<<SQL
INSERT INTO $this->tableName(collaboratorID, projID, ownerID, status)
VALUES(?, ?, ?, ?)
SQL;


        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($userid, $projid, $ownerid,'pending'));
    }

    public function getCollaborators($projid) {
    $sql =<<<SQL
    SELECT collaboratorID
    FROM $this->tableName
    WHERE projID=?
SQL;
    try {
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($projid));
    }
    catch(Exception $e) {
        return false;
    }

    if($statement->rowCount() === 0) {
        return false;
    }

    $result = array();  // Empty initial array
    foreach($statement as $row) {
        $result[] = $row['collaboratorID'];
    }

    return $result;

}
    public function getAcceptedCollabs($projid) {
        $sql =<<<SQL
    SELECT collaboratorID
    FROM $this->tableName
    WHERE projID=? AND status=?
SQL;
        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($projid, 'accepted'));
        }
        catch(Exception $e) {
            return false;
        }

        if($statement->rowCount() === 0) {
            return false;
        }

        $result = array();  // Empty initial array
        foreach($statement as $row) {
            $result[] = $row['collaboratorID'];
        }

        return $result;

    }
    public function getPending($userid) {
        $sql =<<<SQL
SELECT projID
FROM $this->tableName
WHERE collaboratorID=? AND status=?
SQL;
        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($userid, 'pending'));
        }
        catch(Exception $e) {
            return false;
        }

        if($statement->rowCount() === 0) {
            return false;
        }

        $result = array();  // Empty initial array
        foreach($statement as $row) {
            $result[] = $row['projID'];
        }

        return $result;

    }


}

