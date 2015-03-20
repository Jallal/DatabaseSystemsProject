<?php
/**
 * Class UserView View class for a user
 */

class UserView {
    private $user;
    private $userSights;
    private $redirect = false;

    public function __construct(Site $site, User $user=null, $request) {
        if (isset($request['i'])) {
            $users = new Users($site);
            $this->user = $users->get($request['i']);
            if ($this->user === null) $this->redirect = true;
        } else {
            $this->user = $user;
        }
        if (!$this->redirect) {
            $sights = new Sights($site);
            $this->userSights = $sights->getSightsForUser($this->user->getId());
        }
    }

    /**
     * @return boolean redirect
     */
    public function shouldRedirect() {
        return $this->redirect;
    }

    /**
     * @return string name of the user
     */
    public function getName() {
        return $this->user->getName();
    }

    /**
     * @return string HTML for the SIGHTS block
     */
    public function presentSights() {
        if (empty($this->userSights)) {
            return "";
        }
        $html = <<<HTML
<div class="options">
		<h2>SIGHTS</h2>
HTML;

        foreach($this->userSights as $sight) {
            $sightId = $sight->getId();
            $name = $sight->getName();
            $html .=  <<<HTML
<p><a href="sight.php?i=$sightId">$name</a></p>
HTML;
        }
        $html .= '</div>';
        return $html;
    }
}