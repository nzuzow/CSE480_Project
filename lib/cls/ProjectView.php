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
        $this->invitation = new Invitation($site);
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
        $collabs = $this->invitation->getAcceptedCollabs($this->projid);
        $htmlUsers = '';
        if (!empty($collabs)) {
            foreach ($collabs as $item) {
                $userid = $item;
                $url = "profile.php?i=" . $userid;
                $htmlUsers .= '<p><a href="' . $url . '">' . $userid . '</a></p>';
            }
            return <<<HTML
<div class="proj_display proj_right">
<h2>Collaborators</h2>
$htmlUsers
</div>
HTML;
        }

    }

    public function displayAddDoc() {
        $ownerid = $this->ownerid;
        $projid = $this->projid;

        $html=<<<HTML
<div class="proj_display">
    <h2>Add a Doc:</h2>
    <form name="new_doc" id="new_doc" method="get" action="document.php">
        <label for="doc_title">Filename:</label>
        <input type="text" name="doc_title" id="doc_title"/>
        <input type="hidden" name="doc_status" value="new"/>
        <input type="hidden" name="proj_ownerid" value="$ownerid"/>
        <input type="hidden" name="proj_id" value="$projid"/>
        <br/>
        <input type="submit" value="Add"/>
    </form>
</div>
HTML;
        return $html;
    }

    public function displayDocuments() {
        $this->document = new Document($this->site);
        $docs = $this->document->getDocuments($this->projid);
        if(!empty($docs) && $docs !== false) {
            $html = '<div class="proj_display proj_right" id="doc_list">';
            $html .= '<h2>Documents</h2>';
            foreach($docs as $item) {
                $projid = $item['projID'];
                $docid = $item['docID'];
                $ownerID = $item['projOwnerID'];
                $title = $item['fileName'];
                $version = $item['versionNo'];
                $creator = $item['creatorID'];
                $delete = '';
                if($creator == $_SESSION['user']->getUserID()) {
                    $delete = '<a href="post/delete-post.php?docid='. $docid . '">Delete</a>';
                }
                $html .= '<p><a href="document.php?doc_status=old&doc_title='.$title.'&proj_ownerid='.$ownerID.'&proj_id='.$projid.'&p_docid='.$docid.'">'.$title.' - version '.$version.'</a> - ' . $delete . '</p>';
                //$html .= '<p><a href="project.php?proj='.$projid.'&ownid='.$ownerID.'">'.$title.'</a></p>';
            }
            $html .= '</div>';

            return $html;
        }

    }

    public function displayNonCollabs()
    {
        $users = new Users($this->site);
        $collabs = $this->invitation->getCollaborators($this->projid);
        $collabsStr = '';

        // This check is needed, because if there are no collaborators,
        // The getCollaborators will return false, and that will cause
        // an error if this check isn't here.
        if(!empty($collabs) && $collabs != false) {
            foreach ($collabs as $collab) {
                $collabsStr .= $collab . ",";
            }
        }

        $nonCollabs = $users->getNonCollabs($this->ownerid, $collabsStr);
        $htmlUsers = '';
        if (!empty($nonCollabs)) {
            foreach ($nonCollabs as $item) {
                $userid = $item['userID'];
                $url = "post/invite-post.php?i=" . $userid . "&ownid=" . $this->ownerid . "&proj=" . $this->projid;
                $htmlUsers .= '<p>' . $userid . ' <a href="' . $url . '">Add</a></p>';
            }
            return <<<HTML
<div class="user-list">
<h2>Invite Users</h2>
$htmlUsers
</div>
HTML;
        }
    }

    private $site;
    private $project;
    private $ownerid;
    private $projid;
    private $document;
    private $invitation;
}