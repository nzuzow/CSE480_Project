<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 3/28/15
 * Time: 4:02 PM
 */

class User {
    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        //$this->id = $row['id'];
        $this->userid = $row['userid'];
        $this->name = $row['name'];
        $this->email = $row['email'];
        $this->city = $row['city'];
        $this->state = $row['state'];
        $this->privacy = $row['privacy'];
        $this->birthyear = $row['birthyear'];
        //$this->joined = strtotime($row['joined']);
        //$this->role = $row['role'];
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getPrivacy()
    {
        return $this->privacy;
    }

    /**
     * @param mixed $privacy
     */
    public function setPrivacy($privacy)
    {
        $this->privacy = $privacy;
    }

    /**
     * @return mixed
     */
    public function getBirthyear()
    {
        return $this->birthyear;
    }

    /**
     * @param mixed $birthyear
     */
    public function setBirthyear($birthyear)
    {
        $this->birthyear = $birthyear;
    }

    public function getUserID() {
        return $this->userid;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    private $userid;    ///< User-supplied ID
    private $name;      ///< What we call you by
    private $email;     ///< Email address
    private $city;
    private $state;
    private $privacy;
    private $birthyear;

}