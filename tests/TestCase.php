<?php

namespace Nadun\EthWallet\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Nadun\EthWallet\EthWalletServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            EthWalletServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'EthWallet' => \Nadun\EthWallet\Facades\EthWallet::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default configuration
        $app['config']->set('eth-wallet.node_path', 'node');
        $app['config']->set('eth-wallet.derivation_path', "m/44'/60'/0'/0/0");
        $app['config']->set('eth-wallet.mnemonic_strength', 128);
    }
}
