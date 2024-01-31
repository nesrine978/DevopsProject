<?php

namespace App\Tests;

use App\Entity\Client;
use PHPUnit\Framework\TestCase;

class ClientUnitCaseTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
     public function testEntityClient(): void
    {
        $client=new Client();
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testIsTrue()
    {
        $client = new Client();
        $client->setCin(12839212) 
                ->setNom ('nom')
                ->setPrenom('prenom')
                ->setAdresse('adresse');

        $this->assertTrue($client ->getCin() === 12839212); 
        $this->assertTrue($client ->getNom() === 'nom'); 
        $this->assertTrue($client->getPrenom() === 'prenom');
        $this->assertTrue($client->getAdresse() === 'adresse');
    }

    public function testIsFalse()
    {
        $client = new Client();
        $client->setCin(12839212) 
                ->setNom ('nom')
                ->setPrenom('prenom')
                ->setAdresse('adresse');

        $this->assertFalse($client ->getCin() === 00000); 
        $this->assertFalse($client ->getNom() === 'falsex'); 
        $this->assertFalse($client->getPrenom() === 'falsex');
        $this->assertFalse($client->getAdresse() === 'falseX');
    }
}
