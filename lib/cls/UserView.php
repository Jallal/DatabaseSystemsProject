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
            $html .=  <<<HTML
             <p>$name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href="post/sights-post.php?accept=$friendId">Accept</a></p>
HTML;
        }
        $html .= '</div>';
        return $html;


    }




}