$(function () {
  $('[data-react-class]').each(function() {
    var reactClass = React.createFactory(window[$(this).attr('data-react-class')]);
    var props = JSON.parse($(this).attr('data-react-props'));

    React.render(reactClass(props), this);
  });  
});