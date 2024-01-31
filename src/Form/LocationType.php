<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Location;
use App\Entity\Voiture;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateD')
            ->add('dateA')
            ->add('client', EntityType::class,
            [
                "class"=>Client::class,
                "choice_label"=>function($client) {
                    return $client->getNom() . ' ' . $client->getPrenom();}

            ])
            ->add('voiture',EntityType::class,
                [
                    "class"=>Voiture::class,
                    "choice_label"=>"serie"
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
