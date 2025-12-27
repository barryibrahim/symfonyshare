<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
            'fw-bold']])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Modérateur' => 'ROLE_MOD',
                    'User' => 'ROLE_USER',
                ],
                'multiple' => true,
                'expanded' => true,
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'fw-bold'],
            ])
            ->add('password')
            ->add('dateInscription', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'fw-bold'],
            ])
            ->add('nom', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
            'fw-bold']])
            ->add('prenom', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
            'fw-bold']])
            ->add('adresse', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
            'fw-bold']])
            ->add('ville', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
            'fw-bold']])
            ->add('codepostal', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
            'fw-bold']])
            ->add('telephone', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
            'fw-bold']])
            ->add('description', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
            'fw-bold']])
            ->add('pseudo', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
            'fw-bold']])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Activer' => 'Activer',
                    'Desactiver' => 'Desactiver',
                ],
                'multiple' => false,
                'expanded' => false,
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'fw-bold'],
            ])
            ->add('modifier', SubmitType::class, [
                'attr' => ['class' => 'btn bg-primary text-white m-4'],
                'row_attr' => ['class' => 'text-center'],
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
