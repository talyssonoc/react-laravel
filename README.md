[![Code Climate](https://codeclimate.com/github/talyssonoc/react-laravel/badges/gpa.svg)](https://codeclimate.com/github/talyssonoc/react-laravel) [![Build Status](https://travis-ci.org/talyssonoc/react-laravel.svg?branch=master)](https://travis-ci.org/talyssonoc/react-laravel)

# react-laravel

With `react-laravel` you'll be able to use [ReactJS](https://facebook.github.io/react/) components right from your Blade views, with optional server-side rendering, and use them on the client-side with React due to unobtrusive JavaScript.

# Installation

## V8js dependency

It's important to know that `react-laravel` has an indirect dependency of the [v8js](https://pecl.php.net/package/v8js) PHP extension.

You can see how to install it here: [how to install v8js](install_v8js.md).

## Composer

You just need to add this to your `composer.json`'s `"require"`:

```json
  "talyssonoc/react-laravel": "0.10.2"
```

Also you got to set the `minimum-stability` of your `composer.json` to `dev`, adding this:

```json
  "minimum-stability": "dev"
```

Then run:

```sh
  $ composer update
```

After that you should add this to your providers at the `config/app.php` file of your Laravel app:

```php
  'React\ReactServiceProvider'
```

And then run:

```sh
  php artisan vendor:publish
```

And the `react.php` file will be available at the `config` folder of your app.

# Usage

After the installation and configuration, you'll be able to use the `@react_component` directive in your views.

The `@react_component` directive accepts 3 arguments:

```php
  @react_component(<componentName>[, props, options])

  //example
  @react_component('Message', [ 'title' => 'Hello, World' ], [ 'prerender' => true ])
  
  // example using namespaced component
  @react_component('Acme.Message', [ 'title' => 'Hello, World' ], [ 'prerender' => true ])
```

* `componentName`: Is the name of the global variable that holds your component.  When using [Namespaced Components](https://facebook.github.io/react/docs/jsx-in-depth.html#namespaced-components) you may use dot-notation for the component name.
* `props`: Associative of the `props` that'll be passed to your component
* `options`: Associative array of options that you can pass to the `react-laravel`:
  * `prerender`: Tells react-laravel to render your component server-side, and then just _mount_ it on the client-side. Default to __true__.
  * `tag`: The tag of the element that'll hold your component. Default to __'div'__.
  * _html attributes_: Any other valid HTML attribute that will be added to the wrapper element of your component. Example: `'id' => 'my_component'`.

All your components should be inside `public/js/components.js` (you can configure it, see below) and be global.

You must include `react.js` and `react_ujs.js` (in this order) in your view.

`react-laravel` provides a ReactJS installation and the `react_us.js` file, they'll be at `public/vendor/react-laravel` folder after you install `react-laravel` and run:

```sh
  $ php artisan vendor:publish --force
```

For using the files provided by `react-laravel` and your `components.js` file, add this to your view:

```html
  <script src="{{ asset('vendor/react-laravel/react.js') }}"></script>
  <script src="{{ asset('js/components.js') }}"></script>
  <script src="{{ asset('vendor/react-laravel/react_ujs.js') }}"></script>
```

If you'll use a different version from the one provided by react-laravel (see `composer.json`), you got to configure it (see bellow).

# Configurations

You can change settings to `react-laravel` at the `config/react.php` file:

```php
  return [
    'source' => 'path_for_react.js',
    'components' => 'path_for_file_containing_your_components.js'
  ];
```

Both of then are optional.

* `source`: defaults to `public/vendor/react/laravel/react.js`.
* `components`: defaults to `public/js/components.js`

Your `components.js` file should also be included at your view, and all your components must be at the `window` object.

# Thanks

This package is inspired at [react-rails](https://github.com/reactjs/react-rails).
