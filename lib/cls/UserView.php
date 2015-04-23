<?php
/**
 * Class UserView View class for a user
 */

class UserView {
    private $user;
    private $userSights;
    private $userPendingFriends;
    private $CurrentFriends;
    private $UseInterests;
    private $redirect = false;
    private $freindsCount;
    private $UserDocs;
    private $UserProjs;
    private $DocsCount;
    private $ProjsCount;
    private $site;
    private $viewingUser;

    public function __construct(Site $site, User $user=null, $request) {
        $this->site = $site;
        $this->viewingUser = $user;
        $friendship = new  Friendship($site);
        $Interests = new  Interests($site);
        $documents = new  Documents($site);
        $projects = new   Projects($site);
        if (isset($request['i'])) {
            $users = new Users($site);
            $this->user = $users->get($request['i']);
            $this->userPendingFriends = $friendship->getPendingForUser($this->user->getId());
            $this->CurrentFriends  = $friendship->getCurrentFriends($this->user->getId());
            $this->freindsCount = $friendship->CountFriends($this->user->getId());
            $this->UseInterests  = $Interests->UserInterests($this->user->getUserid());
            $this->ProjsCount = $projects->ProjectsCount($this->user->getUserid());
            $this->DocsCount = $documents->DocumentsCount($this->user->getUserid());
            $this->UserProjs = $projects->AllUserProjects($this->user->getUserid());
            $this->UserDocs = $documents->AllUserDocuments($this->user->getUserid());
            if ($this->user === null) $this->redirect = true;
        } else {
            $this->user = $user;
            $this->viewingUser = $user;
        }
        if (!$this->redirect) {
            $sights = new Sights($site);
            $this->userSights = $sights->getSightsForUser($this->user->getId());
            $this->userPendingFriends = $friendship->getPendingForUser($this->user->getId());
            $this->CurrentFriends  = $friendship->getCurrentFriends($this->user->getId());
            $this->UseInterests  = $Interests->UserInterests($this->user->getUserid());
            $this->freindsCount = $friendship->CountFriends($this->user->getId());
            $this->ProjsCount = $projects->ProjectsCount($this->user->getUserid());
            $this->DocsCount = $documents->DocumentsCount($this->user->getUserid());
            $this->UserProjs = $projects->AllUserProjects($this->user->getUserid());
            $this->UserDocs = $documents->AllUserDocuments($this->user->getUserid());

        }


    }

    public function isSameUser() {
        return ($this->user->getId() === $this->viewingUser->getId());
    }

    public function areCollabs() {
        $invitations = new Invitations($this->site);
        return $invitations->isCollaborator($this->getUsername(), $this->viewingUser->getUserid());
    }

    public function areFriends() {
        $friendship = new Friendship($this->site);
        return $friendship->doesfreindshipExist($this->user->getId(), $this->viewingUser->getId());
    }

    /**
     * @return boolean redirect
     */
    public function shouldRedirect() {
        return $this->redirect;
    }
    public function getDocsCount() {
        return $this->DocsCount;
    }
    public function getProjsCount() {
        return $this->ProjsCount;
    }

    public function FriendsCount() {
        return $this->freindsCount;
    }

    /**
     * @return string name of the user
     */
    public function getName() {
        return $this->user->getName();
    }
    public function getEmail() {
        return $this->user->getEmail();
    }
    public function getCity()
    {
        return $this->user->getCity();
    }
    public function getState()
    {
        return $this->user->getState();
    }
    public function getPrivacy()
    {
        return $this->user->getPrivacy();
    }

    public function getBirthyear()
    {
        return $this->user->getBirthyear();
    }

    public function getUsername() {
        return $this->user->getUserid();
    }

    public function presentInterests(){
        if (empty($this->UseInterests)) {
            return "&nbsp&nbspNONE";
        }

        $html = <<<HTML
HTML;
        foreach($this->UseInterests as $Interest) {
            $interest = $Interest->getInterest();

            $html .=  <<<HTML

             $interest,&nbsp
HTML;
        }

        return substr($html,0,strlen($html)-6);


    }

    /**
     * @return string HTML for the SIGHTS block
     */


    public function presentCurrentFriends(){
        if($this->user->getId() !== $this->viewingUser->getId()) {
            if ($this->user->getPrivacy() !== "low") {
                return "";
            }
        }
        $html = <<<HTML
<div class="options">
		<h2>Friends</h2>
HTML;

        foreach($this->CurrentFriends as $friend) {
            $friendId = $friend->getId();
            $name = $friend->getName();
            $html .=  <<<HTML
<p><a href="profile.php?i=$friendId ">$name</a></p>
<div class="farright2"><a href="post/sights-post.php?delete=$friendId">Remove</a></div>
HTML;
        }
        $html .= '</div>';
        return $html;


    }


    public function presentPendingRequests(){

        if (empty($this->userPendingFriends) || ($this->user->getId() !== $this->viewingUser->getId())) {
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
        if ($this->user->getId() !== $this->viewingUser->getId()) {
            $friendship = new Friendship($this->site);
            if ($this->user->getPrivacy() === "high" && !$friendship->doesfreindshipExist($this->user->getId(), $this->viewingUser->getId())) {
                return "";
            } else {
                $id = $this->user->getId();
                $right = <<<HTML
<div class="options">
          <h2>Welcome</h2>
          <p><a href="profile.php?i=$id">View Profile</a></p>
HTML;
                $right.='</div>';
                return $right;
            }
        }
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
HTML;
        $right.='</div>';
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