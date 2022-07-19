<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Country;
use App\Entity\Skill;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('code_name', TextType::class, [
                'label' => 'Nom de code'
            ])
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'multiple' => true,
                'expanded' => true,
                'label' => 'Spécialités',
                'help' => "L'agent doit avoir au moins une spécialité en rapport à la mission"
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance'
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'label' => 'Pays',
                'help' => " L'agent ne peux pas être du même pays que la cible"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }
}
