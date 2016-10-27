<?php namespace React;

use Blade;
use Illuminate\Support\ServiceProvider;

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
      $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'react');

      $reactBaseSource = file_get_contents(config('react.source'));
      $reactDomSource = file_get_contents(config('react.dom-source'));
      $reactDomServerSource = file_get_contents(config('react.dom-server-source'));

      $componentsSource = null;
      $components = config('react.components');
      if (!is_array($components)) {
        $components = [$components];
      }
      foreach ($components as $component) {
        $componentsSource .= file_get_contents($component);
      }

      $reactSource = $reactBaseSource;
      $reactSource .= $reactDomSource;
      $reactSource .= $reactDomServerSource;
      return new React($reactSource, $componentsSource);
    });
  }

  protected function createMatcher($function) {
    return '/(?<!\w)(\s*)@' . $function . '(\s*\([\s\S]*?\))/';
  }
}
