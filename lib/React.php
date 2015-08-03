<?php namespace React;

  // Fix PHPUnit issue with relative path for `autoload.php`
  if(!defined('ENVIRONMENT') || ENVIRONMENT != 'test') {
    require_once '../vendor/autoload.php';
  }

  class React {
    private $react;
    private $defaultOptions;

    /**
     * Constructor
     * @param string $reactSource      Source code of ReactJS lib
     * @param string $componentsSource Source code of file with available components
     */
    public function __construct($reactSource, $componentsSource) {
      $this->react = new \ReactJS($reactSource, $componentsSource);
      $this->defaultOptions = [
        'prerender' => true,
        'tag' => 'div'
      ];
    }

    /**
     * Render a ReactJS component
     * @param  string $component Name of the component object
     * @param  array $props     Associative array of props of the component
     * @param  array $options   Associative array of options of rendering
     * @return string            Markup of the rendered component
     */
    public function render($component, $props = null, $options = []) {
      $props           = htmlentities(json_encode($props), ENT_QUOTES);
      $options         = array_merge($this->defaultOptions, $options);
      $tag             = $options['tag'];
      $componentMarkup = '';

      // Creates the markup of the component
      if ($options['prerender'] === true) {
        $componentMarkup = $this->react->setComponent($component, $props)->getMarkup();
      }

      // Gets all values that aren't used as options and map it as HTML attributes
      $htmlAttributes = array_diff_key($options, $this->defaultOptions);
      $htmlAttributesString = $this->arrayToHTMLAttributes($htmlAttributes);

      return "<{$tag} data-react-class='{$component}' data-react-props='{$props}' {$htmlAttributesString}>{$componentMarkup}</{$tag}>";
    }

    /**
     * Convert associative array to string of HTML attributes
     * @param  array $array Associative array of attributes
     * @return string
     */
    private function arrayToHTMLAttributes($array) {
      $htmlAttributesString = '';
      foreach ($array as $attribute => $value) {
        $htmlAttributesString .= "{$attribute}='{$value}'";
      }
      return $htmlAttributesString;
    }
  }
