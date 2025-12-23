<?php

namespace Nadun\EthWallet\Console;

use Illuminate\Console\Command;
use Nadun\EthWallet\Facades\EthWallet;

class RestoreWalletCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eth-wallet:restore 
                            {mnemonic : The mnemonic phrase (12 or 24 words)}
                            {--path= : Custom BIP44 derivation path}
                            {--index= : Child wallet index for HD derivation}
                            {--json : Output as JSON}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore Ethereum wallet from mnemonic phrase';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $mnemonic = $this->argument('mnemonic');
            $path = $this->option('path');
            $index = $this->option('index');

            // Validate mnemonic first
            if (!EthWallet::validateMnemonic($mnemonic)) {
                $this->error('Invalid mnemonic phrase!');
                return 1;
            }

            $this->info('Restoring Ethereum wallet...');
            
            // Derive child wallet or restore main wallet
            if ($index !== null) {
                $wallet = EthWallet::deriveChildWallet($mnemonic, (int) $index);
            } else {
                $wallet = EthWallet::restoreFromMnemonic($mnemonic, $path);
            }

            if ($this->option('json')) {
                $this->line(json_encode($wallet, JSON_PRETTY_PRINT));
                return 0;
            }

            $this->newLine();
            $this->line('╔═══════════════════════════════════════════════════════════════════════╗');
            $this->line('║                     ETHEREUM WALLET RESTORED                          ║');
            $this->line('╚═══════════════════════════════════════════════════════════════════════╝');
            $this->newLine();
            
            $this->info('Address:         ' . $wallet['address']);
            $this->warn('Private Key:     ' . $wallet['privateKey']);
            $this->newLine();
            $this->line('Derivation Path: ' . $wallet['derivationPath']);
            $this->line('Public Key:      ' . substr($wallet['publicKey'], 0, 50) . '...');
            
            if (isset($wallet['index'])) {
                $this->line('Child Index:     ' . $wallet['index']);
            }
            
            $this->newLine();
            $this->error('⚠️  WARNING: Never share your private key or mnemonic phrase!');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
