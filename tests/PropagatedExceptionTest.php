<?php

use React\React;

class PropagatedExceptionTest extends PHPUnit_Framework_TestCase {

  protected $react;

  public function setUp() {
    $this->react = new React(
      $GLOBALS['reactSource'],
      $GLOBALS['componentsSource']
    );
  }

  /**
   * @expectedException V8JsException
   */
  public function testNonExistentComponent() {
    $randomComponentName = uniqid('react');
    $elementString = $this->react->render($randomComponentName);
  }

}
