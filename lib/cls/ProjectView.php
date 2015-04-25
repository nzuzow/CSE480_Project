<?php
/**
 * Created by PhpStorm.
 * User: nickzuzow
 * Date: 4/25/15
 * Time: 3:04 AM
 */

class ProjectView {
    /**
     * Constructor
     * @param $site The site we are a member of
     */
    public function __construct(Site $site, $ownerid, $projid)
    {
        $this->site = $site;
        $this->project = new Project($site);
        $this->ownerid = $ownerid;
        $this->projid = $projid;
    }

    public function getTitle() {
        return $this->project->getProjTitle($this->ownerid, $this->projid);
    }

    public function displayOwner() {
        $ownerid = $this->ownerid;
        $html=<<<HTML
<div class="proj_display">
    <h2>Owner ID:</h2>
    <p><a href="profile.php?i=$ownerid">$ownerid</a></p>
</div>
HTML;
        return $html;
    }

    public function displayCollaborators() {
        // THIS IS JUST A STUB RIGHT NOW. FUNCTIONALITY WILL NEED TO
        // BE ADDED TO MAKE THIS ACTUALLY WORK LATER
        $html=<<<HTML
<div class="proj_display">
    <h2>Collaborators:</h2>
    <p><a href="#">TestID1</a></p>
    <p><a href="#">TestID2</a></p>
    <p><a href="#">TestID3</a></p>
</div>
HTML;
        return $html;

    }

    private $site;
    private $project;
    private $ownerid;
    private $projid;
}