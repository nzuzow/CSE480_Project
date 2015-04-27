<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 4/25/2015
 * Time: 4:04 PM
 */

class Document extends Table {
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "Document");
    }

    public function getVersionNum($projID, $projOwnerID, $fileName) {
        $sql=<<<SQL
SELECT MAX(versionNo) FROM $this->tableName
WHERE projID = ? AND projOwnerID = ? AND fileName = ?
SQL;
        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($projID, $projOwnerID, $fileName));
        }
        catch(Exception $e) {
            return false;
        }
        if($statement->rowCount() === 0) {
            return false;
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if(!empty($row)) {
            return $row['MAX(versionNo)'];
        }
    }

    public function addDocument($projID, $projOwnerID, $creatorID, $fileName, $versionNo, $createTime, $parentDocID)
    {
        $sql=<<<SQL
INSERT INTO $this->tableName(projID, projOwnerID, creatorID, fileName, versionNo, createTime, parentDocID)
VALUES (?, ?, ?, ?, ?, ?, ?)
SQL;

        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($projID, $projOwnerID, $creatorID, $fileName, $versionNo, $createTime, $parentDocID));
        }
        catch(Exception $e) {
            return false;
        }

        return true;
    }

    public function getDocuments($projID) {
        $sql =<<<SQL
        SELECT *
        FROM $this->tableName
        WHERE projID=?
SQL;
        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($projID));
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

    public function getDocumentById($docID) {
        $sql=<<<SQL
SELECT *
FROM $this->tableName
WHERE docID = ?
SQL;
        try {
            $pdo = $this->pdo();
            $statement = $pdo->prepare($sql);

            $statement->execute(array($docID));
        }
        catch(Exception $e) {
            return false;
        }

        if($statement->rowCount() === 0) {
            return false;
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if(!empty($row)) {
            return $row;
        }

        return false;
    }
}