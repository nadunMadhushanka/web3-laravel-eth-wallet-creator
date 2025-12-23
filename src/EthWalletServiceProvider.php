<?php

namespace SperaLabs\EthWallet;

use Illuminate\Support\ServiceProvider;

class EthWalletServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/eth-wallet.php',
            'eth-wallet'
        );

        $this->app->singleton('eth-wallet', function ($app) {
            return new WalletService();
        });

        $this->app->alias('eth-wallet', WalletService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config file
        $this->publishes([
            __DIR__ . '/../config/eth-wallet.php' => config_path('eth-wallet.php'),
        ], 'eth-wallet-config');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\GenerateWalletCommand::class,
                Console\RestoreWalletCommand::class,
                Console\ValidateMnemonicCommand::class,
            ]);
        }
    }
}
