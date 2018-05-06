<?php
namespace OC\TicketingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', ChoiceType::class, array(
            "choices"  => array("Journée" => true, "Demi-Journée" => false),
            "attr"     => array('class' =>'typePick'),
            "label"    => 'Type de visite'
        ))
            ->add('name', TextType::class, array('label' => 'Nom'))
            ->add('username', TextType::class, array('label' => 'Prénom'))
            ->add('birthDate', DateType::class, array(
                'widget'     =>  'single_text',
                'html5'      =>  false,
                'data_class' =>  'DateTime',
                'format'     =>  'dd/mm/yyyy',
                'attr'       =>  array('class' => 'datepicker'),
                'label'      =>  'Date de Naissance'
        ))
            ->add('discount', ChoiceType::class, array(
                "choices"   => array("Non" => false, "Oui" => true),
                "label"     =>  'Réduction'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'OC\TicketingBundle\Entity\Tickets'));
    }

    public function getBlockPrefix()
    {
        return 'oc_ticketingbundle_tickets';
    }
}