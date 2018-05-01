<?php
namespace OC\TicketingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use OC\TicketingBundle\Form\Type\TicketsType;

class BooksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', DateType::class, array(
            'widget'  => 'single_text',
            'html5'   =>  false,
            'format'  => 'dd/MM/yyyy'
        ))
            ->add('mail', EmailType::class)
            ->add('name', TextType::class)
            ->add('username', TextType::class)
            ->add('country', CountryType::class)
            ->add('tickets', CollectionType::class, array(
                'entry_type'   => TicketsType::class,
                'allow_add'    => true,
                'allow_delete' => false
            ))
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'OC\TicketingBundle\Entity\Books'));
    }

    public function getBlockPrefix()
    {
        return 'oc_ticketing_books';
    }
}