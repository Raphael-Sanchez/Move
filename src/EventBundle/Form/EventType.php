<?php

namespace EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use EventBundle\Entity\Event;
use EventBundle\Entity\Activity;

class EventType extends AbstractType
{

    private $dataClass;

    public function __construct()
    {
        $this->dataClass = 'EventBundle\Entity\Event';
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('activity', EntityType::class, array(
                'class' => 'EventBundle:Activity',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.name', 'ASC');
                },
                'choice_label'  => 'name',
                'label'         => 'Activité'
            ))
            ->add('date', DateTimeType::class, array(
                'required'   => true,
                'input'     => 'datetime',
                'format'    => 'dd/MM/yyyy',
                'attr'      => array('class' => 'date'),
            ))
            ->add('address', TextType::class, array(
                "required"	    => true,
                "label"         => 'Adresse',
            ))
            ->add('zip', IntegerType::class, array(
                "required"	    => true,
                "label"         => 'Code Postal',
            ))
            ->add('city', TextType::class, array(
                "label"         => 'Ville',
                "required"	    => false,
            ))
            ->add('addressComplement', TextType::class, array(
                "required"	    => false,
                "label"         => 'Complément d\'adresse'
            ))
            ->add('private', ChoiceType::class, array(
                "required"	    => true,
                "label"         => 'Type d\'évènement',
                "choices"	=> array(
                    "Publique"  => false,
                    "Privé"	    => true,
            )))
            ->add('placeAvailable', IntegerType::class, array(
                "required"      => true,
                "label"         => 'Place disponible',
            ))
            ->add('price', NumberType::class, array(
                "required"      => true,
                "label"         => 'Prix',
            ))
            ->add('additionalInfo', TextareaType::class, array(
                "required"      => false,
                "label"         => 'Informations Complémentaires',
            ))
            ->add('additionalInfo', TextareaType::class, array(
                "required"      => false,
                "label"         => 'Informations Complémentaires',
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass,
        ));
    }
}
