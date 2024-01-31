<?php

namespace App\Tests;


use App\Entity\Voiture;
use PHPUnit\Framework\TestCase;
use App\Tests\DateTime;

class VoitureUnitTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
     public function testEntityVoiture(): void
    {
        $voiture=new Voiture();
        $this->assertInstanceOf(Voiture::class, $voiture);
    }

    public function testIsTrueVoiture()
    {
        $voiture = new Voiture();
        $voiture->setSerie("132TU4365") 
                ->setDateMiseEnMarche ('2024-01-10')
                ->setModele('MB')
                ->setPrixJour(20.5);

        $this->assertTrue($voiture ->getSerie() === "132TU4365"); 
        $this->assertTrue($voiture ->getDateMiseEnMarche() === '2024-01-10'); 
        $this->assertTrue($voiture->getModele() === 'Mercedes');
        $this->assertTrue($voiture->getPrixJour() === 20.5);
    }

    public function testIsFalseVoiture()
    {
        $datetime = new \DateTime();
        $voiture = new Voiture();
        $voiture->setSerie("132TU4365") 
                ->setDateMiseEnMarche ('2024-01-10')
                ->setModele('Mercedes')
                ->setPrixJour(20.5);

        $this->assertFalse($voiture ->getSerie() === "132TU9965"); 
        $this->assertFalse($voiture ->getDateMiseEnMarche() === '2024-12-12'); 
        $this->assertFalse($voiture->getModele() === 'BMW');
        $this->assertFalse($voiture->getPrixJour() === 70.5);
    }
}

