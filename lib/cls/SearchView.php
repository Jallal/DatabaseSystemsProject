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




        public function __construct(Site $site, $user,$request){
            $result =$_REQUEST['i'];
            $this->sights = new Sights($site);
            $users = new Users($site);
            $this->user = $user;
            $this->results = $users->searchForAUser($result);





        }




    public function getName() {


        return  $this->user->getName();
    }



    public function presentSearch() {



        if (sizeof($this->results) > 0 ) {

            $html = <<<HTML

HTML;
            foreach ($this->results as $key => $value) {

                $id = $value->getId();
                $name = $value->getName();


                $html.=' <div class="sighting">';
                $html .= '<h2><a href="sight.php?i='.$id.'">'.$name .'</a></h2>';
                $html .=  '</div>';
            }

            return $html;
        }
    }




}