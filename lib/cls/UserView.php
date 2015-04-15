<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 3/19/2015
 * Time: 4:04 PM
 */

class UserView
{
    /**
     * Constructor
     * @param $site The site we are a member of
     * @param $request The $_REQUEST array
     */
    public function __construct(Site $site, User $user = null, $request)
    {
        $this->site = $site;

        $this->users = new Users($site);
        if (isset($request['i'])) {
            $this->user = $this->users->getUser($request['i']);
        } else {
            $this->user = $user;
        }

    }

    /**
     * @return Get the name of the sight
     */
    public function getName()
    {
        return $this->user->getName();
    }

    public function presentCurrUser()
    {
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

    public function presentProfile()
    {
        $user = $this->user->getUserID();
        $userID = "Logged In: " . $user;
        $name = "Name: " . $this->user->getName();
        $email = "Email: " . $this->user->getEmail();
        $city = "City: " . $this->user->getCity();
        $state = "State: " . $this->user->getState();
        $privacy = "Privacy: " . $this->user->getPrivacy();
        $birth = "Birth Year: " . $this->user->getBirthyear();
        $user_interests = new UserInterests($this->site);
        $interests = $user_interests->getInterests($user);
        $interest = "Interest: ";
        $idx = false;
        foreach ($interests as $item) {
            if (!$idx) {
                $interest .= $item[0];
                $idx = true;
            } else {
                $interest .= ", " . $item[0];
            }

        }
        return <<<HTML

<p>$userID</p>
<p>$name</p>
<p>$email</p>
<p>$city</p>
<p>$state</p>
<p>$privacy</p>
<p>$birth</p>
<p>$interest</p>
HTML;
    }

    public function presentUsers()
    {
        $user = $this->user->getUserID();
        $list = $this->users->getUsers($user);
        $htmlUsers = '';
        if (!empty($list)) {
            foreach ($list as $item) {
                $userid = $item[0];
                $name = $item[1];
                $url = "profile.php?i=" . $userid;
                $htmlUsers .= '<p><a href="' . $url . '">' . $name . '</a></p>';
            }
            return <<<HTML
<div class="user-list">
<h2>List of Users</h2>
$htmlUsers
</div>
HTML;
        }
    }

    public function getAdd()
    {
        $curruser = "";

        //if (isset($request['i']) && $this->users->getUser($request['i']) !== null) {
        if (isset($_REQUEST['i']) && $this->users->getUser($_REQUEST['i']) !== null) {
            $curruser = $this->user->getUserID();
        }
        //$user = $_REQUEST['i'];
        $user = $_SESSION['user']->getUserID();

        $friendship = new Friendship($this->site);
        if (!$friendship->checkFriend($curruser, $user) && $curruser != $user && $curruser != "") {
            $url = "post/friend-post.php?i=" . $curruser;
            return <<<HTML
<p><a href="$url">ADD FRIEND</a></p>
HTML;

        }
    }

    public function presentUpdate()
    {
        if (isset($request['i']) && $this->users->getUser($request['i']) !== null) {
            $curruser = $this->user->getUserID();
        }
        $user = $_REQUEST['i'];
        if ($curruser == $user) {
            return <<<HTML
<div id="update">
        <h2>Update User Info</h2>
        <form method="post" action="post/update-post.php">
            <p>
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name">
            </p>
            <p>
                <label for="email">Email:</label><br>
                <input type="text" id="email" name="email">
            </p>
            <p>
                <label for="password1">Password:</label><br>
                <input type="password" id="password1" name="password1">
            </p>
            <p>
                <label for="password2">Password (again):</label><br>
                <input type="password" id="password2" name="password2">
            </p>
            <p>
                <label for="city">City:</label><br>
                <input type="text" id="city" name="city">
            </p>
            <p>
                <label for="state">State:</label><br>
                <input type="text" id="state" name="state">
            </p>
            <p>
                <label for="privacy">Privacy:</label><br>
                <input type="text" id="privacy" name="privacy">
            </p>
            <p>
                <label for="birthyear">Birth Year:</label><br>
                <input type="text" id="birthyear" name="birthyear">
            </p>
            <p>
                <label for="interests">Interests (comma seperated):</label><br>
                <textarea id="interests" name="interests" placeholder="Ex: Watch basketball, play video games, create databases."></textarea>
            </p>
            <p><input type="submit"></p>

</form>
</div>
HTML;
        }
    }

    public function presentFriends()
    {
        $friendship = new Friendship($this->site);

        $result = $friendship->getFriend($this->user->getUserID());

        if($result == null)
        {
            return null;
        }

        $html = '<div id="friend_list">';
        $html .= '<h2>Friends</h2>';
        foreach($result as $item) {
            $remove = '    <a href=post/friend-post.php?r='.$item . '>Remove Friend</a>';
            $html .= '<p><a href="profile.php?i='.$item.'">'.$item.'</a>'.$remove.'</p>';
        }
        $html .= '</div>';

        return $html;
    }

    public function presentPending()
    {
        $friendship = new Friendship($this->site);

        $result = $friendship->getPendingFriend($this->user->getUserID());

        if($result == null)
        {
            return null;
        }

        $html = '<div id="pending_list">';
        $html .= '<h2>Pending Requests</h2>';
        foreach($result as $item) {
            $html .= '<p><a href="profile.php?i='.$item.'">'.$item.'</a>  - <a href="post/friend-post.php?a='.$item.'">Approve</a> | <a href="post/friend-post.php?d='.$item.'">Decline</a></p>';
        }
        $html .= '</div>';

        return $html;
    }

    private $user;
    private $site;
    private $users;
}