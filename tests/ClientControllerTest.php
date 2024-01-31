<?php

namespace App\Tests;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ClientRepository $repository;
    private string $path = '/client/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Client::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Client index');
    }

    public function testNew()
    {
        $crawler = $this->client->request('GET', '/client/new');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Save')->form([
            'client[nom]' => 'Bradai' . uniqid(),
            'client[prenom]' => 'Nesrine',
            'client[cin]' => 12869212,
            'client[adresse]' => 'sousse',
        ]);

        $this->client->submit($form);
        $crawler = $this->client->followRedirect();  
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Bradai');
    }


    public function testShow(): void
    {
        // $this->markTestIncomplete();
        $fixture = new Client();
        $fixture->setNom('Bradai');
        $fixture->setPrenom('Nesrine');
        $fixture->setCin(12869212);
        $fixture->setAdresse('sousse');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Client');
    }

    public function testEdit(): void
    {
        // $this->markTestIncomplete();
        $fixture = new Client();
        $fixture->setNom('Syrine');
        $fixture->setPrenom('Ghz');
        $fixture->setCin(00000000);
        $fixture->setAdresse('TestAdd');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'client[nom]' => 'Bradai',
            'client[prenom]' => 'Nesrine',
            'client[cin]' => 12869212,
            'client[adresse]' => 'sousse',
        ]);

        self::assertResponseRedirects('/client/');

        $fixture = $this->repository->findAll();

        self::assertSame('Bradai', $fixture[0]->getNom());
        self::assertSame('Nesrine', $fixture[0]->getPrenom());
        self::assertSame(12869212, $fixture[0]->getCin());
        self::assertSame('sousse', $fixture[0]->getAdresse());
    }

    public function testRemove(): void
    {
        // $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Client();
        $fixture->setNom('Bradai');
        $fixture->setPrenom('Nesrine');
        $fixture->setCin(12869212);
        $fixture->setAdresse('sousse');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/client/');
    }
}
