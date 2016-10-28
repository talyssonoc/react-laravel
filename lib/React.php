<?php namespace React;

  // Fix PHPUnit issue with relative path for `autoload.php`
  if(!defined('ENVIRONMENT') || ENVIRONMENT != 'test') {
    require_once '../vendor/autoload.php';
  }

  class React {
    private $react = null;
    private $defaultOptions;
    private $reactSource;
    private $componentsSource;

    /**
     * Constructor
     * @param string $reactSource      Source code of ReactJS lib
     * @param string $componentsSource Source code of file with available components
     */
    public function __construct($reactSource, $componentsSource) {
      $this->reactSource = $reactSource;
      $this->componentsSource = $componentsSource;
      $this->defaultOptions = [
        'prerender' => true,
        'tag' => 'div'
      ];
    }

    /**
     * Returns the ReactJS serverside rendering instance associated with this
     * object.
     * @return ReactJS The instance, if it does not exist yet, it will be created
     */
    private function getReact () {
      if ($this->react === null) {
        $this->react = new \ReactJS($this->reactSource, $this->componentsSource);
        $this->setErrorHandler();
      }
      return $this->react;
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
      $tag = $options['tag'];
      $markup = '';

      // Creates the markup of the component
      if ($options['prerender'] === true) {
        $markup = $this->getReact()->setComponent($component, $props)->getMarkup();
      }

      // Pass props back to view as value of `data-react-props`
      $props = htmlentities(json_encode($props), ENT_QUOTES);

      // Gets all values that aren't used as options and map it as HTML attributes
      $htmlAttributes = array_diff_key($options, $this->defaultOptions);
      $htmlAttributesString = $this->arrayToHTMLAttributes($htmlAttributes);

      return "<{$tag} data-react-class='{$component}' data-react-props='{$props}' {$htmlAttributesString}>{$markup}</{$tag}>";
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

    /**
     * Set ReactJS ErrorHandler
     *
     * Throws caught V8Js Exception to be caught by default handler (e.g. Whoops)
     *
     * @return void;
     */
    private function setErrorHandler() {
      $this->react->setErrorHandler(function(\V8JsException $err) {
        throw $err;
      });
    }
  }
