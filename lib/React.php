<?php namespace React;

  require '../vendor/autoload.php';

  class React {
    private $react;
    private $defaultOptions;

    public function __construct($reactSource, $componentsSource) {
      $this->react = new \ReactJS($reactSource, $componentsSource);
      $this->defaultOptions = [
        'prerender' => true,
        'tag' => 'div'
      ];
    }

    public function render($component, $props = [], $options = []) {
      $options = array_merge($this->defaultOptions, $options);

      if($options['prerender'] === true) {
        $this->react->setComponent($component, $props);
        $markup = $this->react->getMarkup();
      }
      else {
        $markup = '';
      }

      $props = htmlentities(json_encode($props), ENT_QUOTES);
      $tag = $options['tag'];

      return "<{$tag} data-react-class='{$component}' data-react-props='{$props}'>{$markup}</{$tag}>";
    }
  }