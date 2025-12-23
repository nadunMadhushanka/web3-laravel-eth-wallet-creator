<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Node.js Bridge Path
    |--------------------------------------------------------------------------
    |
    | Path to the Node.js executable. Set to null to use system default.
    | You can specify custom path like: 'C:\Program Files\nodejs\node.exe'
    |
    */
    'node_path' => env('ETH_WALLET_NODE_PATH', 'node'),

    /*
    |--------------------------------------------------------------------------
    | Default Derivation Path
    |--------------------------------------------------------------------------
    |
    | BIP44 derivation path for Ethereum wallets.
    | Default: m/44'/60'/0'/0/0 (Ethereum standard)
    |
    */
    'derivation_path' => env('ETH_WALLET_DERIVATION_PATH', "m/44'/60'/0'/0/0"),

    /*
    |--------------------------------------------------------------------------
    | Mnemonic Strength
    |--------------------------------------------------------------------------
    |
    | Strength of the mnemonic phrase in bits.
    | 128 bits = 12 words
    | 256 bits = 24 words
    |
    */
    'mnemonic_strength' => env('ETH_WALLET_MNEMONIC_STRENGTH', 128),

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    |
    | Maximum time in seconds to wait for Node.js process to complete.
    |
    */
    'timeout' => env('ETH_WALLET_TIMEOUT', 30),
];
