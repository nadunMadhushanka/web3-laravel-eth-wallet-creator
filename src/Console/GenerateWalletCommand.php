<?php

namespace SperaLabs\EthWallet\Console;

use Illuminate\Console\Command;
use SperaLabs\EthWallet\Facades\EthWallet;

class GenerateWalletCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eth-wallet:generate 
                            {--strength=128 : Mnemonic strength (128=12 words, 256=24 words)}
                            {--path= : Custom BIP44 derivation path}
                            {--json : Output as JSON}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Ethereum wallet with mnemonic phrase';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $strength = (int) $this->option('strength');
            $path = $this->option('path');

            $this->info('Generating new Ethereum wallet...');
            
            $wallet = EthWallet::generate($strength, $path);

            if ($this->option('json')) {
                $this->line(json_encode($wallet, JSON_PRETTY_PRINT));
                return 0;
            }

            $this->newLine();
            $this->line('╔═══════════════════════════════════════════════════════════════════════╗');
            $this->line('║                     ETHEREUM WALLET GENERATED                         ║');
            $this->line('╚═══════════════════════════════════════════════════════════════════════╝');
            $this->newLine();
            
            $this->info('Address:         ' . $wallet['address']);
            $this->warn('Private Key:     ' . $wallet['privateKey']);
            $this->newLine();
            $this->comment('Mnemonic Phrase (SAVE THIS SECURELY):');
            $this->warn($wallet['mnemonic']);
            $this->newLine();
            $this->line('Derivation Path: ' . $wallet['derivationPath']);
            $this->line('Public Key:      ' . substr($wallet['publicKey'], 0, 50) . '...');
            
            $this->newLine();
            $this->error('⚠️  WARNING: Never share your private key or mnemonic phrase!');
            $this->error('⚠️  Store them securely - anyone with access can control your funds!');
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
