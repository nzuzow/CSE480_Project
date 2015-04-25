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


    /**
     * Create a new user.
     * @param $userid New user ID
     * @param $name New user name
     * @param $email User email address
     * @param $password1 The new password
     * @param $password2 The new password second copy
     * @param $city
     * @param $state
     * @param $privacy
     * @param $birthyear
     * @returns Error message or null if no error
     */
    public function newUser($userid, $name, $email, $password1, $password2, $city, $state, $privacy, $birthyear, $interests, $site) {
        // Ensure the passwords are valid and equal
        if(strlen($password1) < 8) {
            return "Passwords must be at least 8 characters long";
        }

        if($password1 !== $password2) {
            return "Passwords are not equal";
        }

        // Ensure we have no duplicate user ID or email address
        $users = new Users($this->site);
        if($users->exists($userid)) {
            return "User ID already exists. Please choose another one.";
        }

        if($users->exists($email)) {
            return "Email address already exists.";
        }

        $birthyear = intval($birthyear);
        // Check to make sure the year of birth is a 4 digit integer
        if(!is_int($birthyear) || strlen((string)$birthyear) != 4) {
            return "Birthyear is not a 4 digit integer";
        }

        // Make sure the email contains an @ sign
        if(strpos($email, "@") === false) {
            return "The email is not valid";
        }

        // Create salt and encrypted password
        //$salt = self::random_salt();
        //$hash = hash("sha256", $password1 . $salt);

        // Add a record to the newuser table
        $sql = <<<SQL
REPLACE INTO $this->tableName(userID, pass, email, name, city, state, privacy, birthyear)
values(?, ?, ?, ?, ?, ?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($userid, $password1, $email, $name, $city, $state, $privacy, $birthyear));

        // Parse the interests and add them to the table.
        $user_interests = new UserInterests($site);
        $user_interests->addInterests($userid, $interests);
    }



    public function updateUser($userid, $name, $email, $password1, $password2, $city, $state, $privacy, $birthyear, $interests, $site) {
        // Ensure the passwords are valid and equal

        if($password1 != null) {
            if (strlen($password1) < 8) {
                return "Passwords must be at least 8 characters long";
            }

            if ($password1 !== $password2) {
                return "Passwords are not equal";
            }
        }
        if($birthyear != null) {
            $birthyear = intval($birthyear);
            // Check to make sure the year of birth is a 4 digit integer
            if (!is_int($birthyear) || strlen((string)$birthyear) != 4) {
                return "Birthyear is not a 4 digit integer";
            }
        }

        $users = new Users($this->site);
        if($email != null) {
            if ($users->exists($email)) {
                return "Email address already exists.";
            }
            // Make sure the email contains an @ sign
            if (strpos($email, "@") === false) {
                return "The email is not valid";
            }
        }
        $user = $users->getUser($userid);
        if($password1 == null) {
            $password1 = $user->getPassword();
        }
        if($email == null) {
            $email = $user->getEmail();
        }
        if($name == null) {
            $name = $user->getName();
        }
        if($city == null) {
            $city = $user->getCity();
        }
        if($state == null) {
            $state = $user->getState();
        }
        if($privacy == null) {
            $privacy = $user->getPrivacy();
        }
        if($birthyear == null) {
            $birthyear = $user->getBirthyear();
        }
        if($interests != null) {
            $user_interests = new UserInterests($site);
            $user_interests->deleteInterests($userid);
            $user_interests->addInterests($userid, $interests);
        }

        $sql = <<<SQL
UPDATE $this->tableName
SET pass=?, email=?, name=?, city=?, state=?, privacy=?, birthyear=?
WHERE userID = ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($password1, $email, $name, $city, $state, $privacy, $birthyear, $userid));

        return null;
    }

    public function getUsers($currUser) {
        $sql =<<<SQL
SELECT userID, name
FROM $this->tableName
WHERE userID <> ?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($currUser));

        $result = array();  // Empty initial array
        foreach($statement as $row) {
            $result[] = $row;
        }

        return $result;

    }

    public function searchUsers($userID) {
        $sql =<<<SQL
SELECT *
FROM $this->tableName
WHERE userID=? and privacy=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($userID, "low"));
        if($statement->rowCount() === 0) {
            return false;
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if(!empty($row)) {
            return true;
        }

        return false;

    }

}