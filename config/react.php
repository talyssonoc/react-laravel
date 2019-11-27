<?php

return [

  /*
  |--------------------------------------------------------------------------
  | React Source
  |--------------------------------------------------------------------------
  |
  | Path to the react.js file.
  |
  */

  'source'     => public_path('vendor/react-laravel/react.js'),

  /*
  |--------------------------------------------------------------------------
  | React-Dom Source
  |--------------------------------------------------------------------------
  |
  | Path to the react-dom.js file.
  |
  */

  'dom-source' => public_path('vendor/react-laravel/react-dom.js'),

  /*
  |--------------------------------------------------------------------------
  | React-Dom-Server Source
  |--------------------------------------------------------------------------
  |
  | Path to the react-dom-server.js file.
  |
  */

  'dom-server-source' => public_path('vendor/react-laravel/react-dom-server.js'),

  /*
  |--------------------------------------------------------------------------
  | Components
  |--------------------------------------------------------------------------
  |
  | An array of paths to the javascript files containing your components.
  |
  */

  'components' => [
    public_path('js/components.js')
  ]
];
