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
    private  $myinvitations;
    private $site;

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
        $this->myinvitations = new Invitations($site);
        if (isset($request['i'])) {
            $this->project = $projects->getproject($request['i']);
            $this->projDocs = $documents->AllProjectDocuments($request['i']);
            $this->freindsCount = $friendship->CountFriends($this->user->getId());
            $this->UseInterests = $Interests->UserInterests($this->user->getUserid());
            $this->ProjsCount = $projects->ProjectsCount($this->user->getUserid());
            $this->DocsCount = $documents->DocumentsCount($this->user->getUserid());
        }


    }

    public function colaborators($colabo)
    {
        $users = new Users($this->site);

        $html = <<<HTML
HTML;
        foreach ($colabo as $Interest) {
            $interest = $Interest->getCollaboratorid();
            $user = $users->getuserbyUserID($interest);
            $id = $user->getId();

            $html .= <<<HTML
<a href="./?i=$id">$interest</a>,&nbsp
HTML;
        }

        return substr($html, 0, strlen($html) - 6);


    }

    public function ShowProject(){

            $html = <<<HTML

HTML;
        $users = new Users($this->site);
                $title = $this->project->getName();
                $id = $this->project->getId();
                $ownerid = $this->project->getOwnerId();
                $userid = $this->user->getUserid();
                $created = $this->project->getTimeCreated();
                $delete = $this->deleteProjrct($userid, $ownerid, $id );
                 $invitation = $this-> invitationsPossible($userid, $ownerid,$id);
                $html .= ' <div class="sighting">';
                $html .= '<div>' . $delete . '</div>';
                $html .= '<h2>' . $title. '</h2>';
                $html .= '<p class="time"> ' .  $created. ' </p>';
        $owner = $users->getuserbyUserID($ownerid);
        $ownerNum = $owner->getId();
        $html .= '<h4>' ."Project Owner :&nbsp &nbsp <a href=\"./?i=$ownerNum\">".  $ownerid. '</a></h4>';
        $colabo =  $this->myinvitations->allProjectColaborators($id);
        if(empty($colabo)){
            $html .= '<h4>' . "Collaborators :&nbsp &nbsp " .  '&nbsp&nbspNONE' . '</h4>';
        }
        if(!empty($colabo)){
            $colaboratos = $this->colaborators($colabo);
            $html .= '<h4>' . "Collaborators :&nbsp &nbsp " .  $colaboratos . '</h4>';

        }

        $html .= <<< HTML
<div class="sighting">
            <h3>Upload New Document</h3>
            <form method="post" action="post/doc-post.php" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="16000000">
                <input type="hidden" name="projid" value="$id">
                <input type="hidden" name="projownerid" value="$ownerid">
                <input name="document" type="file" id="document">
                <input name="create" type="submit" id="create" value="Upload">
            </form>
        </div>
HTML;
        if(!(empty($this->projDocs))) {
            foreach ($this->projDocs as $key => $value) {
                $version = $value->getVersion();
                $doctime = date('Y-m-d G:ia' ,$value->getCreateTime());
                $cretedby = $value->getCreatorid();
                $Docname = $value->getName();
                $DocID= $value->getId();
                $html .= ' <div class="docs">';
                $html .= '<p><strong>Document:</strong> &nbsp <a href="document.php?name=' . $Docname . '&projid=' . $id . '">' . $Docname . '</a>&nbsp &nbsp <strong>Version:</strong> &nbsp;' . $version . '&nbsp;&nbsp;<strong>Created by: &nbsp</strong>'.   $cretedby .''.'</p>';
                $html .= '<p class="time"> ' . $doctime . ' </p>';
                $html .= '</div>';



            }

        }

            $html .= '<div>' . $invitation . '</div>';
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



    public function invitationsPossible($userid, $ownerid,$projID){


        if($userid===$ownerid){
            $html = <<<HTML
           <form name="search" action="post/search-post.php" method="post">
            <input class = "search" type="text"  name="invite"  value=" ">
            <input class ="search"  type="hidden" name="projectID"  value=$projID>
            <input class = "search" type="submit"  name ="search"   value="Invite">
          </form>
HTML;
            return  $html;
        }

    }


}