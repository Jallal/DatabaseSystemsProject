<?php
/**
 * Created by PhpStorm.
 * User: madejekz
 * Date: 4/28/2015
 * Time: 1:12 PM
 */

require '../lib/site.inc.php';

if (isset($_GET['i'])) {
    $documents = new Documents($site);
    $document = $documents->get($_GET['i']);

    $size = $document->getSize();
    $name = $document->getName();
    $type = $document->getType();
    $content = $document->getContent();

    /*$tmp = explode(".",$name);
    switch ($tmp[count($tmp)-1]) {
        case "pdf": $type="application/pdf"; break;
        case "exe": $type="application/octet-stream"; break;
        case "zip": $type="application/zip"; break;
        case "docx": $type="application/vnd.openxmlformats-officedocument.wordprocessingml.document"; break;
        case "doc": $type="application/msword"; break;
        case "csv":
        case "xls":
        case "xlsx": $type="application/vnd.ms-excel"; break;
        case "ppt": $type="application/vnd.ms-powerpoint"; break;
        case "gif": $type="image/gif"; break;
        case "png": $type="image/png"; break;
        case "jpeg":
        case "jpg": $type="image/jpg"; break;
        case "tif":
        case "tiff": $type="image/tiff"; break;
        case "psd": $type="image/psd"; break;
        case "bmp": $type="image/bmp"; break;
        case "ico": $type="image/vnd.microsoft.icon"; break;
        default: $type="application/force-download";
    }*/

    header("Content-length: $size");
    header("Content-type: $type");
    header("Content-Disposition: attachment; filename=$name");
    echo stripslashes($content);
}