<?php

namespace Nadun\EthWallet;

use Nadun\EthWallet\Exceptions\WalletGenerationException;
use Nadun\EthWallet\Exceptions\NodeBridgeException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class WalletService
{
    /**
     * @var string
     */
    protected $nodePath;

    /**
     * @var string
     */
    protected $scriptPath;

    /**
     * @var int
     */
    protected $timeout;

    /**
     * @var string
     */
    protected $derivationPath;

    /**
     * @var int
     */
    protected $mnemonicStrength;

    public function __construct()
    {
        $this->nodePath = config('eth-wallet.node_path', 'node');
        $this->scriptPath = __DIR__ . '/../node-bridge/wallet-generator.js';
        $this->timeout = config('eth-wallet.timeout', 30);
        $this->derivationPath = config('eth-wallet.derivation_path', "m/44'/60'/0'/0/0");
        $this->mnemonicStrength = config('eth-wallet.mnemonic_strength', 128);
    }

    /**
     * Generate a new Ethereum wallet with mnemonic
     *
     * @param int|null $strength Mnemonic strength (128 = 12 words, 256 = 24 words)
     * @param string|null $derivationPath BIP44 derivation path
     * @return array
     * @throws WalletGenerationException
     */
    public function generate(?int $strength = null, ?string $derivationPath = null): array
    {
        $strength = $strength ?? $this->mnemonicStrength;
        $derivationPath = $derivationPath ?? $this->derivationPath;

        $result = $this->executeNodeScript(['generate', $strength, $derivationPath]);

        if (!$result['success']) {
            throw new WalletGenerationException('Failed to generate wallet: ' . $result['error']);
        }

        return $result['data'];
    }

    /**
     * Restore wallet from mnemonic phrase
     *
     * @param string $mnemonic 12 or 24 word mnemonic phrase
     * @param string|null $derivationPath BIP44 derivation path
     * @return array
     * @throws WalletGenerationException
     */
    public function restoreFromMnemonic(string $mnemonic, ?string $derivationPath = null): array
    {
        $derivationPath = $derivationPath ?? $this->derivationPath;
        
        $mnemonicWords = explode(' ', trim($mnemonic));
        $args = array_merge(['restore'], $mnemonicWords, [$derivationPath]);

        $result = $this->executeNodeScript($args);

        if (!$result['success']) {
            throw new WalletGenerationException('Failed to restore wallet: ' . $result['error']);
        }

        return $result['data'];
    }

    /**
     * Derive child wallet from mnemonic
     *
     * @param string $mnemonic Mnemonic phrase
     * @param int $index Child wallet index
     * @return array
     * @throws WalletGenerationException
     */
    public function deriveChildWallet(string $mnemonic, int $index = 0): array
    {
        $mnemonicWords = explode(' ', trim($mnemonic));
        $args = array_merge(['derive'], $mnemonicWords, [(string)$index]);

        $result = $this->executeNodeScript($args);

        if (!$result['success']) {
            throw new WalletGenerationException('Failed to derive child wallet: ' . $result['error']);
        }

        return $result['data'];
    }

    /**
     * Validate mnemonic phrase
     *
     * @param string $mnemonic Mnemonic to validate
     * @return bool
     */
    public function validateMnemonic(string $mnemonic): bool
    {
        try {
            $mnemonicWords = explode(' ', trim($mnemonic));
            $args = array_merge(['validate'], $mnemonicWords);
            
            $result = $this->executeNodeScript($args);

            return $result['success'] && $result['data']['valid'];
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get address from private key
     *
     * @param string $privateKey Private key (with or without 0x prefix)
     * @return array
     * @throws WalletGenerationException
     */
    public function getAddressFromPrivateKey(string $privateKey): array
    {
        $result = $this->executeNodeScript(['address', $privateKey]);

        if (!$result['success']) {
            throw new WalletGenerationException('Failed to get address: ' . $result['error']);
        }

        return $result['data'];
    }

    /**
     * Execute Node.js script and return result
     *
     * @param array $args Command arguments
     * @return array
     * @throws NodeBridgeException
     */
    protected function executeNodeScript(array $args): array
    {
        if (!file_exists($this->scriptPath)) {
            throw new NodeBridgeException('Wallet generator script not found at: ' . $this->scriptPath);
        }

        $command = array_merge([$this->nodePath, $this->scriptPath], $args);
        
        $process = new Process($command);
        $process->setTimeout($this->timeout);

        try {
            $process->mustRun();
            $output = $process->getOutput();
            
            $result = json_decode($output, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new NodeBridgeException('Failed to decode JSON response: ' . json_last_error_msg());
            }

            return $result;
        } catch (ProcessFailedException $e) {
            throw new NodeBridgeException('Node.js process failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            throw new NodeBridgeException('Unexpected error: ' . $e->getMessage());
        }
    }

    /**
     * Set custom node path
     *
     * @param string $path
     * @return $this
     */
    public function setNodePath(string $path): self
    {
        $this->nodePath = $path;
        return $this;
    }

    /**
     * Set custom derivation path
     *
     * @param string $path
     * @return $this
     */
    public function setDerivationPath(string $path): self
    {
        $this->derivationPath = $path;
        return $this;
    }
}
