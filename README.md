[![Code Climate](https://codeclimate.com/github/talyssonoc/react-laravel/badges/gpa.svg)](https://codeclimate.com/github/talyssonoc/react-laravel)

# react-laravel

With `react-laravel` you'll be able to use [ReactJS](https://facebook.github.io/react/) components right from your Blade views, with optional server-side rendering, and use them on the client-side with React due to unobtrusive JavaScript.

# Installation

You just need to add this to your `composer.json`'s `"require"` and then run `composer install`:

```json
  "talyssonoc/react-laravel": "dev-master"`
```

After that you should add `'React\ReactServiceProvider'` to your providers at the `config/app.php` file of your Laravel app.

It's important to know that `react-laravel` has an indirect dependency of the [v8js](https://pecl.php.net/package/v8js) PHP extension.

##### Install v8js on Linux

First run:

```sh
  $ sudo pecl install v8js-beta
```

Then add `extension=v8js.so` to your `php.ini` file.

##### Install v8js on a Mac

Follow [this tutorial](http://www.phpied.com/installing-v8js-for-php-on-a-mac/).

##### Install v8js on Windows

You must have PHP 5.3/5.4/5.5 installed.

Then access [this link](http://windows.php.net/downloads/pecl/snaps/v8js/0.1.3/) and download the zip for your PHP version (don't forget to check if your PHP installation is `ts` or `nts` and if your OS is x86 or x64).

Unzip the file and paste the `v8.dll` file in your PHP installation folder, and `php_v8.dll` in your `php/ext` folder.

Then add `extension=php_v8js.dll` to your `php.ini` file.

# Usage

After the installation and configuration, you'll be able to use the `@react_component` directive in your views.

The `@react_component` directive accepts 3 arguments:

```php
  @react_component(&lt;componentName&gt;[, &lt;props&gt;, &lt;options&gt;])

  //example
  @react_component('Message', [ 'title' => 'Hello, World' ], [ 'prerender' => true ])
```

* `componentName`: Is the name of the global variable that holds your component.
* `props`: Associative of the `props` that'll be passed to your component
* `options`: Associative array of options that you can pass to the `react-laravel`:
  * `prerender`: Tells react-laravel to render your component server-side too and then just _mount_ it on the client-side. Default to __true__.
  * `tag`: The tag of the element that'll hold your component. Default to __'div'__.

All your components should be inside `public/js/components.js` (you can configure it, see below) and be global.

You must include `react.js` and `react_ujs.js` (in this order) in your view.

`react-laravel` provides a ReactJS installation and the `react_us.js` file, they'll be at `public/vendor/react-laravel` folder after you install `react-laravel` and run:

```sh
  $ php artisan vendor:publish --force
```

You can choose to use any React installation greater than `v0.13.1`, but if you'll use a different version from the one provided by react-laravel, you got to configure it (see bellow).

# Configurations

You can add settings to `react-laravel` adding this to your `config/app.php` file:

```php
  `react` => [
    'source' => 'path_for_react.js',
    'components' => 'path_for_file_containing_your_components.js'
  ]
```

Both of then are optional.

* `source`: defaults to `public/vendor/react/laravel/react.js`.
* `components`: defaults to `public/js/components.js`

Your `components.js` file should also be included at your view, and all your components must be at the `window` object.