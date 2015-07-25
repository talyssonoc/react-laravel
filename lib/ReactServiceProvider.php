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

    $this->publishes([
      __DIR__ . '/../assets'            => public_path('vendor/react-laravel'),
    ], 'assets');

    $this->publishes([
      __DIR__ . '/../config/config.php' => config_path('react.php'),
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

        $reactSource = file_get_contents(config('react.source'));
        $componentsSource = file_get_contents(config('react.components'));

        if(App::environment('production')) {
          Cache::forever('reactSource', $reactSource);
          Cache::forever('componentsSource', $componentsSource);
        }
      }

      return new React($reactSource, $componentsSource);
    });
  }

  protected function createMatcher($function) {
    return '/(?<!\w)(\s*)@' . $function . '(\s*\(.*\))/';
  }
}
