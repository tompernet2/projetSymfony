<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as SFType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', null, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('nbreHeures', SFType\NumberType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('departement', SFType\TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'libelle',
                'attr' => ['class' => 'form-select']
            ])
            ->add('inscriptionMax', SFType\NumberType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SFType\SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary w-100 mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
