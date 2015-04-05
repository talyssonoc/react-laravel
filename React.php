<?php namespace React;

  class React {
    public static function render($component, $props) {
      $props = json_encode($props);

      return "<div data-react-class='{$component}' data-react-props='{$props}'></div>";
    }
  }