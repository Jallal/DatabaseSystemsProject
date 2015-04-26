<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/26/15
 * Time: 2:28 PM
 */

class DocView {
    private $user;
    private $project;
    private $projDocs;
    private $AllDocCom;
    private $comments;

    public function __construct(Site $site, User $user = null, $request)
    {
        $this->site = $site;
        $this->user = $user;
        $result = array();
        $friendship = new  Friendship($site);
        $Interests = new  Interests($site);
        $documents = new  Documents($site);
        $this->comments = new Comments($site);
        $projects = new   Projects($site);
        if (isset($request['i'])) {

            $this->project = $projects->getproject($request['i']);
            $this->projDocs = $documents->AllProjectDocuments($request['i']);
            $this->freindsCount = $friendship->CountFriends($this->user->getId());
            $this->UseInterests = $Interests->UserInterests($this->user->getUserid());
            $this->ProjsCount = $projects->ProjectsCount($this->user->getUserid());
            $this->DocsCount = $documents->DocumentsCount($this->user->getUserid());


        }


    }



    public function ShowProject(){

        $html = <<<HTML

HTML;
        $title = $this->project->getName();
        $id = $this->project->getId();
        $ownerid = $this->project->getOwnerId();
        $userid = $this->user->getUserid();
        $time = date('Y-m-d G:ia' ,$this->project->getCreated());
        $delete = $this->deleteProjrct($userid, $ownerid, $id );
        $html .= ' <div class="sighting">';
        $html .= '<div>' . $delete . '</div>';
        $html .= '<h2><a href="#">' . $title. '</a></h2>';
        $html .= '<p class="time"> ' . $time . ' </p>';
        if(!(empty($this->projDocs))) {

            foreach ($this->projDocs as $key => $value) {

                $version = $value->getVersion();
                $doctime = date('Y-m-d G:ia', $value->getCreateTime());
                $cretedby = $value->getCreatorid();
                $Docname = $value->getName();
                $DocID= $value->getId();
                $html .= ' <div class="docs">';
                $html .= '<p><strong>Document</strong> :&nbsp ' .  $Docname . '&nbsp &nbsp <strong>Veriosn &nbsp:</strong>&nbsp '.   $version . '&nbsp &nbsp<strong>Created by : &nbsp</strong>'.   $cretedby .''.'</p>';
                $html .= '<p class="time"> ' . $doctime . ' </p>';
                $html .= '</div>';
                $html.='<p>'.$this->getCoomentForDoc($DocID).'</p>';
                $html .= '<form   name="comment" action="post/comment-post.php" method="post">';

                $html .= '<div class="text">';
                $html .= '<textarea rows="5" cols="50" name="comment" id="comment"></textarea>';
                $html .= '</div>';
                $html .= '<br>';
                $html .= '<input class ="addcomment" type="hidden" name="docID"  value=' . $DocID . '>';
                $html .= '<input class ="addcomment" type="hidden" name="projectID"  value=' . $id . '>';
                $html .= '<br>';
                $html .= '<input class ="addcomment" type="submit"  name ="add_comment" value="Write a Comment">';
                $html .= '</div>';
                $html .= '</form>';


            }

        }
        $html .= '</div>';


        return $html;


    }




    public function getuserName()
    {
        return $this->user->getName();
    }


    public function getDocsCount()
    {
        return $this->DocsCount;
    }

    public function getProjsCount()
    {
        return $this->ProjsCount;
    }

    public function FriendsCount()
    {
        return $this->freindsCount;
    }






    public function getCoomentForDoc($DocID){
        $this->AllDocCom = $this->comments->getCommentsbyDOCid($DocID);

        if(!empty($this->AllDocCom)) {

            $html = <<<HTML

HTML;
            foreach($this->AllDocCom as $key => $value) {
                $html .= ' <div class=" comments">';
                $html .= '<p><strong>' . $value->getcommenterId() . '</strong>:&nbsp&nbsp &nbsp' . $value->getmessage() . '</p>';
                $html .= '</div>';

            }
        }
        return $html;

    }

    public function deleteProjrct($userid, $ownerid,$projID){
        $html = <<<HTML
HTML;
        if($userid===$ownerid){
            $html .= '<div class="farright">';
            $html .= '<p><a href="post/project-post.php?delete='.$projID.'">Delete</a></p>';
            $html .= '</div>';
        }


        return $html;
    }



}