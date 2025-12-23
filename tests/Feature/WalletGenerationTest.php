<?php

namespace Nadun\EthWallet\Tests\Feature;

use Nadun\EthWallet\Tests\TestCase;
use Nadun\EthWallet\Facades\EthWallet;

class WalletGenerationTest extends TestCase
{
    /** @test */
    public function it_can_generate_wallet_with_12_word_mnemonic()
    {
        $wallet = EthWallet::generate(128);

        $this->assertIsArray($wallet);
        $this->assertArrayHasKey('address', $wallet);
        $this->assertArrayHasKey('privateKey', $wallet);
        $this->assertArrayHasKey('mnemonic', $wallet);
        $this->assertStringStartsWith('0x', $wallet['address']);
        $this->assertEquals(12, count(explode(' ', $wallet['mnemonic'])));
    }

    /** @test */
    public function it_can_generate_wallet_with_24_word_mnemonic()
    {
        $wallet = EthWallet::generate(256);

        $this->assertIsArray($wallet);
        $this->assertEquals(24, count(explode(' ', $wallet['mnemonic'])));
    }

    /** @test */
    public function it_can_restore_wallet_from_mnemonic()
    {
        $originalWallet = EthWallet::generate();
        $mnemonic = $originalWallet['mnemonic'];

        $restoredWallet = EthWallet::restoreFromMnemonic($mnemonic);

        $this->assertEquals($originalWallet['address'], $restoredWallet['address']);
        $this->assertEquals($originalWallet['privateKey'], $restoredWallet['privateKey']);
    }

    /** @test */
    public function it_can_validate_mnemonic()
    {
        $wallet = EthWallet::generate();
        
        $this->assertTrue(EthWallet::validateMnemonic($wallet['mnemonic']));
        $this->assertFalse(EthWallet::validateMnemonic('invalid mnemonic phrase'));
    }

    /** @test */
    public function it_can_derive_child_wallets()
    {
        $wallet = EthWallet::generate();
        $mnemonic = $wallet['mnemonic'];

        $child0 = EthWallet::deriveChildWallet($mnemonic, 0);
        $child1 = EthWallet::deriveChildWallet($mnemonic, 1);

        // Different addresses for different indices
        $this->assertNotEquals($child0['address'], $child1['address']);
        
        // But deterministic - same index = same address
        $child0Again = EthWallet::deriveChildWallet($mnemonic, 0);
        $this->assertEquals($child0['address'], $child0Again['address']);
    }

    /** @test */
    public function it_can_get_address_from_private_key()
    {
        $wallet = EthWallet::generate();
        
        $result = EthWallet::getAddressFromPrivateKey($wallet['privateKey']);

        $this->assertEquals($wallet['address'], $result['address']);
    }
}
