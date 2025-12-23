# INSTALLATION GUIDE

## Quick Start

Follow these steps to set up the Ethereum Wallet Creator package:

### 1. Install Node.js Dependencies

```bash
npm install
```

This will install `ethers.js` which is required for cryptographic operations.

### 2. Test the Node.js Bridge

```bash
npm test
```

You should see "Test successful!" if everything is working.

### 3. Install in Laravel Project

If developing this as a package for use in Laravel projects:

```bash
# In your Laravel project
composer require nadun/eth-wallet-creator

# Or for local development, add to composer.json:
{
    "repositories": [
        {
            "type": "path",
            "url": "../web3-wallet-creator"
        }
    ],
    "require": {
        "nadun/eth-wallet-creator": "*"
    }
}
```

Then run:
```bash
composer update nadun/eth-wallet-creator
```

### 4. Publish Configuration (Optional)

```bash
php artisan vendor:publish --tag=eth-wallet-config
```

### 5. Test in Laravel

Create a test route in `routes/web.php`:

```php
use Nadun\EthWallet\Facades\EthWallet;

Route::get('/test-wallet', function () {
    $wallet = EthWallet::generate();
    return response()->json($wallet);
});
```

Visit: `http://localhost:8000/test-wallet`

### 6. Use Artisan Commands

```bash
# Generate a wallet
php artisan eth-wallet:generate

# Validate mnemonic
php artisan eth-wallet:validate "your mnemonic phrase here"
```

## Publish to Packagist (Optional)

To make this package publicly available:

1. Create a GitHub repository
2. Push your code
3. Create an account on [Packagist.org](https://packagist.org)
4. Submit your package URL
4. Install via: `composer require nadun/eth-wallet-creator`

## Development Setup

For package development:

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Run tests
./vendor/bin/phpunit
```

## Environment Variables

Add to your Laravel `.env` file:

```env
ETH_WALLET_NODE_PATH=node
ETH_WALLET_DERIVATION_PATH="m/44'/60'/0'/0/0"
ETH_WALLET_MNEMONIC_STRENGTH=128
ETH_WALLET_TIMEOUT=30
```

## Troubleshooting

### Windows Path Issues

If you get "node not found" on Windows, set full path:

```env
ETH_WALLET_NODE_PATH="C:\Program Files\nodejs\node.exe"
```

### Permission Denied (Linux/Mac)

```bash
chmod +x node-bridge/wallet-generator.js
```

## Ready to Use!

Your package is now ready. See [README.md](README.md) for usage examples.
