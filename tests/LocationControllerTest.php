<?php

namespace App\Tests;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LocationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private LocationRepository $repository;
    private string $path = '/location/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Location::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Location index');


    }
    public function testNew()
    {
      
        $crawler = $this->client->request('GET', '/location/new');
        $this->assertResponseIsSuccessful();




        $form = $crawler->selectButton('Save')->form([
            'location[date_debut]' => '2024-01-01' . uniqid(),
            'location[date_retour]' => '2024-01-05',
            'location[prix]' => 50.5,
            // 'location[voiture]' => 'BM',
            // 'location[client]' => 'GHZ',
        ]);

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();  
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', '2024-01-01');
    }

    public function testShow(): void
    {
        $fixture = new Location();
        $fixture->setDateDebut('2024-01-01');
        $fixture->setDateRetour('2024-01-05');
        $fixture->setPrix(100.5);
        // $fixture->setVoiture('My Title');
        // $fixture->setClient('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Location');
        self::assertSelectorTextContains('body', $fixture->getPrix());


    }

    public function testEdit(): void
    {
        $fixture = new Location();
        $fixture->setDateDebut('2024-01-01');
        $fixture->setDateRetour('2024-01-05');
        $fixture->setPrix(100.5);
        // $fixture->setVoiture('My Title');
        // $fixture->setClient('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));
        self::assertResponseIsSuccessful();


        $this->client->submitForm('Update', [
            'location[date_debut]' => '2023-01-01',
            'location[date_retour]' => '2023-07-01',
            'location[prix]' => 300.5,
            // 'location[voiture]' => 'Something New',
            // 'location[client]' => 'Something New',
        ]);

        self::assertResponseRedirects('/location/');

        $fixture = $this->repository->findAll();

        self::assertSame('2023-01-01', $fixture[0]->getDateDebut());
        self::assertSame('2023-07-01', $fixture[0]->getDateRetour());
        self::assertSame(200.5, $fixture[0]->getPrix());
        // self::assertSame('Something New', $fixture[0]->getVoiture());
        // self::assertSame('Something New', $fixture[0]->getClient());
    }

    public function testRemove(): void
    {

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Location();
        $fixture->setDateDebut('2023-01-01');
        $fixture->setDateRetour('2023-07-01');
        $fixture->setPrix(300.5);
        // $fixture->setVoiture('My Title');
        // $fixture->setClient('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/location/');
    }
}

