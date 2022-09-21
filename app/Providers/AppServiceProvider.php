<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function() {
            return base_path('httpdocs');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadDirectives();
    }

    private function loadDirectives(){
        Blade::directive('role', function ($role){
            return "<?php if( auth()->check() && auth()->user()->hasRole( {$role} ) ): ?>";
        });

        Blade::directive('endrole', function ($role){
            return '<?php endif; ?>';
        });

        Blade::directive('permission', function ($permission){
            return "<?php if( auth()->check() && auth()->user()->hasPermission( {$permission} ) ): ?>";
        });

        Blade::directive('endpermission', function ($permission){
            return '<?php endif; ?>';
        });
    }

}
