<?php

namespace App\Form;

use App\Entity\BoardGame;
use App\Entity\Range;
use App\Form\ImageFormType;
use App\Form\BoardGameMarketFormType;
use App\Form\BoardGameThemeFormType;
use App\Form\BoardGameTypeFormType;
use App\Form\VideoFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;


class BoardGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'constraints' => [new Assert\Length(['max' => 255])],
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description',
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('nbMinPlayer', IntegerType::class, [
                'required' => true,
                'label' => 'Nombre de joueurs minimum',
                'constraints' => [new Assert\Range(['min' => 0])],
            ])
            ->add('nbMaxPlayer', IntegerType::class, [
                'required' => true,
                'label' => 'Nombre de joueurs maximum',
                'constraints' => [new Assert\Range(['min' => 1])],
            ])
            ->add('gameTime', IntegerType::class, [
                'required' => true,
                'label' => 'Temps de jeu moyen',
                'constraints' => [new Assert\Range(['min' => 5])],
            ])
            ->add('ageMin', IntegerType::class, [
                'required' => true,
                'label' => 'Age recommand??',
                'constraints' => [new Assert\Range(['min' => 0])],
            ])
            ->add('target', ChoiceType::class, [
                'required' => true,
                'label' => 'Cible',
                'choices' => [
                    'Enfant' => 'Enfant',
                    'Tout Public' => 'Tout Public',
                    'Initi??' => 'Initi??',
                    'Expert' => 'Expert',
                ],
            ])
            ->add('price', MoneyType::class, [
                'required' => true,
                'label' => 'Prix',
                'constraints' => [new Assert\Range(['min' => 0])],
            ])
            ->add('boardGameMarkets', CollectionType::class, [
                'entry_type' => BoardGameMarketFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ])
            ->add('gamme', EntityType::class, [
                'class' => Range::class,
                'placeholder' => 'Choisir une gamme',
                'required' => false,
                'choice_label' => 'name',
                'label' => 'Gamme',
            ])
            ->add('boardGameThemes', CollectionType::class, [
                'entry_type' => BoardGameThemeFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ])
            ->add('boardGameTypes', CollectionType::class, [
                'entry_type' => BoardGameTypeFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ])
            ->add('images', CollectionType::class, [
                'entry_type' => ImageFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ])
            ->add('videos', CollectionType::class, [
                'entry_type' => VideoFormType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BoardGame::class,
        ]);
    }
}
