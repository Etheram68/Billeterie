<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class TicketsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', ChoiceType::class, array(
            "choices"  => array("Journée" => true, "Demi-Journée" => false),
            "attr"     => array('class' =>'typePick'),
            "label"    => 'Type de visite'
        ))
            ->add('country', CountryType::class, array(
                'label'  => 'Pays'
            ))
            ->add('name', TextType::class, array('label' => 'Nom'))
            ->add('username', TextType::class, array('label' => 'Prénom'))
            ->add('birthDate', DateType::class, array(
                'widget'     =>  'single_text',
                'html5'      =>  false,
                'data_class' =>  'DateTime',
                'format'     => 'dd/MM/yyyy',
                'attr'       =>  array('class' => 'datepicker'),
                'label'      =>  'Date de Naissance'
        ))
            ->add('discount', CheckboxType::class, array(
                "label"     =>  'Réduction',
                'required'  =>  false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Tickets'));
    }

    public function getBlockPrefix()
    {
        return 'AppBundle_tickets';
    }
}