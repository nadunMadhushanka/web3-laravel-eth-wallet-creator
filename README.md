# Ethereum Wallet Creator for Laravel

[![Latest Version](https://img.shields.io/packagist/v/speralabs/eth-wallet-creator.svg)](https://packagist.org/packages/speralabs/eth-wallet-creator)
[![License](https://img.shields.io/packagist/l/speralabs/eth-wallet-creator.svg)](https://packagist.org/packages/speralabs/eth-wallet-creator)

A powerful Laravel package for generating Ethereum wallets with **mnemonic seed phrase support** (BIP39). This package uses a hybrid approach combining PHP and Node.js (ethers.js) for secure cryptographic operations.

## Features

- ✅ **Generate new Ethereum wallets** with mnemonic phrases
- ✅ **Restore wallets** from mnemonic (12 or 24 words)
- ✅ **HD Wallet support** (BIP32/BIP44 derivation)
- ✅ **Derive child wallets** from mnemonic
- ✅ **Mnemonic validation**
- ✅ **Laravel Facade** for easy integration
- ✅ **Artisan commands** for CLI usage
- ✅ **Secure** cryptographic operations via ethers.js

## Requirements

- PHP 8.0 or higher
- Laravel 9.x, 10.x, or 11.x
- Node.js 16+ (with npm)
- Composer

## Installation

### 1. Install via Composer

```bash
composer require speralabs/eth-wallet-creator
```

### 2. Install Node.js Dependencies

```bash
cd vendor/speralabs/eth-wallet-creator
npm install
```

### 3. Publish Configuration (Optional)

```bash
php artisan vendor:publish --tag=eth-wallet-config
```

This creates `config/eth-wallet.php` where you can customize settings.

## Configuration

Edit `config/eth-wallet.php`:

```php
return [
    // Path to Node.js executable
    'node_path' => env('ETH_WALLET_NODE_PATH', 'node'),
    
    // Default BIP44 derivation path for Ethereum
    'derivation_path' => env('ETH_WALLET_DERIVATION_PATH', "m/44'/60'/0'/0/0"),
    
    // Mnemonic strength: 128 (12 words) or 256 (24 words)
    'mnemonic_strength' => env('ETH_WALLET_MNEMONIC_STRENGTH', 128),
    
    // Timeout for Node.js process
    'timeout' => env('ETH_WALLET_TIMEOUT', 30),
];
```

## Usage

### Using the Facade

```php
use SperaLabs\EthWallet\Facades\EthWallet;

// Generate a new wallet with 12-word mnemonic
$wallet = EthWallet::generate();

/* Returns:
[
    'address' => '0x742d35Cc6634C0532925a3b844Bc9e7595f0bEb',
    'privateKey' => '0x...',
    'publicKey' => '0x...',
    'mnemonic' => 'word1 word2 word3 ... word12',
    'derivationPath' => "m/44'/60'/0'/0/0",
    'path' => "m/44'/60'/0'/0/0"
]
*/
```

### Generate Wallet with 24 Words

```php
// 256 bits = 24 words
$wallet = EthWallet::generate(256);
```

### Restore Wallet from Mnemonic

```php
$mnemonic = "your twelve word mnemonic phrase goes here for wallet recovery";

$wallet = EthWallet::restoreFromMnemonic($mnemonic);
```

### Derive Child Wallets (HD Wallet)

```php
$mnemonic = "your mnemonic phrase here";

// Derive wallet at index 0
$wallet0 = EthWallet::deriveChildWallet($mnemonic, 0);

// Derive wallet at index 1
$wallet1 = EthWallet::deriveChildWallet($mnemonic, 1);

// Each child has a unique address but shares the same mnemonic
```

### Validate Mnemonic

```php
$isValid = EthWallet::validateMnemonic("your mnemonic phrase");

if ($isValid) {
    echo "Valid mnemonic!";
}
```

### Get Address from Private Key

```php
$data = EthWallet::getAddressFromPrivateKey('0x1234567890abcdef...');

/* Returns:
[
    'address' => '0x...',
    'publicKey' => '0x...'
]
*/
```

### Custom Derivation Path

```php
// Use custom BIP44 path
$wallet = EthWallet::generate(128, "m/44'/60'/0'/0/5");

// Or set globally
EthWallet::setDerivationPath("m/44'/60'/1'/0/0");
$wallet = EthWallet::generate();
```

## Artisan Commands

### Generate New Wallet

```bash
# Generate wallet with 12 words
php artisan eth-wallet:generate

# Generate with 24 words
php artisan eth-wallet:generate --strength=256

# Custom derivation path
php artisan eth-wallet:generate --path="m/44'/60'/1'/0/0"

# JSON output
php artisan eth-wallet:generate --json
```

### Restore from Mnemonic

```bash
# Restore main wallet
php artisan eth-wallet:restore "your twelve word mnemonic phrase here"

# Restore child wallet
php artisan eth-wallet:restore "your mnemonic" --index=5

# JSON output
php artisan eth-wallet:restore "your mnemonic" --json
```

### Validate Mnemonic

```bash
php artisan eth-wallet:validate "your mnemonic phrase here"
```

## Using in Controllers

```php
namespace App\Http\Controllers;

use SperaLabs\EthWallet\Facades\EthWallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function createWallet()
    {
        try {
            $wallet = EthWallet::generate();
            
            // ⚠️ IMPORTANT: In production, encrypt and securely store:
            // - $wallet['privateKey']
            // - $wallet['mnemonic']
            
            return response()->json([
                'success' => true,
                'address' => $wallet['address'],
                // Never return private key or mnemonic to client!
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function restoreWallet(Request $request)
    {
        $request->validate([
            'mnemonic' => 'required|string'
        ]);
        
        if (!EthWallet::validateMnemonic($request->mnemonic)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid mnemonic phrase'
            ], 422);
        }
        
        $wallet = EthWallet::restoreFromMnemonic($request->mnemonic);
        
        return response()->json([
            'success' => true,
            'address' => $wallet['address']
        ]);
    }
}
```

## Dependency Injection

```php
use SperaLabs\EthWallet\WalletService;

class MyService
{
    protected $walletService;
    
    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }
    
    public function generateWallet()
    {
        return $this->walletService->generate();
    }
}
```

## Security Best Practices

### ⚠️ CRITICAL SECURITY WARNINGS

1. **Never expose private keys or mnemonics** to clients or logs
2. **Always encrypt** private keys before database storage
3. **Use Laravel's encryption**: `encrypt($wallet['privateKey'])`
4. **Never commit** wallets or keys to version control
5. **Store mnemonics securely** - they control all derived wallets
6. **Use HTTPS** for all wallet-related API endpoints
7. **Implement rate limiting** on wallet generation endpoints

### Secure Storage Example

```php
use Illuminate\Support\Facades\Crypt;

// Generate wallet
$wallet = EthWallet::generate();

// Encrypt sensitive data before storing
$encryptedPrivateKey = Crypt::encryptString($wallet['privateKey']);
$encryptedMnemonic = Crypt::encryptString($wallet['mnemonic']);

// Store in database
DB::table('wallets')->insert([
    'address' => $wallet['address'],
    'encrypted_private_key' => $encryptedPrivateKey,
    'encrypted_mnemonic' => $encryptedMnemonic,
    'created_at' => now()
]);

// Later, decrypt when needed
$privateKey = Crypt::decryptString($encryptedPrivateKey);
```

## BIP44 Derivation Paths

This package follows BIP44 standard for HD wallets:

```
m / purpose' / coin_type' / account' / change / address_index

Default Ethereum path: m/44'/60'/0'/0/0
├─ 44' = BIP44
├─ 60' = Ethereum
├─ 0'  = Account #0
├─ 0   = External chain
└─ 0   = Address #0
```

## Error Handling

```php
use SperaLabs\EthWallet\Exceptions\WalletGenerationException;
use SperaLabs\EthWallet\Exceptions\NodeBridgeException;

try {
    $wallet = EthWallet::generate();
} catch (WalletGenerationException $e) {
    // Wallet generation failed
    Log::error('Wallet generation failed: ' . $e->getMessage());
} catch (NodeBridgeException $e) {
    // Node.js bridge communication error
    Log::error('Node bridge error: ' . $e->getMessage());
}
```

## Testing

```bash
# Test Node.js bridge
npm test

# Laravel package tests
./vendor/bin/phpunit
```

## Troubleshooting

### "Node.js not found" Error

Set the correct Node.js path in `.env`:

```env
ETH_WALLET_NODE_PATH="C:\Program Files\nodejs\node.exe"
```

Or in `config/eth-wallet.php`:

```php
'node_path' => 'C:\Program Files\nodejs\node.exe'
```

### Permission Issues

Ensure the Node.js script is executable:

```bash
chmod +x vendor/speralabs/eth-wallet-creator/node-bridge/wallet-generator.js
```

## Advanced Usage

### Batch Wallet Generation

```php
public function generateMultipleWallets(int $count)
{
    $wallets = [];
    
    for ($i = 0; $i < $count; $i++) {
        $wallets[] = EthWallet::generate();
    }
    
    return $wallets;
}
```

### One Mnemonic, Multiple Addresses

```php
// Generate master mnemonic
$masterWallet = EthWallet::generate();
$mnemonic = $masterWallet['mnemonic'];

// Derive multiple addresses from same mnemonic
$addresses = [];
for ($i = 0; $i < 10; $i++) {
    $child = EthWallet::deriveChildWallet($mnemonic, $i);
    $addresses[] = $child['address'];
}

// All these addresses can be recovered with the single mnemonic!
```

## License

MIT License - see [LICENSE](LICENSE) file for details

## Support

For issues and questions:
- GitHub Issues: [https://github.com/speralabs/eth-wallet-creator/issues](https://github.com/speralabs/eth-wallet-creator)
- Email: info@speralabs.com

## Contributing

Pull requests are welcome! Please ensure:
1. Code follows PSR-12 standards
2. Tests pass
3. Security best practices are maintained

## Credits

- Built with [ethers.js](https://docs.ethers.org/)
- BIP39/BIP44 implementation
- Laravel framework integration

---

**Made with ❤️ by SperaLabs**
