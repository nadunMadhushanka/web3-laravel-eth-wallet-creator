# Changelog

All notable changes to `eth-wallet-creator` will be documented in this file.

## [1.1.0] - 2025-12-23

### Changed
- **Breaking:** Rebranded from SperaLabs to Nadun throughout entire package
- Updated package name to `nadun/eth-wallet-creator`
- Updated all namespaces from `SperaLabs\EthWallet` to `Nadun\EthWallet`
- Extended Laravel compatibility to include Laravel 8.x
- Extended PHP compatibility to support PHP 7.3+
- Author email updated to nadungatamanna@gmail.com

### Added
- Support for Laravel 8.x
- Support for PHP 7.3 and 7.4
- Expanded Symfony Process compatibility (5.x, 6.x, 7.x)
- Updated GitHub Actions workflow for broader version testing

## [1.0.0] - 2025-12-23

### Added
- Initial release
- Ethereum wallet generation with mnemonic support
- BIP39 12-word and 24-word mnemonic phrases
- BIP44 HD wallet derivation
- Restore wallets from mnemonic
- Derive child wallets from master mnemonic
- Mnemonic validation
- Laravel Facade integration
- Service Provider with auto-discovery
- Artisan commands:
  - `eth-wallet:generate` - Generate new wallet
  - `eth-wallet:restore` - Restore from mnemonic
  - `eth-wallet:validate` - Validate mnemonic phrase
- Configuration file with customizable settings
- Comprehensive test suite
- Full documentation and examples

### Security
- Hybrid PHP/Node.js architecture for secure crypto operations
- Uses ethers.js v6 for proven cryptographic security
- No private keys stored or logged
- Encryption recommendations in documentation
