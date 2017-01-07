<?php

namespace JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text', array(
            'label' => 'Name',
            'mapped' => false,
            'attr' => array('class' => 'form-control')));
        $builder->add('username', 'text', array(
            'label' => 'Username',
            'mapped' => false,
            'attr' => array('class' => 'form-control')));
        $builder->add('email', 'text', array(
            'label' => 'Email',
            'mapped' => false,
            'attr' => array('class' => 'form-control')));
        $builder->add('mobile', 'text', array(
            'label' => 'Mobile Number',
            'mapped' => false,
            'attr' => array('class' => 'form-control mobile-number')));
        $builder->add('password', 'repeated', array(
            'type' => 'password',
            'options' => array('attr' => array('class' => 'password-field form-control')),
            'required' => true,
            'label' => 'Password',
            'first_options' => array('label' => 'Password'),
            'second_options' => array('label' => 'Confirm Password'),
            'mapped' => false,
            'attr' => array('class' => 'form-control'),
        ));
        $builder->add('userType', 'hidden', array(
            'mapped' => false,
            'data' => 'jobSeeker',
            'attr' => array('class' => 'form-control')));
//        $builder->add('save', 'submit', array('attr' => array('class' => 'btn btn-primary')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AkjnBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'akjnbundle_user';
    }

}
