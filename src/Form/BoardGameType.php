<?php

namespace App\Form;

use App\Entity\BoardGame;
use App\Entity\Range;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'label' => 'Age recommandé',
                'constraints' => [new Assert\Range(['min' => 0])],
            ])
            ->add('target', ChoiceType::class, [
                'required' => true,
                'label' => 'Cible',
                'required' => true,
                'choices' => [
                    'Enfant' => 'Enfant',
                    'Tout Public' => 'Tout Public',
                    'Initié' => 'Initié',
                    'Expert' => 'Expert',
                ],
            ])
            ->add('price', MoneyType::class, [
                'required' => true,
                'label' => 'Prix',
                'constraints' => [new Assert\Range(['min' => 0])],
            ])
            ->add('gamme', EntityType::class, [
                'class' => Range::class,
                'placeholder' => 'Choisir une gamme',
                'required' => false,
                'choice_label' => 'name',
                'label' => 'Gamme',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BoardGame::class,
        ]);
    }
}
