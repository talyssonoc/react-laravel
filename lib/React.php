<?php namespace React;

  require 'vendor/autoload.php';

  class React {
    private $react;

    public function __construct($reactSource, $componentsSource) {
      $this->react = new ReactJS($reactSource, $componentsSource);
    }

    public function render($component, $props = [], $options = []) {

      if(isset($options['prerender'])) {
        $this->react->setComponent($component, $props);
        $markup = $this->react->getMarkup();
      }

      $props = json_encode($props);

      return "<div data-react-class='{$component}' data-react-props='{$props}'>
                {$markup}
              </div>";
    }
  }