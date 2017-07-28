<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Doctrine\ORM\EntityRepository;

class DealType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, array (
                'class' => 'AppBundle:Category',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
            ))
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('price', NumberType::class, array (
                'required' => true,
                'attr' => array(
                   'min' => 0,
                   'step' => 1,
               ),
            ))
            ->add('duration', NumberType::class, array (
                'required' => true,
                'attr' => array(
                   'min' => 0,
                   'step' => 1,
               ),
            ))
            ->add('availability', NumberType::class, array (
                'required' => true,
                'attr' => array(
                   'min' => 0,
                   'step' => 1,
               ),
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Deal',
        ));
    }
}
