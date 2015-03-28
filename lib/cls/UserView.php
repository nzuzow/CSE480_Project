<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 3/19/2015
 * Time: 4:04 PM
 */

class UserView {
    /**
     * Constructor
     * @param $site The site we are a member of
     * @param $request The $_REQUEST array
     */
    public function __construct(Site $site, User $user = null, $request) {
        $this->site = $site;

        $users = new Users($site);
        if(isset($request['i'])) {
            $this->user = $users->get($request['i']);
        }
        else {
            $this->user = $user;
        }

    }

    /**
     * @return Get the name of the sight
     */
    public function getName() {
        return $this->user->getName();
    }

    public function presentProfile() {
        $userID = "Logged In: " . $this->user->getUserID();
        $name = "Name: " . $this->user->getName();
        $email = "Email: " . $this->user->getEmail();



            return <<<HTML
<div class="options">
<h2>$userID</h2>
<p>$name</p>
<p>$email</p>
</div>
HTML;
        }

    private $user;
    private $site;
}