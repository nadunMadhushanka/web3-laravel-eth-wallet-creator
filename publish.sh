#!/usr/bin/env bash

# Quick Publishing Script for Ethereum Wallet Creator
# This script helps you publish your package to GitHub and Packagist

set -e

echo "========================================="
echo "  Ethereum Wallet Creator Publisher"
echo "========================================="
echo ""

# Check if git is initialized
if [ ! -d .git ]; then
    echo "📦 Initializing Git repository..."
    git init
    echo "✅ Git initialized"
else
    echo "✅ Git already initialized"
fi

# Validate composer.json
echo ""
echo "🔍 Validating composer.json..."
composer validate
echo "✅ composer.json is valid"

# Run tests
echo ""
echo "🧪 Running Node.js tests..."
npm test
echo "✅ Node.js tests passed"

# Check if PHP tests exist
if [ -f vendor/bin/phpunit ]; then
    echo ""
    echo "🧪 Running PHP tests..."
    ./vendor/bin/phpunit
    echo "✅ PHP tests passed"
fi

# Get GitHub username
echo ""
read -p "📝 Enter your GitHub username: " github_username

# Get repository name
echo ""
read -p "📝 Enter repository name (default: eth-wallet-creator): " repo_name
repo_name=${repo_name:-eth-wallet-creator}

# Confirm
echo ""
echo "Repository will be created at:"
echo "https://github.com/$github_username/$repo_name"
echo ""
read -p "Continue? (y/n): " confirm

if [ "$confirm" != "y" ]; then
    echo "❌ Publishing cancelled"
    exit 1
fi

# Add all files
echo ""
echo "📦 Adding files to git..."
git add .

# Commit
echo "💾 Creating initial commit..."
git commit -m "Initial release v1.0.0 - Ethereum Wallet Creator for Laravel"

# Add remote
echo "🔗 Adding GitHub remote..."
git remote add origin "https://github.com/$github_username/$repo_name.git" || true
git branch -M main

# Tag version
echo "🏷️  Creating version tag v1.0.0..."
git tag -a v1.0.0 -m "Release version 1.0.0"

echo ""
echo "========================================="
echo "  ✅ Local setup complete!"
echo "========================================="
echo ""
echo "Next steps:"
echo ""
echo "1. Create GitHub repository:"
echo "   → Go to https://github.com/new"
echo "   → Name: $repo_name"
echo "   → Visibility: Public"
echo "   → Do NOT initialize with README"
echo ""
echo "2. Push your code:"
echo "   git push -u origin main"
echo "   git push --tags"
echo ""
echo "3. Register on Packagist:"
echo "   → Go to https://packagist.org"
echo "   → Sign in with GitHub"
echo "   → Submit: https://github.com/$github_username/$repo_name"
echo ""
echo "4. Users can install via:"
echo "   composer require $github_username/$repo_name"
echo ""
echo "See PUBLISHING.md for detailed instructions."
echo ""
