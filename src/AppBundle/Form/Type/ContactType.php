<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr' => array(),
                'constraints' => array(
                    new NotBlank(array("message" => "Entrer votre nom")),
                )
            ))
            ->add('subject', TextType::class, array('attr' => array(),
                'constraints' => array(
                    new NotBlank(array("message" => "Entrer le sujet de l'email")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array(),
                'constraints' => array(
                    new NotBlank(array("message" => "Entrer une adresse mail valide")),
                    new Email(array("message" => "Votre email ne semble pas être valide")),
                )
            ))
            ->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Votre message ici'),
                'constraints' => array(
                    new NotBlank(array("message" => "Entrer votre message"))
                )
            ))
            ->add('valider', SubmitType::class);
        ;
    }
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'contact_form';
    }
}
