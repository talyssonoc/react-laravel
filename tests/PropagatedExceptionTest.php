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

  // Clear and close output buffers opened by thrown error
  public function tearDown() {
    ob_end_clean();
  }

  public function testNonExistentComponent() {
    $this->expectException(V8JsException::class);
    $randomComponentName = uniqid('react');
    $elementString = $this->react->render($randomComponentName);
  }

}
