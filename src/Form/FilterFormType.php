<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Theme;
use App\Entity\Type;
use App\Entity\Range;

class FilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', TextType::class, [
                'required' => false,
                'label' => 'Rechercher',
                'attr' => ['placeholder' => 'Rechercher un jeu ... ']
            ])
            ->add('price', ChoiceType::class, [
                'required' => false,
                'label' => 'Prix',
                'placeholder' => 'Tous',
                'choices' => [
                    'moins de 15€' => 15,
                    'moins de 30€' => 30,
                    'moins de 45€' => 45,
                    'moins de 60€' => 60,
                    'plus de 60€' => '+60',
                ],
            ])
            ->add('nb_player', ChoiceType::class, [
                'required' => false,
                'label' => 'Nombre de joueurs',
                'placeholder' => 'Tous',
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9 et +' => 9,
                ],
            ])
            ->add('game_time', ChoiceType::class, [
                'required' => false,
                'label' => 'Temps d\'une partie',
                'placeholder' => 'Tous',
                'choices' => [
                    '- de 30 min' => '0-29',
                    '30 min à 1h' => '30-60',
                    '+ de 1h' => '61',
                ],
            ])
            ->add('target', ChoiceType::class, [
                'required' => false,
                'label' => 'Cible',
                'placeholder' => 'Tous',
                'choices' => [
                    'Enfant' => 'Enfant',
                    'Tout Public' => 'Tout Public',
                    'Initié' => 'Initié',
                    'Expert' => 'Expert',
                ],
            ])
            ->add('age_min', ChoiceType::class, [
                'required' => false,
                'label' => 'Age recommandé',
                'placeholder' => 'Tous',
                'choices' => [
                    'moins de 5 ans' => '0-5',
                    'à partir de 6 ans' => '6',
                    'à partir de 10 ans' => '10',
                    'à partir de 18 ans' => '18',
                ],
            ])
            ->add('gamme', EntityType::class, [
                'class' => Range::class,
                'placeholder' => 'Tous',
                'required' => false,
                'choice_label' => 'name',
                'label' => 'Gamme',
            ])
            ->add('theme', EntityType::class, [
                'class' => Theme::class,
                'placeholder' => 'Tous',
                'required' => false,
                'choice_label' => 'name',
                'label' => 'Thème',
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'placeholder' => 'Tous',
                'required' => false,
                'choice_label' => 'name',
                'label' => 'Type',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
