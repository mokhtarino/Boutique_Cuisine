<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Indiquer votre nom'],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Prenom',
                'attr' => ['placeholder' => 'Indiquer votre prenom'],
                'constraints' => [new Length(['min' => 2, 'max' => 255])],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'Indiquer votre Email'],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [new Length([
                    'min' => 6,
                    'max' => 20,
                ])],
                'first_options' => [
                    'label' => 'Choisissez votre mot de passe',
                    'attr' => ['placeholder' => 'Choisissez votre mot de passe'],
                    'hash_property_path' => 'password',
                ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe',
                    "attr" => ["placeholder" => "Confirmer votre mot de passe"],
                ],
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => ['class' => 'btn btn-success'
                ]
            ])
            ->add('reset', ResetType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
              new UniqueEntity([
                  'entityClass' => User::class,
                  'fields' => ['email'],
              ])
            ],
            'data_class' => User::class,
        ]);
    }
}
