<?php

namespace App\Tests;
use App\Entity\Location;
use App\Entity\Voiture;
use App\Entity\Client;
use PHPUnit\Framework\TestCase;
use App\Tests\DateTime;

class LocationUnitTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
     public function testEntityLocation(): void
    {
        $location=new Location();
        $this->assertInstanceOf(Location::class, $location);
    }

    public function testIsTrueLocation()
    {
        $location = new Location();
        $client = new Client();
        $voiture = new Voiture();
        $location->setDateDebut('2024-01-10')
                 ->setDateRetour('2024-01-20')
                 ->setPrix(85.5)
                 ->setClient($client)
                 ->setVoiture($voiture);
                 

        $this->assertTrue($location->getDateDebut() === '2024-01-10');
        $this->assertTrue($location->getDateRetour() === '2024-01-20');
        $this->assertTrue($location->getPrix() === 85.5);
        $this->assertTrue($location->getClient() === $client);
        $this->assertTrue($location->getVoiture() === $voiture);

        
    }

    public function testIsFalseLocation()
    {
        $client = new Client();
        $voiture = new Voiture();
        $location = new Location();
        $location->setDateDebut('2024-01-10')
                 ->setDateRetour('2024-01-20')
                 ->setPrix(85.5)
                 ->setClient($client)
                 ->setVoiture($voiture);

        $this->assertFalse($location->getDateDebut() === "2024-12-10");
        $this->assertFalse($location->getDateRetour() === "2024-12-20");
        $this->assertFalse($location->getPrix() === 00.5);
        $this->assertFalse($location->getClient() === "Fasle");
        $this->assertFalse($location->getVoiture() === "Fasle");


    }
}


