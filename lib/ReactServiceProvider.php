<?php namespace React;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ReactServiceProvider extends ServiceProvider {

	public function boot() {
		Blade::extend(function($view, $compiler) {
		    $pattern = $compiler->createMatcher('react_component');

		    return preg_replace($pattern, '<?php echo React::render$2; ?>', $view);
		});

    $this->publishes([
        __DIR__ . '/assets' => public_path('vendor/react-laravel'),
    ]);

    $this->app->booting(function() {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('React', 'React\React');
    });
	}

	public function register() {
		
	}
}
