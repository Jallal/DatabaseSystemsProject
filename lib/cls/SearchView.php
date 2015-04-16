<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 3/27/15
 * Time: 1:05 PM
 */

class SearchView {

    private $user;
    private $results;
    private $sights;
    private $freindship;
    private  $freindsCount;

    
        public function __construct(Site $site, $user,$request){
            $result =$_REQUEST['i'];
            $this->sights = new Sights($site);
            $Interests = new  Interests($site);
            $documents = new  Documents($site);
            $projects = new   Projects($site);
            $users = new Users($site);
            $this->freindship = new Friendship($site);
            $this->user = $user;
            $this->results = $users->searchForAUser($result);
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

        if (sizeof($this->results) > 0 ) {


            $html = <<<HTML

HTML;
            foreach ($this->results as $key => $value) {
                $id = $value->getId();
                $name = $value->getName();
<<<<<<< HEAD
                $addToProject = $this->addToProject($value);
                    $html .= ' <div class="sighting">';
                    if (!($this->freindship->doesfreindshipExist($id, $currentuserID))&&($id!==$currentuserID)) {
                        $AddFriend = $this->AddAFreind($value);
                        $html .= '<div>' . $AddFriend . '</div>';
                    }
                    $html .= '<div>' . $addToProject . '</div>';
                    $html .= '<h2><a href="sight.php?i=' . $id . '">' . $name . '</a></h2>';
=======
                $html .= '<div class="sighting">';
                if (!($this->freindship->doesfreindshipExist($id, $currentuserID)
                        || $this->freindship->doesPendingExist($id, $currentuserID)) && ($id!==$currentuserID)) {
                    $AddFriend = $this->AddAFreind($id, $value);
                    $html .= '<div>' . $AddFriend . '</div>';
                }

                if ($value->getPrivacy() == 'low') {
                    $html .= '<h2><a href="profile.php?i=' . $id . '">' . $name . '</a></h2>';
                    $html .= '</div>';
                } elseif ($value->getPrivacy() == 'medium') {
                    $html .= '<h2><a href="profile.php?i=' . $id . '">' . $name . '</a></h2>';
>>>>>>> cb129134bc05d0f29225031c1961212fc01f904d
                    $html .= '</div>';
                } else {
                    if ($this->freindship->doesfreindshipExist($id, $currentuserID) && ($id !== $currentuserID)) {
                        $html .= '<h2><a href="profile.php?i=' . $id . '">' . $name . '</a></h2>';
                        $html .= '</div>';
                    } else {
                        $html .= '<h2>' . $name . '</h2>';
                        $html .= '</div>';
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


    public function addToProject($invitee){
        $userId = $invitee->getId();

        $html = <<<HTML
HTML;
        $html .= ' <div class="center">';
        $html .= '<p><a href="post/sights-post.php?AddToProject=' .$userId. '">Add to Project </a></p>';
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
    public function presentCurrentDocuments(){


        if (empty( $this->UserDocs )) {
            return "";
        }
        $html = <<<HTML

 <div class="options">
		<h2>Documents</h2>
HTML;

        foreach( $this->UserDocs as $document) {
            $documentId = $document->getId();
            $name = $document->getName();
            $html .= <<<HTML
<p><a href="#=$documentId">$name</a></p>
HTML;
        }
        $html .= '</div>';
        return $html;


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




}