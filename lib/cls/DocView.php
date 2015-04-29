<?php
/**
 * Created by PhpStorm.
 * User: elhazzat
 * Date: 4/26/15
 * Time: 2:28 PM
 */

class DocView {
    private $user;
    private $site;
    private $doc;
    private $docName;
    private $projid;
    private $docTree = array();

    public function __construct(Site $site, User $user = null, $request)
    {
        $this->site = $site;
        $this->user = $user;
        $this->projid = $request['projid'];
        $this->docName = $request['name'];
        if (isset($request['name']) && isset($request['projid'])) {
            $documents = new Documents($this->site);
            $this->docTree = $documents->getDocTree($request['name'], $request['projid']);
        }
    }

    public function showDocTree() {
        $html = "";
        $documents = new Documents($this->site);
        if (!empty($this->docTree)) {
            for ($i = 0; $i < count($this->docTree); $i++) {
                $html .= "<div class='sighting'><p>";
                $doc = $this->docTree[$i];
                $id = $doc->getId();
                $versionNo = $doc->getVersion();
                $parentVer = null;
                if ($doc->getParentdocid() !== null) {
                    $parentDoc = $documents->get($doc->getParentdocid());
                    $parentVer = $parentDoc->getVersion();
                }
                $html .= <<< HTML
<strong>Version: </strong>$versionNo &nbsp;
HTML;
                if ($parentVer !== null) {
                    $html .= "<strong>Parent Version: </strong>$parentVer &nbsp;";
                } else {
                    $html .= "<strong>Parent Version: </strong>NONE &nbsp;";
                }
                if ($i === 0) {
                    $html .= <<< HTML
<a href="post/download.php?i=$id">Download</a> &nbsp;
HTML;
                }
                if ($doc->getCreatorid() === $this->user->getUserid()) {
                    $html .= <<<HTML
<a href="post/doc-post.php?delete=$id">Delete</a>
HTML;
                }
                $html .= "</p>";
                $html .= $this->getDocComments($doc->getId(), $i);
                $html .= "</div>";
            }
        }
        return $html;
    }

    private function getDocComments($DocID, $i) {
        $html = "";
        $html.='<p>';
        $html .= $this->getCommentsForDoc($DocID);
        $html .= '</p>';
        $id = $this->projid;
        if ($i === 0) {
            $html .= '<form   name="comment" action="post/comment-post.php" method="post">';

            $html .= '<div class="text">';
            $html .= '<textarea rows="5" cols="50" name="comment" id="comment"></textarea>';
            $html .= '</div>';
            $html .= '<br>';
            $html .= '<input class="addcomment" type="hidden" name="docID"  value=' . $DocID . '>';
            $html .= '<input class="addcomment" type="hidden" name="projectID"  value=' . $id . '>';
            $html .= '<br>';
            $html .= '<input class ="addcomment" type="submit"  name ="add_comment" value="Write a Comment">';
            $html .= '</form>';
        }

        return $html;
    }

    private function getCommentsForDoc($DocID){
        $comments = new Comments($this->site);
        $AllDocCom = $comments->getCommentsbyDOCid($DocID);
        $html = "";

        if(!empty($AllDocCom)) {
            foreach($AllDocCom as $key => $value) {
                $html .= '<div class="comments">';
                $html .= '<p><strong>' . $value->getcommenterId() . '</strong>:&nbsp&nbsp &nbsp' . $value->getmessage() . '</p>';
                $html .= '</div>';

            }
        }
        return $html;

    }

    public function getProjid() {
        return $this->projid;
    }

    public function getDocName() {
        return $this->docName;
    }

    public function getuserName()
    {
        return $this->user->getName();
    }


    public function getDocsCount()
    {
        $documents = new Documents($this->site);
        return $documents->DocumentsCount($this->user->getUserid());
    }

    public function getProjsCount()
    {
        $projects = new Projects($this->site);
        return $projects->ProjectsCount($this->user->getUserid());
    }

    public function FriendsCount()
    {
        $friendship = new Friendship($this->site);
        return $friendship->CountFriends($this->user->getId());
    }

}