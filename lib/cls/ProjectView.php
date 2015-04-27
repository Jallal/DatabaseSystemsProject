<?php
/**
 * Class UserView View class for a user
 */

class ProjectView
{
    private $user;
    private $project;
    private $projDocs;
    private $Allcolabproj;
    private $comments;
    private $projColab;

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
        $invitations = new Invitations($site);
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