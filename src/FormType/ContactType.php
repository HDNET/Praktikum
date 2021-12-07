<?php

declare(strict_types=1);

namespace App\FormType;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Build the form which is rendered in the browser
        $builder
            ->add('name', TextType::class, [ // Add a text field for the name
                'empty_data' => '',
                'label' => 'Name',
            ])
            ->add('email', EmailType::class, [ // Add a text field which is of type 'email' for the email
                'empty_data' => '',
                'label' => 'Email',
            ])
            ->add('subject', TextType::class, [ // Add a text field for the subject
                'empty_data' => '',
                'label' => 'Betreff'
            ])
            ->add('message', TextareaType::class, [ // Add a text area (bigger text field) for the message
                'empty_data' => '',
                'label' => 'Nachricht',
            ])
            ->add('Senden', SubmitType::class, [ // Add a button to submit the form and send the email
                'label' => 'Nachricht senden',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class, // Map the fields to the properties of the Contact class
        ]);
    }
}
