# Contributing to Ethereum Wallet Creator

First off, thank you for considering contributing to this package! 🎉

## Code of Conduct

This project adheres to a simple code of conduct: **Be respectful and professional**.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check existing issues. When creating a bug report, include:

- **Clear title** describing the issue
- **Steps to reproduce** the behavior
- **Expected behavior** vs **actual behavior**
- **Environment details**:
  - PHP version
  - Laravel version
  - Node.js version
  - Operating system

### Suggesting Features

Feature requests are welcome! Please provide:

- **Clear description** of the feature
- **Use case** - why is this needed?
- **Proposed implementation** (if you have ideas)

### Pull Requests

1. **Fork** the repository
2. **Create a branch** from `main`:
   ```bash
   git checkout -b feature/amazing-feature
   ```

3. **Make your changes**:
   - Follow PSR-12 coding standards
   - Add tests for new features
   - Update documentation

4. **Test your changes**:
   ```bash
   # Run PHP tests
   ./vendor/bin/phpunit
   
   # Run Node.js tests
   npm test
   
   # Validate code style
   composer validate
   ```

5. **Commit your changes**:
   ```bash
   git commit -m "Add: Brief description of feature"
   ```
   
   Use conventional commits:
   - `Add:` for new features
   - `Fix:` for bug fixes
   - `Update:` for updates to existing features
   - `Docs:` for documentation changes
   - `Test:` for test additions/changes

6. **Push to your fork**:
   ```bash
   git push origin feature/amazing-feature
   ```

7. **Open a Pull Request** against the `main` branch

## Development Setup

### Prerequisites

- PHP 8.0+
- Composer
- Node.js 16+
- npm

### Setup Steps

```bash
# Clone your fork
git clone https://github.com/YOUR-USERNAME/eth-wallet-creator.git
cd eth-wallet-creator

# Install dependencies
composer install
npm install

# Run tests
./vendor/bin/phpunit
npm test
```

## Coding Standards

### PHP

- Follow **PSR-12** coding standard
- Use **type hints** for parameters and return types
- Add **PHPDoc blocks** for classes and methods
- Keep methods **focused and small**

Example:
```php
/**
 * Generate a new Ethereum wallet
 *
 * @param int|null $strength Mnemonic strength (128 or 256)
 * @return array Wallet data including address, privateKey, and mnemonic
 * @throws WalletGenerationException
 */
public function generate(?int $strength = null): array
{
    // Implementation
}
```

### JavaScript

- Use **ES6+** features
- Follow **Node.js best practices**
- Add **JSDoc comments** for functions
- Handle **errors gracefully**

Example:
```javascript
/**
 * Generate a new wallet with mnemonic
 * @param {number} strength - Mnemonic strength (128 or 256)
 * @returns {object} Wallet data
 */
static generateWallet(strength = 128) {
    // Implementation
}
```

## Testing Guidelines

### PHP Tests

- Write tests for all new features
- Use descriptive test method names: `it_can_generate_wallet_with_mnemonic`
- Test both success and failure cases
- Use Laravel's testing helpers

Example:
```php
/** @test */
public function it_can_validate_mnemonic()
{
    $wallet = EthWallet::generate();
    
    $this->assertTrue(EthWallet::validateMnemonic($wallet['mnemonic']));
    $this->assertFalse(EthWallet::validateMnemonic('invalid phrase'));
}
```

### Node.js Tests

- Test all wallet generation functions
- Verify cryptographic correctness
- Test error handling

## Documentation

Update documentation for:

- New features (README.md)
- Breaking changes (CHANGELOG.md)
- Configuration options (config file comments)
- API changes (PHPDoc blocks)

## Release Process (Maintainers Only)

1. Update `CHANGELOG.md`
2. Update version in `composer.json` (if needed)
3. Commit changes
4. Tag release: `git tag -a v1.x.x -m "Release version 1.x.x"`
5. Push: `git push --tags`
6. Create GitHub release
7. Packagist auto-updates

## Questions?

Feel free to:

- Open an issue for discussion
- Contact maintainers
- Check existing documentation

## Recognition

Contributors will be:

- Listed in release notes
- Mentioned in GitHub contributors
- Credited in security advisories (if applicable)

---

**Thank you for contributing!** 🙏

Your efforts help make Ethereum development more accessible to the Laravel community.
