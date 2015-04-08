;(function(document, window) {

  window.ReactLaravelUJS = {
    CLASS_NAME_ATTR: 'data-react-class',
    PROPS_ATTR: 'data-react-props',

    getElements: function getElements() {
      var finder = function finder(selector) {
        if(typeof jQuery === 'undefined') {
          return document.querySelectorAll(selector);
        }
        else {
          return jQuery(selector);
        }
      };

      return finder('[' + ReactLaravelUJS.CLASS_NAME_ATTR + ']');
    },

    mountComponents: function mountComponents() {
      var elements = ReactLaravelUJS.getElements();
      var element;
      var reactClass;
      var props;

      for(var i = 0; i < elements.length; i++) {
        element = elements[i];
        reactClass = window[element.getAttribute(ReactLaravelUJS.CLASS_NAME_ATTR)];
        props = JSON.parse(element.getAttribute(ReactLaravelUJS.PROPS_ATTR));

        React.render(React.createElement(reactClass, props), element);
      }
    },

    unmountComponents: function unmountComponents() {
      var elements = ReactLaravelUJS.getElements();

      for(var i = 0; i < elements.length; i++) {
        React.unmountComponentAtNode(elements[i]);
      }
    },

    handleEvents: function handleEvents() {
      document.addEventListener('DOMContentLoaded', ReactLaravelUJS.mountComponents);
      window.addEventListener('unload', ReactLaravelUJS.unmountComponents);
    }
  };

  ReactLaravelUJS.handleEvents();

})(document, window);