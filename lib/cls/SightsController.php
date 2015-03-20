<?php


class SightsController {
    private $site;
    private $user;
    private $page;
    private $lastInserted;
    private $deleteWorked;

    public function __construct(Site $site, User $user, $request) {
        $this->page = $site->getRoot();
        $this->site = $site;
        $this->user = $user;

        if (isset($request['d'])) {
            $this->deleteSight($request['d']);
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

    public function deleteSight($id) {
        $sights = new Sights($this->site);
        $this->deleteWorked = $sights->deleteSight($id);
    }

    public function getLastInsertedId() {
        return $this->lastInserted;
    }

    public function didDeleteWork() {
        return $this->deleteWorked;
    }
}