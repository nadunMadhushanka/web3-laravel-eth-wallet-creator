<?php

namespace Nadun\EthWallet\Console;

use Illuminate\Console\Command;
use Nadun\EthWallet\Facades\EthWallet;

class ValidateMnemonicCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eth-wallet:validate 
                            {mnemonic : The mnemonic phrase to validate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate a mnemonic phrase';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $mnemonic = $this->argument('mnemonic');
            
            $isValid = EthWallet::validateMnemonic($mnemonic);

            if ($isValid) {
                $wordCount = count(explode(' ', trim($mnemonic)));
                $this->info('✓ Valid mnemonic phrase (' . $wordCount . ' words)');
                return 0;
            } else {
                $this->error('✗ Invalid mnemonic phrase');
                return 1;
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
    }
}
