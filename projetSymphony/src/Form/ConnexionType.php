<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Employe;
use Symfony\Component\Form\Extension\Core\Type as SFType;
use Symfony\Component\Form\FormRenderer;

class ConnexionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', SFType\TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Votre identifiant'],
                'label' => 'Identifiant',
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('mdp', SFType\PasswordType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Votre mot de passe'],
                'label' => 'Mot de passe',
                'label_attr' => ['class' => 'form-label']
            ])
            ->add('Connexion', SFType\SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary w-100 mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
