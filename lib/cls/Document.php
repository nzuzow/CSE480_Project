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
}