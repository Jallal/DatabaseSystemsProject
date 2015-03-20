<?php
/**
 * Class SightView View class for a sight
 */
class SightView {
    private $site;
    private $sight;
    private $user;
    private $redirect = false;

    /**
     * Constructor
     * @param $site Site we are a member of
     * @param $request array $_REQUEST
     * @param $user User viewing the site
     */
    public function __construct(Site $site, $request, User $user=null) {
        $this->user = $user;
        $sights = new Sights($site);

        if (isset($request['i'])) {
            $this->sight = $sights->get($request['i']);
            if ($this->sight === null) $this->redirect = true;
        } else {
            $this->redirect = true;
        }
        $this->site = $site;
    }

    /**
     * @return boolean redirect
     */
    public function shouldRedirect() {
        return $this->redirect;
    }

    /**
     * @return string name of the sight
     */
    public function getName() {
        return $this->sight->getName();
    }

    /**
     * @return string description of the sight
     */
    public function getDescription() {
        return $this->sight->getDescription();
    }

    /**
     * @return string HTML for the Super Sighter block
     */
    public function presentSuper() {
        $userid = $this->sight->getUserid();
        $users = new Users($this->site);
        $user = $users->get($userid);
        $name = $user->getName();
        $joined = date("n-d-Y", $this->sight->getCreated());

        return <<<HTML
<div class="options">
            <h2>SUPER SIGHTER</h2>
            <p><a href="./?i=$userid">$name</a></p>
            <p>Since $joined</p>
        </div>
HTML;

    }

    /**
     * @return string HTML for the delete link
     */
    public function deleteLink() {
        if ($this->sight->getUserid() === $this->user->getId()) {
            $sightId = $this->sight->getId();
            return <<<HTML
<div class="options">
<p><a href="post/sights-post.php?d=$sightId">Delete Sight</a></p>
</div>
HTML;
        } else {
            return "";
        }
    }

    /**
     * @return HTML for the Stats block
     */
    public function presentStats() {
        return '';
    }

    /**
     * @return HTML for all of the sightings
     */
    public function presentSightings() {
        return '';
    }
}