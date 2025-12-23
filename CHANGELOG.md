# Changelog

All notable changes to `eth-wallet-creator` will be documented in this file.

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
