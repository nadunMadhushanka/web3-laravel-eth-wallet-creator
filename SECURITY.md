# Security Policy

## Supported Versions

We release patches for security vulnerabilities for the following versions:

| Version | Supported          |
| ------- | ------------------ |
| 1.x.x   | :white_check_mark: |

## Reporting a Vulnerability

**Please do not report security vulnerabilities through public GitHub issues.**

If you discover a security vulnerability within this package, please send an email to:

**nadungatamanna@gmail.com**

Please include:

1. Description of the vulnerability
2. Steps to reproduce the issue
3. Possible impacts
4. Suggested fix (if any)

### What to expect:

- **Response time**: We will acknowledge your email within 48 hours
- **Updates**: We will send you regular updates about our progress
- **Disclosure**: Once the vulnerability is fixed, we will publicly disclose it
- **Credit**: We will credit you in the security advisory (unless you prefer to remain anonymous)

## Security Best Practices for Users

When using this package:

1. **Never expose private keys or mnemonics** in:
   - API responses
   - Logs
   - Error messages
   - Version control

2. **Always encrypt** sensitive data before storage:
   ```php
   use Illuminate\Support\Facades\Crypt;
   $encrypted = Crypt::encryptString($wallet['privateKey']);
   ```

3. **Use HTTPS** for all wallet-related operations

4. **Implement rate limiting** on wallet generation endpoints

5. **Validate user input** before processing mnemonic phrases

6. **Keep dependencies updated**:
   ```bash
   composer update
   npm update
   ```

## Known Security Considerations

### Private Key Storage

- This package generates wallets **on-demand**
- It does **NOT** store any private keys or mnemonics
- **You are responsible** for secure storage in your application

### Node.js Bridge

- The package uses Node.js subprocess for crypto operations
- Ensure Node.js is from a trusted source
- Keep `ethers.js` updated to the latest version

### Mnemonic Handling

- Mnemonics are transmitted through command-line arguments
- Use secure, isolated environments for production
- Consider using environment variables for sensitive operations

## Responsible Disclosure

We kindly ask security researchers to:

- Allow us reasonable time to address issues before public disclosure
- Make a good faith effort to avoid privacy violations and data destruction
- Only interact with accounts you own or with explicit permission

Thank you for helping keep our package and its users safe!
