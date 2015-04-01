<?php
/**
 * Class UserView View class for a user
 */

class UserView {
    private $user;
    private $userSights;
    private $userPendingFriends;
    private $CurrentFriends;
    private $redirect = false;

    public function __construct(Site $site, User $user=null, $request) {
        $friendship = new  Friendship($site);
        if (isset($request['i'])) {
            $users = new Users($site);
            $this->user = $users->get($request['i']);
            $this->userPendingFriends = $friendship->getPendingForUser($this->user->getId());
            $this->CurrentFriends  = $friendship->getCurrentFriends($this->user->getId());
            if ($this->user === null) $this->redirect = true;
        } else {
            $this->user = $user;
        }
        if (!$this->redirect) {
            $sights = new Sights($site);
            $this->userSights = $sights->getSightsForUser($this->user->getId());
            $this->userPendingFriends = $friendship->getPendingForUser($this->user->getId());
            $this->CurrentFriends  = $friendship->getCurrentFriends($this->user->getId());
        }
    }

    /**
     * @return boolean redirect
     */
    public function shouldRedirect() {
        return $this->redirect;
    }

    /**
     * @return string name of the user
     */
    public function getName() {
        return $this->user->getName();
    }

    /**
     * @return string HTML for the SIGHTS block
     */


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
           <p><a href="index.php?i=$id">$name</a></p>
           <p><a href="edituser.php?i=$id">Edit Profile</a></p>

           </div>
HTML;
        return $right;
    }


    public function presentProfile() {
        $name=$this->user->getName();
        $id = $this->user->getId();
        $email = $this->user->getEmail();
        $city  = $this->user->getCity();
        $state = $this->user->getState();
        $YOB = $this->user->getState();
        $right = <<<HTML
             <div class="options">
            <h2>User Information</h2>
            <p>Full Name:&nbsp&nbsp$name</p>
            <p>Email Address:&nbsp&nbsp$email</p>
            <p> From&nbsp&nbsp&nbsp$city&nbsp&nbsp$state </p>
            <p>Year of birth  $YOB </p>
           </div>
HTML;
        return $right;
    }




}