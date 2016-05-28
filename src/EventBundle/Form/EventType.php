<?php

namespace EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('private', ChoiceType::class, array(
                "required"	    => true,
                "label"         => 'Type d\'évènement',
                "choices"	=> array(
                    "0"	=> 'Publique',
                    "1"	=> 'Privé',
                )))
            ->add('placeAvailable', TextType::class, array(
                "required"      => true,
                "label"         => 'Place disponible',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventBundle\Entity\Event'
        ));
    }
}
