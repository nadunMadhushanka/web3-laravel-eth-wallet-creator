# Quick Start: Publishing Your Package

## Option 1: Automated Script (Windows)

Run the automated publishing script:

```bash
publish.bat
```

This will:
1. ✅ Initialize Git
2. ✅ Validate composer.json
3. ✅ Run tests
4. ✅ Create initial commit
5. ✅ Add GitHub remote
6. ✅ Create version tag

Then follow the on-screen instructions.

## Option 2: Manual Steps

### Step 1: Initialize Git

```bash
git init
git add .
git commit -m "Initial release v1.0.0"
```

### Step 2: Create GitHub Repository

1. Go to https://github.com/new
2. Repository name: `eth-wallet-creator`
3. Visibility: **Public**
4. Do NOT add README, .gitignore, or license
5. Click "Create repository"

### Step 3: Push to GitHub

Replace `YOUR-USERNAME` with your GitHub username:

```bash
git remote add origin https://github.com/YOUR-USERNAME/eth-wallet-creator.git
git branch -M main
git push -u origin main
git tag -a v1.0.0 -m "Release version 1.0.0"
git push --tags
```

### Step 4: Publish to Packagist

1. Go to https://packagist.org
2. Click "Sign in with GitHub"
3. Authorize Packagist
4. Click "Submit" in the top menu
5. Enter: `https://github.com/YOUR-USERNAME/eth-wallet-creator`
6. Click "Check" then "Submit"

### Step 5: Enable Auto-Updates

In Packagist, go to your package and enable the GitHub Service Hook.

## Installation for Users

Once published, anyone can install your package:

```bash
composer require YOUR-USERNAME/eth-wallet-creator
```

Example:
```bash
composer require nadun/eth-wallet-creator
```

## Updating Your Package

For bug fixes or new features:

```bash
# Make changes
git add .
git commit -m "Fix: description"
git push

# Create new version tag
git tag -a v1.0.1 -m "Bug fixes"
git push --tags
```

Packagist will automatically update!

## Need More Details?

See [PUBLISHING.md](PUBLISHING.md) for comprehensive guide.

---

**Ready to share your package with the world!** 🚀
