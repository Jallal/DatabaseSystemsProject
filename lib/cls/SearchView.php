<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 3/27/15
 * Time: 1:05 PM
 */

class SearchView {

    private $user;
    private $searchresults;
    private $site;
    private $sights;
    private $freindship;
    private $invitations;
    private  $freindsCount;

    
        public function __construct(Site $site, $user,$request){


            $this->site = $site;
            $this->sights = new Sights($site);
            $Interests = new  Interests($site);
            $documents = new  Documents($site);
            $projects = new   Projects($site);
            $users = new Users($site);
            if(isset($_REQUEST['i'])){
                $result =$_REQUEST['i'];
                $this->searchresults = $users->searchbyInterest($result);
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


if(empty($this->searchresults)){

    return "";
}




        if (sizeof( $this->searchresults) > 0 ) {


            $html = <<<HTML

HTML;
            $used = array();
            foreach ( $this->searchresults as $key => $value) {
                $id = $value->getId();
                $userid = $value->getUserid();

                if (!in_array($userid, $used)) {
                    $used[] = $userid;
                    $html .= ' <div class="sighting">';
                    if (!($this->freindship->doesfreindshipExist($id, $currentuserID)) && ($id !== $currentuserID)) {
                        $AddFriend = $this->AddAFreind($value);
                        // $html .= '<div>' . $AddFriend . '</div>';
                    }

                    //$html .= '<h2><a href="sight.php?i=' . $id . '">' . $userid  . '</a></h2>';

                    //$html .= '<div class="sighting">';
                    if (!($this->freindship->doesfreindshipExist($id, $currentuserID)
                            || $this->freindship->doesPendingExist($id, $currentuserID)) && ($id !== $currentuserID)
                    ) {
                        $AddFriend = $this->AddAFreind($value);
                        $html .= '<div>' . $AddFriend . '</div>';
                    }

                    $root = $this->site->getRoot();
                    if ($value->getPrivacy() == 'low' || $value->getPrivacy() == 'medium') {
                        $html .= '<h2><a href="' . $root . '/?i=' . $id . '">' . $userid . '</a></h2>';
                        $html .= '</div>';
                    } /*elseif ($value->getPrivacy() == 'medium' && $this->invitations->isCollaborator($currentusername, $userid)) {
                    $html .= '<h2><a href="'. $root . '/?i=' . $id . '">' . $userid  . '</a></h2>';
                    $html .= '</div>';
                }*/ else {
                        if ($this->freindship->doesfreindshipExist($id, $currentuserID) && ($id !== $currentuserID)) {
                            $html .= '<h2><a href="' . $root . '/?i=' . $id . '">' . $userid . '</a></h2>';
                            $html .= '</div>';
                        } else {
                            $html .= '<h2>' . $userid . '</h2>';
                            $html .= '</div>';
                        }
                    }
                }
            }

            return $html;
        }
    }

    public function AddAFreind($currentUser){
        $userId = $currentUser->getId();

            $html = <<<HTML
HTML;
            $html .= '<div class="farright">';
            $html .= '<p><a href="post/sights-post.php?AddFriend=' .$userId. '">Add Friend</a></p>';
            $html .= '</div>';

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
<p><a href="showProject.php?i=$projectId">$name</a></p>
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