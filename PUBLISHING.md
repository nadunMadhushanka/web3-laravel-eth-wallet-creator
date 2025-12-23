# Publishing Your Package Publicly

Follow these steps to make your Ethereum Wallet Creator package available worldwide via Composer.

## Prerequisites

- [x] GitHub account
- [x] Packagist account (free)
- [x] Git installed
- [x] Package tested and working

## Step 1: Create GitHub Repository

### 1.1 Create New Repository on GitHub

1. Go to [GitHub.com](https://github.com) and click **"New Repository"**
2. Repository settings:
   - **Name**: `eth-wallet-creator` or `laravel-eth-wallet-creator`
   - **Description**: "Laravel package for Ethereum wallet creation with mnemonic seed phrase support"
   - **Visibility**: Public
   - **Initialize**: Don't add README, .gitignore, or license (we already have them)
3. Click **"Create repository"**

### 1.2 Initialize Git and Push

Open terminal in your package directory and run:

```bash
# Initialize git repository
git init

# Add all files
git add .

# Create initial commit
git commit -m "Initial release v1.0.0 - Ethereum Wallet Creator for Laravel"

# Add GitHub as remote (replace YOUR-USERNAME with your GitHub username)
git remote add origin https://github.com/YOUR-USERNAME/eth-wallet-creator.git

# Push to GitHub
git branch -M main
git push -u origin main
```

### 1.3 Create a Release Tag

```bash
# Tag the release
git tag -a v1.0.0 -m "Release version 1.0.0"

# Push tags to GitHub
git push --tags
```

### 1.4 Create GitHub Release (Optional but Recommended)

1. Go to your repository on GitHub
2. Click **"Releases"** → **"Create a new release"**
3. Select tag: `v1.0.0`
4. Release title: `v1.0.0 - Initial Release`
5. Description: Copy from CHANGELOG.md
6. Click **"Publish release"**

## Step 2: Register on Packagist

### 2.1 Create Packagist Account

1. Go to [Packagist.org](https://packagist.org)
2. Click **"Sign in with GitHub"** (recommended)
3. Authorize Packagist to access your GitHub account

### 2.2 Submit Your Package

1. Click your username → **"Submit"**
2. Enter your repository URL:
   ```
   https://github.com/YOUR-USERNAME/eth-wallet-creator
   ```
3. Click **"Check"**
4. Packagist will validate your `composer.json`
5. If valid, click **"Submit"**

### 2.3 Enable Auto-Update (Important!)

After submission:

1. Go to your package page on Packagist
2. Click **"Settings"** or **"Update"**
3. Enable **GitHub Service Hook** or **Auto-Update**
4. This ensures Packagist updates when you push new releases to GitHub

**Alternative: Manual GitHub Webhook**

1. Go to your GitHub repository → **Settings** → **Webhooks**
2. Click **"Add webhook"**
3. Payload URL: `https://packagist.org/api/github?username=YOUR-PACKAGIST-USERNAME`
4. Content type: `application/json`
5. Events: Just the push event
6. Save webhook

## Step 3: Update Package Name (If Needed)

Your package name in `composer.json` is currently:
```json
"name": "speralabs/eth-wallet-creator"
```

**If you want to change it:**

1. Update `composer.json`:
   ```json
   "name": "your-username/eth-wallet-creator"
   ```

2. Commit and push changes:
   ```bash
   git add composer.json
   git commit -m "Update package name"
   git push
   ```

## Step 4: Installation Instructions for Users

Once published, users can install your package:

```bash
composer require speralabs/eth-wallet-creator
```

Or (if you changed the name):
```bash
composer require your-username/eth-wallet-creator
```

## Step 5: Making Updates

### 5.1 Update Code

Make your changes, then:

```bash
git add .
git commit -m "Fix: description of changes"
git push
```

### 5.2 Create New Version

For new versions (following [Semantic Versioning](https://semver.org/)):

```bash
# Update CHANGELOG.md first, then:

# For bug fixes (1.0.0 → 1.0.1)
git tag -a v1.0.1 -m "Bug fixes"

# For new features (1.0.0 → 1.1.0)
git tag -a v1.1.0 -m "New features"

# For breaking changes (1.0.0 → 2.0.0)
git tag -a v2.0.0 -m "Breaking changes"

# Push tag
git push --tags
```

Packagist will auto-update within a few minutes!

## Step 6: Add Badges to README

Add these badges to the top of your README.md:

```markdown
[![Latest Version](https://img.shields.io/packagist/v/speralabs/eth-wallet-creator.svg?style=flat-square)](https://packagist.org/packages/speralabs/eth-wallet-creator)
[![Total Downloads](https://img.shields.io/packagist/dt/speralabs/eth-wallet-creator.svg?style=flat-square)](https://packagist.org/packages/speralabs/eth-wallet-creator)
[![License](https://img.shields.io/packagist/l/speralabs/eth-wallet-creator.svg?style=flat-square)](https://packagist.org/packages/speralabs/eth-wallet-creator)
[![GitHub Tests](https://img.shields.io/github/actions/workflow/status/YOUR-USERNAME/eth-wallet-creator/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/YOUR-USERNAME/eth-wallet-creator/actions)
```

## Step 7: Optional Enhancements

### 7.1 Add GitHub Actions for Testing

Create `.github/workflows/tests.yml`:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    strategy:
      matrix:
        php: [8.0, 8.1, 8.2, 8.3]
        laravel: [9.*, 10.*, 11.*]

    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: ${{ matrix.php }}
          
      - name: Setup Node.js
        uses: actions/setup-node@v3
        with:
          node-version: '18'
          
      - name: Install PHP dependencies
        run: composer install
        
      - name: Install Node dependencies
        run: npm install
        
      - name: Run tests
        run: vendor/bin/phpunit
```

### 7.2 Add Security Policy

Create `SECURITY.md`:

```markdown
# Security Policy

## Reporting a Vulnerability

If you discover a security vulnerability, please email:
security@speralabs.com

Do NOT create a public GitHub issue for security vulnerabilities.
```

### 7.3 Add Contributing Guidelines

Create `CONTRIBUTING.md`:

```markdown
# Contributing

Thank you for considering contributing!

## Pull Request Process

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/amazing-feature`
3. Commit your changes: `git commit -m 'Add amazing feature'`
4. Push to the branch: `git push origin feature/amazing-feature`
5. Open a Pull Request

## Code Standards

- Follow PSR-12 coding standards
- Add tests for new features
- Update documentation
```

## Package URLs After Publishing

- **Packagist**: `https://packagist.org/packages/speralabs/eth-wallet-creator`
- **GitHub**: `https://github.com/YOUR-USERNAME/eth-wallet-creator`
- **Documentation**: Link to your README on GitHub

## Verification Checklist

Before publishing, ensure:

- [x] `composer.json` is valid (run `composer validate`)
- [x] All tests pass (`./vendor/bin/phpunit`)
- [x] Node.js bridge works (`npm test`)
- [x] README.md is comprehensive
- [x] License file exists (MIT)
- [x] .gitignore is configured
- [x] No sensitive data in code
- [x] Version number is set (v1.0.0)

## Marketing Your Package

After publishing:

1. **Laravel News**: Submit to [Laravel News](https://laravel-news.com/submit-package)
2. **Reddit**: Post in r/laravel and r/PHP
3. **Twitter**: Tweet about it with #Laravel #Web3 #Ethereum
4. **Dev.to**: Write a tutorial article
5. **Laravel Community**: Share in Laravel forums

## Example Repository Names (Choose One)

- `eth-wallet-creator`
- `laravel-eth-wallet-creator`
- `laravel-ethereum-wallet`
- `laravel-web3-wallet`
- `ethereum-wallet-generator`

## Need Help?

- Packagist docs: https://packagist.org/about
- Composer docs: https://getcomposer.org/doc/
- Semantic Versioning: https://semver.org/

---

**Ready to publish? Start with Step 1!** 🚀
