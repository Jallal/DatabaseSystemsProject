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




        public function __construct(Site $site, $user,$request){
            $result =$_REQUEST['i'];

            $this->sights = new Sights($site);
            $users = new Users($site);
            $this->freindship = new Friendship($site);
            $this->user = $user;
            $this->results = $users->searchForAUser($result);
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



}