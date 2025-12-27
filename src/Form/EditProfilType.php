<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class EditProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' =>
            'fw-bold']])



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

            ->add('photo', FileType::class, [
                'label' => 'Photo de profil',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'fw-bold'],
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/jpeg', 'image/webp', 'image/png'],
                        'mimeTypesMessage' => 'Uniquement les fichiers webp, png et jpg',
                    ]),
                ],
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
