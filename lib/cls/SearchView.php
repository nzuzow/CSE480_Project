<?php
/**
 * Created by PhpStorm.
 * User: Ray
 * Date: 4/24/2015
 * Time: 5:38 PM
 */

class SearchView {
    /**
     * Constructor
     * @param $site The site we are a member of
     * @param $request The $_REQUEST array
     */
    public function __construct(Site $site, $userIDs)
    {
        $this->site = $site;
        $this->userIDs = $userIDs;
        $this->users = new Users($site);

    }

    public function presentUsers()
    {
        if ($this->userIDs) {
            $this->result = array();
            foreach ($this->userIDs as $item) {
                if ($this->users->searchUsers($item)) {
                    $this->result[] = $item;
                }
            }
            if (!empty($this->result)) {
                $htmlUsers = '';
                foreach ($this->result as $item) {
                    $userid = $item;
                    $url = "profile.php?i=" . $userid;
                    $htmlUsers .= '<p><a href="' . $url . '">' . $userid . '</a></p>';
                }
                return <<<HTML
<div class="user-list">
<h2>List of Users</h2>
$htmlUsers
</div>
HTML;
            }
        }
    }
    private $site;
    private $userIDs;
    private $users;
    private $result;

}