<?php

return [
  'react'      => implode( DIRECTORY_SEPARATOR, [ App::publicPath(), 'vendor', 'react-laravel', 'react.js' ] ),
  'components' => implode( DIRECTORY_SEPARATOR, [ App::publicPath(), 'js', 'components.js' ] ),
];
