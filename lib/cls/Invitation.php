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

    public function updateInvite($status, $userid, $projid) {
        $sql=<<<SQL
UPDATE $this->tableName
SET status=?
WHERE collaboratorID=? AND projID=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($status,$userid, $projid));


    }
    public function removeInvite($userid, $projid) {
        $sql=<<<SQL
DELETE FROM $this->tableName
WHERE collaboratorID=? AND projID=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($userid, $projid));


    }

    public function getProjForCollab($userid) {
        $sql=<<<SQL
SELECT projID FROM $this->tableName
WHERE collaboratorID=? AND status=?
SQL;
        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);
            $statement->execute(array($userid, 'accepted'));
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

    /**
     * @param $userid
     * @return array|bool, This will return false if there is
     * an error or no rows. Otherwise this will return an array
     * of ownerID and projID of a project for a collaborator
     */
    public function getFullProjForCollab($userid) {
        $sql=<<<SQL
SELECT projID, ownerID FROM $this->tableName
WHERE collaboratorID=? AND status=?
SQL;
        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);
            $statement->execute(array($userid, 'accepted'));
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

    public function getRejected($ownerid)
    {
        $sql = <<<SQL
SELECT *
FROM $this->tableName
WHERE ownerID=? AND status=?
SQL;

        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($ownerid, 'rejected'));
        }
        catch (Exception $e) {
            return false;
        }

        if ($statement->rowCount() === 0) {
            return false;
        }

        $result = array();  // Empty initial array
        foreach ($statement as $row) {
            $result[] = $row;
        }

        return $result;
    }
}

