<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/26/15
 * Time: 11:33 PM
 */

class InviteToProject {
    private $user;
    private $searchresults;
    private $site;
    private $sights;
    private $freindship;
    private $invitations;
    private  $freindsCount;
    private  $rojectID;
    private $page;


    public function __construct(Site $site, $user,$request){



        $this->site = $site;
        $this->sights = new Sights($site);
        $Interests = new  Interests($site);
        $documents = new  Documents($site);
        $projects = new   Projects($site);
        $users = new Users($site);
        if(isset($_REQUEST['invite'])&&isset($_REQUEST['projectID'])){
            $result =$_REQUEST['invite'];
            $this->rojectID =$_REQUEST['projectID'];
            $this->searchresults = $users->searchForAUser($result);



        }
        $this->freindship = new Friendship($site);
        $this->invitations = new Invitations($site);
        $this->user = $user;
        $this->userSights =  $this->sights->getSightsForUser($this->user->getId());
        $this->userPendingFriends =  $this->freindship->getPendingForUser($this->user->getId());
        $this->CurrentFriends  =   $this->freindship->getCurrentFriends($this->user->getId());
        $this->UseInterests  = $Interests->UserInterests($this->user->getUserid());
        $this->freindsCount = $this->freindship->CountFriends($this->user->getId());
        $this->ProjsCount = $projects->ProjectsCount($this->user->getUserid());
        $this->DocsCount = $documents->DocumentsCount($this->user->getUserid());
        $this->UserProjs = $projects->AllUserProjects($this->user->getUserid());
        $this->UserDocs = $documents->AllUserDocuments($this->user->getUserid());

    }


    public function FriendsCount() {
        return $this->freindsCount;
    }
    public function getDocsCount() {
        return $this->DocsCount;
    }
    public function getProjsCount() {
        return $this->ProjsCount;
    }


    public function getName() {


        return  $this->user->getName();
    }



    public function presentSearch() {


        $currentuserID = $this->user->getId();
        $currentusername = $this->user->getUserid();





        if (sizeof( $this->searchresults) > 0 ) {


            $html = <<<HTML

HTML;
            foreach ( $this->searchresults as $key => $value) {
                $id = $value->getId();
                $userid = $value->getUserid();


                $html .= ' <div class="sighting">';

                        $Invitee = $this->InviteToProj($value);
                        $html .= '<h2>' . $userid . '</h2>';
                        $html .= '<div>' . $Invitee  . '</div>';




            }
            $html .= '</div>';
            return $html;
        }
    }

    public function InviteToProj($currentUser){
        $userId = $currentUser->getUserid();
        $proj =$this->rojectID;

        $html = <<<HTML
         <div class="farright">
        <p><a href="post/sights-post.php?invite=$userId&projid=$proj">Invite to Project </a></p>
HTML;


        return $html;
    }


    public function presentCurrentFriends(){

        if (empty($this->CurrentFriends)) {
            return "";
        }
        $html = <<<HTML
<div class="options">
		<h2>Friends</h2>
HTML;

        foreach($this->CurrentFriends as $friend) {
            $friendId = $friend->getId();
            $name = $friend->getName();
            $html .=  <<<HTML
<p><a href="post/sights-post.php?i=$friendId ">$name</a></p>
<div class="farright2"><a href="post/sights-post.php?delete=$friendId">Remove</a></div>
HTML;
        }
        $html .= '</div>';
        return $html;


    }


    public function presentPendingRequests(){

        if (empty($this->userPendingFriends)) {
            return "";
        }
        $html = <<<HTML
<div class="options">
		<h2>Pending Requests</h2>
HTML;

        foreach($this->userPendingFriends as $friend) {
            $friendId = $friend->getId();
            $name = $friend->getName();

            if(strlen($name)<8){
                $html .=  <<<HTML
                  <p>$name</p>
                 <div class="farright2"><a href="post/sights-post.php?accept=$friendId">Accept</a></div>
                  <div class="center"><a href="post/sights-post.php?delete=$friendId">Decline</a></div>
HTML;

            }
            else{
                $html .=  <<<HTML
                 <p>$name</p>
                 <div class="farright3"><a href="post/sights-post.php?accept=$friendId">Accept</a></div>
                 <a href="post/sights-post.php?delete=$friendId">Decline</a>

HTML;
            }



        }
        $html .= '</div>';

        return $html;


    }


    public function presentSuper() {
        $name=$this->user->getName();
        $id = $this->user->getId();
        $email = $this->user->getEmail();
        $city  = $this->user->getCity();
        $state = $this->user->getState();
        $right = <<<HTML
           <div class="options">
           <h2>Welcome</h2>
           <p><a href="profile.php?i=$id">View Profile</a></p>
           <p><a href="edituser.php?i=$id">Edit Profile</a></p>

           </div>
HTML;
        return $right;
    }


    public function presentCurrentProjects(){

        if (empty($this->UserProjs)) {
            return "";
        }
        $html = <<<HTML
<div class="options">
		<h2>Projects</h2>
HTML;

        foreach($this->UserProjs as $project) {
            $projectId = $project->getId();
            $name = $project->getName();
            $html .=  <<<HTML
<p><a href="#=$projectId ">$name</a></p>
HTML;
        }
        $html .= '</div>';
        return $html;


    }


    public function presentProjectRequests()
    {

        if (empty($this->userPendingProjects) || ($this->user->getId() !== $this->viewingUser->getId())) {
            return "";
        }
        $html = <<<HTML
<div class="options">
		<h2>Project Requests</h2>
HTML;

        foreach($this->userPendingProjects as $Proj) {
            $ProjId = $Proj->getProjid();
            $colabID = $Proj->getCollaboratorid();

            if (strlen($colabID) < 8) {
                $html .= <<<HTML
                  <p>$colabID</p>
                 <div class="farright2"><a href="post/sights-post.php?acProj=$ProjId">Accept</a></div>
                  <div class="center"><a href="post/sights-post.php?deProj=$ProjId">Decline</a></div>
HTML;

            } else {
                $html .= <<<HTML
                 <p>$colabID</p>
                 <div class="farright3"><a href="post/sights-post.php?acProj=$ProjId">Accept</a></div>
                 <a href="post/sights-post.php?deProj=$ProjId">Decline</a>

HTML;
            }


        }
        $html .= '</div>';

        return $html;

    }

}