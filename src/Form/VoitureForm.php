<?php

namespace App\Form;

use App\Entity\Modele;
use phpDocumentor\Reflection\Types\Float_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class VoitureForm extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder->add('serie', TextType::class)
        ->add('dateMM', DateType::class)
        ->add('prixJour', NumberType::class)
->add('modele', EntityType::class,
[
    'class'=>Modele::class,
    'choice_lable'=>'libelle'
])
    ;
}
}