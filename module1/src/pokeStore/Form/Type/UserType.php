<?php

namespace PokeStore\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text', array(
                'label' => "Nom",))
                ->add('address','text', array(
                'label' => "Adresse"))
                ->add('email','text', array(
                'label' => "Email"))
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('required' => true),
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Repeter le mot de passe'),
                    
                ))
          ;
    }

    public function getName() {
        return 'user';
    }

}
