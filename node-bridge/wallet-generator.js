#!/usr/bin/env node

/**
 * Ethereum Wallet Generator Bridge
 * Uses ethers.js for secure wallet creation with mnemonic support
 */

const { ethers } = require('ethers');

class WalletGenerator {
    /**
     * Generate a new wallet with mnemonic
     * @param {number} strength - Mnemonic strength (128 or 256)
     * @param {string} derivationPath - BIP44 derivation path
     * @returns {object} Wallet data
     */
    static generateWallet(strength = 128, derivationPath = "m/44'/60'/0'/0/0") {
        try {
            // Generate mnemonic
            const mnemonic = ethers.Wallet.createRandom().mnemonic;
            
            // Create wallet from mnemonic with derivation path
            const hdNode = ethers.HDNodeWallet.fromPhrase(mnemonic.phrase, null, derivationPath);
            
            return {
                success: true,
                data: {
                    address: hdNode.address,
                    privateKey: hdNode.privateKey,
                    publicKey: hdNode.publicKey,
                    mnemonic: mnemonic.phrase,
                    derivationPath: derivationPath,
                    path: hdNode.path
                }
            };
        } catch (error) {
            return {
                success: false,
                error: error.message
            };
        }
    }

    /**
     * Restore wallet from mnemonic
     * @param {string} mnemonic - 12 or 24 word mnemonic phrase
     * @param {string} derivationPath - BIP44 derivation path
     * @returns {object} Wallet data
     */
    static restoreFromMnemonic(mnemonic, derivationPath = "m/44'/60'/0'/0/0") {
        try {
            // Validate and create wallet from mnemonic
            const hdNode = ethers.HDNodeWallet.fromPhrase(mnemonic.trim(), null, derivationPath);
            
            return {
                success: true,
                data: {
                    address: hdNode.address,
                    privateKey: hdNode.privateKey,
                    publicKey: hdNode.publicKey,
                    mnemonic: mnemonic.trim(),
                    derivationPath: derivationPath,
                    path: hdNode.path
                }
            };
        } catch (error) {
            return {
                success: false,
                error: error.message
            };
        }
    }

    /**
     * Derive child wallet from mnemonic
     * @param {string} mnemonic - Mnemonic phrase
     * @param {number} index - Child index
     * @returns {object} Wallet data
     */
    static deriveChildWallet(mnemonic, index = 0) {
        try {
            const derivationPath = `m/44'/60'/0'/0/${index}`;
            const hdNode = ethers.HDNodeWallet.fromPhrase(mnemonic.trim(), null, derivationPath);
            
            return {
                success: true,
                data: {
                    address: hdNode.address,
                    privateKey: hdNode.privateKey,
                    publicKey: hdNode.publicKey,
                    derivationPath: derivationPath,
                    path: hdNode.path,
                    index: index
                }
            };
        } catch (error) {
            return {
                success: false,
                error: error.message
            };
        }
    }

    /**
     * Validate mnemonic phrase
     * @param {string} mnemonic - Mnemonic to validate
     * @returns {object} Validation result
     */
    static validateMnemonic(mnemonic) {
        try {
            const isValid = ethers.Mnemonic.isValidMnemonic(mnemonic.trim());
            return {
                success: true,
                data: {
                    valid: isValid,
                    wordCount: mnemonic.trim().split(' ').length
                }
            };
        } catch (error) {
            return {
                success: false,
                error: error.message
            };
        }
    }

    /**
     * Get address from private key
     * @param {string} privateKey - Private key
     * @returns {object} Address data
     */
    static getAddressFromPrivateKey(privateKey) {
        try {
            const wallet = new ethers.Wallet(privateKey);
            return {
                success: true,
                data: {
                    address: wallet.address,
                    publicKey: wallet.publicKey
                }
            };
        } catch (error) {
            return {
                success: false,
                error: error.message
            };
        }
    }
}

// CLI Handler
if (require.main === module) {
    const args = process.argv.slice(2);
    const command = args[0];

    let result;

    switch (command) {
        case 'generate':
            const strength = parseInt(args[1]) || 128;
            const derivationPath = args[2] || "m/44'/60'/0'/0/0";
            result = WalletGenerator.generateWallet(strength, derivationPath);
            break;

        case 'restore':
            const mnemonic = args.slice(1, -1).join(' ') || args.slice(1).join(' ');
            const restorePath = args[args.length - 1].startsWith('m/') ? args[args.length - 1] : "m/44'/60'/0'/0/0";
            result = WalletGenerator.restoreFromMnemonic(mnemonic, restorePath);
            break;

        case 'derive':
            const deriveMnemonic = args.slice(1, -1).join(' ');
            const index = parseInt(args[args.length - 1]) || 0;
            result = WalletGenerator.deriveChildWallet(deriveMnemonic, index);
            break;

        case 'validate':
            const validateMnemonic = args.slice(1).join(' ');
            result = WalletGenerator.validateMnemonic(validateMnemonic);
            break;

        case 'address':
            const privateKey = args[1];
            result = WalletGenerator.getAddressFromPrivateKey(privateKey);
            break;

        case 'test':
            // Test mode
            result = WalletGenerator.generateWallet();
            console.log('Test successful!');
            break;

        default:
            result = {
                success: false,
                error: 'Invalid command. Available: generate, restore, derive, validate, address'
            };
    }

    console.log(JSON.stringify(result));
}

module.exports = WalletGenerator;
