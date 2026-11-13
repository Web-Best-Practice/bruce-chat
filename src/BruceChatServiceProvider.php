<?php

namespace WebBestPractice\BruceChat;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use WebBestPractice\BruceChat\Http\Middleware\VerifyBruceSecret;

class BruceChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bruce-chat.php', 'bruce-chat');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/bruce-chat.php' => config_path('bruce-chat.php'),
        ], 'bruce-chat-config');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'bruce-chat');

        Blade::directive('bruceChat', function () {
            return '<?php echo \\WebBestPractice\\BruceChat\\BruceChat::script(); ?>';
        });

        Blade::component('bruce-chat::components.chat', 'bruce-chat');

        if (! config('bruce-chat.enabled')) {
            return;
        }

        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        Route::middleware(array_merge(
            config('bruce-chat.middleware', ['api']),
            [VerifyBruceSecret::class],
        ))
            ->prefix(config('bruce-chat.route_prefix', 'api/bruce'))
            ->name('bruce-chat.')
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
            });
    }
}
