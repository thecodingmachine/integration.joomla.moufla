<?php

use Mouf\Html\Utils\WebLibraryManager\WebLibrary;

/* @var $object WebLibrary  */

$files = $object->getJsFiles();
if ($files) {
    foreach ($files as $file) {
        if(strpos($file, 'http://') === false && strpos($file, 'https://') === false && strpos($file, '/') !== 0) {
            $url = ROOT_URL.$file;
        } else {
            $url = $file;
        }
        $document = \JFactory::getDocument();
        $document->addScript(htmlspecialchars($url, ENT_QUOTES));
    }
}