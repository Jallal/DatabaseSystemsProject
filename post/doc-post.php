<?php
/**
 * Created by PhpStorm.
 * User: madejekz
 * Date: 4/28/2015
 * Time: 11:47 AM
 */
require '../lib/site.inc.php';

if (isset($_POST['upload']) && $_FILES['document']['size'] > 0) {
    $name = $_FILES['document']['name'];
    $projid = $_POST['projid'];
    $userid = $user->getUserid();
    $tmpName = $_FILES['document']['tmp_name'];
    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);
    $size = $_FILES['document']['size'];
    $type = $_FILES['document']['type'];
    if(!get_magic_quotes_gpc())
    {
        $name = addslashes($name);
    }
    $documents = new Documents($site);
    $result = $documents->updateDocument($name, $projid, $userid, $content, $size, $type);

    if ($result) {
        header("Location: ../document.php?name=" . $name . "&projid=" . $projid);
        exit;
    } else {
        header("Location: ../");
        exit;
    }
}

if (isset($_POST['create']) && $_FILES['document']['size'] > 0) {
    $name = $_FILES['document']['name'];
    $projid = $_POST['projid'];
    $projownerid = $_POST['projownerid'];
    $userid = $user->getUserid();
    $tmpName = $_FILES['document']['tmp_name'];
    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);
    $size = $_FILES['document']['size'];
    $type = $_FILES['document']['type'];
    if(!get_magic_quotes_gpc())
    {
        $name = addslashes($name);
    }
    $documents = new Documents($site);
    $result = $documents->createDocument($name, $projid, $projownerid, $userid, $content, $size, $type);

    header("Location: ../showProject.php?i=" . $projid);
    exit;
}

if (isset($_GET['delete'])) {
    $documents = new Documents($site);
    $result = $documents->deleteDoc($_GET['delete'], $user->getUserid());

    if ($result[0] === false) {
        $doc = $result[1];
        header("Location: ../document.php?name=" . $doc->getName() . "&projid=" . $doc->getProjid());
        exit;
    } elseif($result[0] == true) {
        $doc = $result[1];
        if ($doc->getVersion() == 1) {
            header("Location: ../showProject.php?i=" . $doc->getProjid());
            exit;
        } else {
            header("Location: ../document.php?name=" . $doc->getName() . "&projid=" . $doc->getProjid());
            exit;
        }
    }
}