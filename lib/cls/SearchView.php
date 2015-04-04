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
            $users = new Users($site);
            $this->freindship = new Friendship($site);
            $this->user = $user;
            $this->results = $users->searchForAUser($result);
            $this->userSights =  $this->sights->getSightsForUser($this->user->getId());
            $this->userPendingFriends =  $this->freindship->getPendingForUser($this->user->getId());
            $this->CurrentFriends  =   $this->freindship->getCurrentFriends($this->user->getId());
            $this->UseInterests  = $Interests->UserInterests($this->user->getUserid());
            $this->freindsCount = $this->freindship->CountFriends($this->user->getId());

        }


    public function FriendsCount() {
        return $this->freindsCount;
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
                    $html .= ' <div class="sighting">';
                    if (!($this->freindship->doesfreindshipExist($id, $currentuserID))&&($id!==$currentuserID)) {
                        $AddFriend = $this->AddAFreind($id, $value);
                        $html .= '<div>' . $AddFriend . '</div>';
                    }
                    $html .= '<h2><a href="sight.php?i=' . $id . '">' . $name . '</a></h2>';
                    $html .= '</div>';

            }

            return $html;
        }
    }

    public function AddAFreind($id, $currentUser){
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




}