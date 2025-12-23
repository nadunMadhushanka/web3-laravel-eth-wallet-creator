<?php

namespace SperaLabs\EthWallet\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array generate(?int $strength = null, ?string $derivationPath = null)
 * @method static array restoreFromMnemonic(string $mnemonic, ?string $derivationPath = null)
 * @method static array deriveChildWallet(string $mnemonic, int $index = 0)
 * @method static bool validateMnemonic(string $mnemonic)
 * @method static array getAddressFromPrivateKey(string $privateKey)
 * @method static \SperaLabs\EthWallet\WalletService setNodePath(string $path)
 * @method static \SperaLabs\EthWallet\WalletService setDerivationPath(string $path)
 *
 * @see \SperaLabs\EthWallet\WalletService
 */
class EthWallet extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'eth-wallet';
    }
}
