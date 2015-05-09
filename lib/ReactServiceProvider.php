<?php namespace React;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class ReactServiceProvider extends ServiceProvider {

  public function boot() {

    Blade::extend(function($view, $compiler) {
      $pattern = $compiler->createMatcher('react_component');

      return preg_replace($pattern, '<?php echo React::render$2; ?>', $view);
    });

    $this->publishes([
      __DIR__ . '/../assets' => public_path('vendor/react-laravel'),
    ]);
  }

  public function register() {

    $this->app->bind('React', function() {

      if(App::environment('production')
        && Cache::has('reactSource')
        && Cache::has('componentsSource')) {

        $reactSource = Cache::get('reactSource');
        $componentsSource = Cache::get('componentsSource');

      }
      else {
        $defaultReactPath = implode(DIRECTORY_SEPARATOR,
                                    [App::publicPath(), 'vendor', 'react-laravel', 'react.js']);

        $defaultComponentsPath = implode(DIRECTORY_SEPARATOR,
                                  [App::publicPath(), 'js', 'components.js']);

        $reactPath = Config::get('app.react.source', $defaultReactPath);
        $componentsPath = Config::get('app.react.components', $defaultComponentsPath);

        $reactSource = file_get_contents($reactPath);
        $componentsSource = file_get_contents($componentsPath);

        if(App::environment('production')) {
          Cache::forever('reactSource', $reactSource);
          Cache::forever('componentsSource', $componentsSource);
        }

      }

      return new React($reactSource, $componentsSource);
    });
  }
}
