<?php namespace React;

use Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

class ReactServiceProvider extends ServiceProvider {

  public function boot() {

    Blade::extend(function($view) {
      $pattern = $this->createMatcher('react_component');

      return preg_replace($pattern, '<?php echo React::render$2; ?>', $view);
    });

    $prev = __DIR__ . '/../';

    $this->publishes([
      $prev . 'assets'            => public_path('vendor/react-laravel'),
      $prev . 'node_modules/react/dist' => public_path('vendor/react-laravel'),
      $prev . 'node_modules/react-dom/dist' => public_path('vendor/react-laravel'),
    ], 'assets');

    $this->publishes([
      $prev . 'config/config.php' => config_path('react.php'),
    ], 'config');
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

        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'react');

        $reactBaseSource = file_get_contents(config('react.source'));
        $reactDomSource = file_get_contents(config('react.dom-source'));
        $reactDomServerSource = file_get_contents(config('react.dom-server-source'));
        $componentsSource = file_get_contents(config('react.components'));
        $reactSource = $reactBaseSource;
        $reactSource .= $reactDomSource;
        $reactSource .= $reactDomServerSource;

        if(App::environment('production')) {
          Cache::forever('reactSource', $reactSource);
          Cache::forever('componentsSource', $componentsSource);
        }
      }

      return new React($reactSource, $componentsSource);
    });
  }

  protected function createMatcher($function) {
    return '/(?<!\w)(\s*)@' . $function . '(\s*\(.*\))/s';
  }
}
