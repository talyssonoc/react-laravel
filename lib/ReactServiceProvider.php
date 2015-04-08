<?php namespace React;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;

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

    $reactSource = file_get_contents(Config::get('app.react.source'));
    $componentsSource = file_get_contents(Config::get('app.react.components'));

    $this->app->bind('React', function() {
      return new React($reactSource, $componentsSource);
    });
	}
}
