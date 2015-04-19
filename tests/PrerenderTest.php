<?php

use React\React;

class PrerenderTagTest extends PHPUnit_Framework_TestCase {
  
  protected $react;

  public function setUp() {
    $this->react = new React($GLOBALS['reactSource'], $GLOBALS['componentsSource']);
  }

  public function testWithoutPrerender() {
    $elementString = $this->react->render('Alert', null, [ 'prerender' => false ]);
    $wrapperElement = TestHelpers::stringToElement($elementString);

    $this->assertFalse($wrapperElement->hasChildNodes());
  }

  public function testWithPrerender() {
    $elementString = $this->react->render('Alert', [ 'name' => 'react-laravel' ], [ 'prerender' => true ]);
    $wrapperElement = TestHelpers::stringToElement($elementString);

    $this->assertEquals('Hello, react-laravel', $wrapperElement->textContent);

    $expectedElement = TestHelpers::stringToElement('<div><span>Hello, </span><strong>react-laravel</strong></div>');
    $elementWithoutAttributes = TestHelpers::removeAttributes($wrapperElement->childNodes->item(0));
    
    $this->assertEquals(TestHelpers::innerHTML($expectedElement),
                        TestHelpers::innerHTML($elementWithoutAttributes));
  }

}