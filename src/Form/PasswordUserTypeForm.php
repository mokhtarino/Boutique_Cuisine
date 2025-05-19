<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Validator\Constraints\Length;

class PasswordUserTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword', PasswordType::class, [
                'label' => 'Mot de passe actuel',
                'attr' => ['placeholder' => 'Mot de passe actuel'],
                'mapped' => false,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [new Length([
                    'min' => 6,
                    'max' => 20,
                ])],
                'first_options' => [
                    'label' => 'Choisissez votre nouveau mot de passe',
                    'attr' => ['placeholder' => 'Choisissez votre mot de passe'],
                    'hash_property_path' => 'password',
                ],
                'second_options' => [
                    'label' => 'Confirmer votre nouveau mot de passe',
                    "attr" => ["placeholder" => "Confirmer votre mot de passe"],
                ],
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Mettre à jour mon mot de passe',
                'attr' => ['class' => 'btn btn-success'
                ]
            ])
            ->add('reset', ResetType::class)
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $form = $event->getForm();
                $actualPwd = $form->get('actualPassword')->getData();
                $user = $form->getConfig()->getOptions()['data'];
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher'];
                $isValid = $passwordHasher->isPasswordValid($user, $actualPwd);
                if (!$isValid) {
                    $form->get('actualPassword')->addError(new FormError('Mot de passe incorrect'));
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher' => null
        ]);
    }
}
