<?php

namespace App\Form;

use App\Entity\BoardGameMarket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Market;
use Symfony\Component\Validator\Constraints as Assert;

class BoardGameMarketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('market', EntityType::class, [
                'class' => Market::class,
                'placeholder' => 'Choisir un site',
                'required' => true,
                'choice_label' => 'name',
                'label' => 'Site',
            ])
            ->add('link', UrlType::class, [
                'required' => true,
                'label' => 'Lien',
                'constraints' => [new Assert\Length(['max' => 255])],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BoardGameMarket::class,
        ]);
    }
}
