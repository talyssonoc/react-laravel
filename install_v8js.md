The minimum version of `php v8js` required to use `react-laravel` is `0.1.3`, and this version can be easily installed on Linux, Mac and Windows. But it is highly recommended that you install the version `0.2.0` because of performance and security reasons, but it is not that easy/fast to install like `0.1.3`, specially for Windows users, because you got to compile it.

Below you'll see how to install both of the versions.

# Version `0.2.0`

The [v8js](https://github.com/preillyme/v8js) repository has very good tutorials on how to install the last version, you can see them clicking the links:

- [For Linux users](https://github.com/preillyme/v8js/blob/master/README.Linux.md)
- [For Mac users](https://github.com/preillyme/v8js/blob/master/README.MacOS.md)
- [For Windows users](https://github.com/preillyme/v8js/blob/master/README.Win32.md)

# Version `0.1.3`

Again, it is recommended that you use `0.2.0` version, use `0.1.3` version only for testing purpose and never in production.

##### Install v8js on Linux (works with [Homestead](http://laravel.com/docs/5.0/homestead))

First run:

```sh
  $ sudo apt-get install libv8-dev g++
  $ sudo pecl install v8js-0.1.3
```

Then add `extension=v8js.so` to your `php.ini` file.

##### Install v8js on a Mac

Follow [this tutorial](http://www.phpied.com/installing-v8js-for-php-on-a-mac/).

##### Install v8js on Windows

You must have PHP 5.3/5.4/5.5 installed.

Then access [this link](http://windows.php.net/downloads/pecl/snaps/v8js/0.1.3/) and download the zip for your PHP version (don't forget to check if your PHP installation is `ts` or `nts` and if your OS is x86 or x64).

Unzip the file and paste the `v8.dll` file in your PHP installation folder, and `php_v8.dll` in your `php/ext` folder.

Then add `extension=php_v8js.dll` to your `php.ini` file.
