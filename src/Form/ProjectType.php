<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        if (empty($entity->getPicture())) {
            $required = true;
            $picPlaceholder = 'Veuillez choisir une image...';
        } else {
            $required = false;
            $picPlaceholder = 'Veuillez choisir une nouvelle image... (facultatif)';
        }


        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre ',
                'attr' => [
                    'placeholder' => 'Titre'
                ]
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'attr' => [
                    'placeholder' => $picPlaceholder
                ],
                'required' => $required
            ])
            ->add('cost', IntegerType::class, [
                'label' => 'Coût du projet'
            ])
            ->add('excerpt', TextType::class, [
                'label' => 'Description courte'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description'
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Catégorie(s)',
                'class' => Category::class,
                "multiple" => true,
                'expanded' => true
            ])
            ->add('city' , EntityType::class, [
                'class' => City::class,
                'label' => 'Ville',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
