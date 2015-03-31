<?php


class SightsController {
    private $site;
    private $user;
    private $page;
    private $lastInserted;
    private $AddFriend;
    private $friendship;

    public function __construct(Site $site, User $user, $request) {
        $this->friendship = new  Friendship($site);
        $this->page = $site->getRoot();
        $this->site = $site;
        $this->user = $user;
        if (isset($request['accept'])) {
            $this->AcceptFriend($request['accept']);
        }

        if (isset($request['AddFriend'])) {
            $this->AddFriend($request['AddFriend']);
        } elseif(isset($request['name'])) {
            $this->insert($request);
        }
    }

    public function getPage() {
        return $this->page;
    }

    public function insert($post) {
        $sights = new Sights($this->site);
        $this->lastInserted = $sights->newSight($this->user->getId(),
            $post['name'], $post['description']);
    }

    public function AddFriend($id) {
        $this->friendship->AddRequest($this->user->getId(),$id);
    }
    public function AcceptFriend($id){
        $this->friendship->acceptRequest($this->user->getId(),$id);

    }

    public function getLastInsertedId() {
        return $this->lastInserted;
    }

    public function didDeleteWork() {
        return $this->AddFriend;
    }
}