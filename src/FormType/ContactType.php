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
        /*
         * Baue mithilfe des FormBuilders das Formular zusammen. Dazu füge die Felder hinzu welche angezeigt werden
         * sollen. Verwende dazu die Funktion 'add'.
         *
         * Füge folgende Felder hinzu:
         * - name (Name) --> TextType
         * - email (Email) --> EmailType
         * - subject (Betreff) --> TextType
         * - message (Nachricht) --> TextareaType
         * - Senden (Nachricht senden) --> SubmitType
         *
         */
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class, // Map the fields to the properties of the Contact class
        ]);
    }
}
