<?php

namespace App\Tests;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VoitureControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private VoitureRepository $repository;
    private string $path = '/voiture/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Voiture::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Voiture index');

    }
    public function testNew(): void
    {
      
        $crawler = $this->client->request('GET', '/voiture/new');
        $this->assertResponseIsSuccessful();
        $form = $crawler->selectButton('Save')->form([
            'voiture[serie]' => '132TU4765'.uniqid(),
            'voiture[date_mise_en_marche]' => '2010-05-20',
            'voiture[modele]' => 'Mercedes',
            'voiture[prix_jour]' => 150.5,
        ]);
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();  
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Mercedes');
    
    }

    public function testShow(): void
    {
        $fixture = new Voiture();
        $fixture->setSerie('132TU4765');
        $fixture->setDateMiseEnMarche('2010-05-20');
        $fixture->setModele('Mercedes');
        $fixture->setPrixJour(150.5);

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Voiture');
        self::assertSelectorTextContains('body', $fixture->getModele());

    }

    public function testEdit(): void
    {
        $fixture = new Voiture();
        $fixture->setSerie('132TU4765');
        $fixture->setDateMiseEnMarche('2010-05-20');
        $fixture->setModele('Mercedes');
        $fixture->setPrixJour(150.5);

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'voiture[serie]' => '110TU000',
            'voiture[date_mise_en_marche]' => '2012-01-01',
            'voiture[modele]' => 'BMW',
            'voiture[prix_jour]' => 260.6,
        ]);

        self::assertResponseRedirects('/voiture/');

        $fixture = $this->repository->findAll();

        self::assertSame('110TU000', $fixture[0]->getSerie());
        self::assertSame('2012-01-01', $fixture[0]->getDateMiseEnMarche());
        self::assertSame('BMW', $fixture[0]->getModele());
        self::assertSame(260.6, $fixture[0]->getPrixJour());
    }

    public function testRemove(): void
    {

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Voiture();
        $fixture->setSerie('132TU4765');
        $fixture->setDateMiseEnMarche('2010-05-20');
        $fixture->setModele('Mercedes');
        $fixture->setPrixJour(150.5);

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/voiture/');
    }
}
