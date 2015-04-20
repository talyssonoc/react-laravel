<?php namespace React;

  require __DIR__ . '/../vendor/autoload.php';

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
      $options = array_merge($this->defaultOptions, $options);

      if($options['prerender'] === true) {
        $this->react->setComponent($component, $props);
        $markup = $this->react->getMarkup();
      }
      else {
        $markup = '';
      }

      $tag = $options['tag'];
      $props = htmlentities(json_encode($props), ENT_QUOTES);

      // Gets all values that aren't used as options and map it as HTML attributes
      $htmlAttributes = array_diff_key($options, $this->defaultOptions);
      $htmlAttributesString = '';
      foreach ($htmlAttributes as $attribute => $value) {
        $htmlAttributesString .= "{$attribute}='{$value}'";
      }

      return "<{$tag} data-react-class='{$component}' data-react-props='{$props}' {$htmlAttributesString}>{$markup}</{$tag}>";
    }
  }