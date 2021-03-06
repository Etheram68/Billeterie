<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\Type\TicketsType;

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
            ->add('tickets', CollectionType::class, array(
                'entry_type'   => TicketsType::class,
                'allow_add'    => true,
                'allow_delete' => false
            ))
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Books'));
    }

    public function getBlockPrefix()
    {
        return 'AppBundle_books';
    }
}