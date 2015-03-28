<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 3/28/15
 * Time: 3:24 PM
 */

/**
 * Manage users in our system.
 */
class Users extends Table {
    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "User");
    }

    /**
     * Test for a valid login.
     * @param $user User id or email
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     */
    public function login($user, $password) {
        $sql =<<<SQL
SELECT * from $this->tableName
where userID=? or email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($user, $user));
        if($statement->rowCount() === 0) {
            return null;
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Get the encrypted password and salt from the record
        //$hash = $row['password'];
        //$salt = $row['salt'];
        $db_pass = $row['pass'];

        // Ensure it is correct
        //if($hash !== hash("sha256", $password . $salt)) {
        //    return null;
        //}
        if($db_pass !== $password) {
            return null;
        }

        return new User($row);

        //return new User($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @returns User object if successful, null otherwise.
     */
    /*public function get($id) {
        $sql =<<<SQL
SELECT * from $this->tableName
WHERE userID=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(PDO::FETCH_ASSOC));
    }*/

    /**
     * Get a user based on the userid or email
     * @param $id Either userid or email of the user
     * @returns User object if successful, null otherwise.
     */
    public function getUser($id) {
        $sql =<<<SQL
SELECT * from $this->tableName
where userID=? or email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id, $id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Determine if a user exists in the system.
     * @param $user A user ID or a email address.
     * @returns true if $user is an existing user ID or email address
     */
    public function exists($user) {
        $sql =<<<SQL
SELECT * from $this->tableName
where userID=? or email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($user, $user));
        if($statement->rowCount() === 0) {
            return false;
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if(!empty($row)) {
            return true;
        }

        return false;
    }

    /**
     * Add a user to the site
     * @param $user An array of user information containing keys for:
     * userid, name, email, password, salt, and joined.
     */
    public function add($user) {
        $sql =<<<SQL
INSERT INTO $this->tableName(userID, pass, email, name, city, state, privacy, birthyear)
VALUES(?, ?, ?, ?, ?, ?, ?, ?)
SQL;
        // I did this instead of just passing in the $user array
        // so that I could make sure that the parameters were in the
        // correct order.
        $userid = $user["userid"];
        $password = $user["pass"];
        $email = $user["email"];
        $name = $user["name"];
        $city = $user["city"];
        $state = $user["state"];
        $privacy = $user["privacy"];
        $birthyear = $user["birthyear"];

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($userid, $password, $email, $name, $city, $state, $privacy, $birthyear));
    }

    /**
     * Update the password info of a user
     * @param $user An array of user information containing keys for:
     * id, password, and salt.
     */
    public function updateUserPw($user) {
        $sql =<<<SQL
UPDATE $this->tableName
SET pass=?
WHERE userID=?
SQL;
        // I did this instead of just passing in the $user array
        // so that I could make sure that the parameters were in the
        // correct order.
        $id = $user["userid"];
        $password = $user["pass"];

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($password, $id));

    }

}