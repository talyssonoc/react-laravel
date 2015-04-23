<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

require_once 'bootstrap.php';

$GLOBALS['reactSource'] = file_get_contents(__DIR__ . '/assets/react.js');
$GLOBALS['componentsSource'] = file_get_contents(__DIR__ . '/tests/fixtures/components.js');

class TestHelpers {

  public static function stringToElement($string) {
    $document = new DOMDocument();
    $document->loadHTML($string, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $element = $document->childNodes->item(0);

    return $element;
  }

  public static function innerHTML($node) {
    $document = new DOMDocument();
    $node = $document->importNode($node, true);
    $document->appendChild($node);
    return $document->saveHTML($node);
  }

  public static function removeAttributes($node) {
    $newNode = $node->cloneNode(true);

    if($node->hasAttributes()) {
      $attributes = $node->attributes;
      foreach ($attributes as $i => $attr){
        $newNode->removeAttribute($attr->name);
      }
    }

    if($newNode->hasChildNodes()) {
      $childNodes = $newNode->childNodes;
      for($i = 0; $i < $childNodes->length; $i++) {
        $child = $childNodes->item($i);
        $newNode->replaceChild(TestHelpers::removeAttributes($child), $child);
      }
    }

    return $newNode;
  }
}
