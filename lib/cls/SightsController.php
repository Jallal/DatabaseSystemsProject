<?php


class SightsController
{
    private $site;
    private $user;
    private $page = "index.php";
    private $lastInserted;
    private $AddFriend;
    private $friendship;
    private $projects;
    private $invitations;

    public function __construct(Site $site, User $user, $request)
    {


        $this->friendship = new  Friendship($site);
        $this->projects = new  Projects($site);
        $this->invitations = new  Invitations($site);
        $this->page = $site->getRoot();
        $this->site = $site;
        $this->user = $user;


        if (isset($_REQUEST['invite'])&&isset($_REQUEST['projid'])) {
            $inviteeid=$_REQUEST['invite'];
            $projid=$_REQUEST['projid'];
            $ownerid = $this->user->getUserid();
            $this->addToProject($ownerid,$inviteeid,$projid);
        }

        if (isset($_REQUEST['done'])) {
            $this->RemoveColabRequest($_REQUEST['done']);
        }

        if (isset($_POST['title'])) {
            $this->addNewProject($_POST['title']);
        }
        if (isset($_REQUEST['delete'])) {
            $this->deleteProject($_REQUEST['delete']);
        }

        if (isset($request['accept'])) {
            $this->AcceptFriend($request['accept']);
        }
        if (isset($request['delete'])) {
            $this->DeleteFriend($request['delete']);
        }

        if (isset($_REQUEST['acProj'])) {
            $this->AcceptProjRequest($_REQUEST['acProj']);
        }
        if (isset($_REQUEST['deProj'])) {
            $this->DeleteProjRequest($_REQUEST['deProj']);
        }

        if (isset($request['AddFriend'])) {
            $this->AddFriend($request['AddFriend']);
        } elseif (isset($request['name'])) {
            $this->insert($request);
        }
    }

    public function getPage()
    {
        return $this->page;
    }

    public function insert($post)
    {
        $sights = new Sights($this->site);
        $this->lastInserted = $sights->newSight($this->user->getId(),
            $post['name'], $post['description']);
    }

    public function AddFriend($id)
    {
        $this->friendship->AddRequest($this->user->getId(), $id);
    }

    public function AcceptFriend($id)
    {
        $this->friendship->acceptRequest($this->user->getId(), $id);

    }

    public function DeleteFriend($id)
    {

        $this->friendship->RemoveFriend($this->user->getId(), $id);
    }

    public function getLastInsertedId()
    {
        return $this->lastInserted;
    }

    public function didDeleteWork()
    {
        return $this->AddFriend;
    }

    public function addNewProject($title)
    {
        $this->projects->addAProject($this->user->getUserid(), $title);
        $this->page = $this->site->getRoot();
        return $this->page;
    }

    public function deleteProject($delete)
    {
        $this->removeColab($delete);
        $this->projects->deleteproject($delete);
        $this->page = $this->site->getRoot();
        return $this->page;

    }

    public function AcceptProjRequest($projID)
    {
        $this->invitations->acceptRequest($projID,$this->user->getUserid());
        $this->page = $this->site->getRoot();
        return $this->page;

    }

public function  RemoveColabRequest($projID){
    $this->invitations->RemoveRequest($projID,$this->user->getUserid());
    $this->page = $this->site->getRoot();
    return $this->page;

}
    public function DeleteProjRequest($projID)
    {
        $this->invitations->RejectRequest($projID,$this->user->getUserid());
        $this->page = $this->site->getRoot();
        return $this->page;
    }


    public function addToProject($ownerid,$inviteeid,$projid){

        $this->invitations->addUserToMyProj($ownerid,$inviteeid,(int)$projid,'pending');
        $this->page = $this->site->getRoot();
        return $this->page;
    }


    public function removeColab($projid){

        $this->invitations->RemoveAllProjectColaborators($projid);
    }


}