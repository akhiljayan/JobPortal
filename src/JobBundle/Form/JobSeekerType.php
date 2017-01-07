<?php

namespace JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class JobSeekerType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('firstName', 'text', array(
                    'label' => 'First Name',
                    'attr' => array('class' => 'form-control')))
                ->add('lastName', 'text', array(
                    'label' => 'Last Name',
                    'attr' => array('class' => 'form-control')))
                ->add('dob', 'text', array(
                    'attr' => ['class' => 'form-control js-datepicker'],
                    ))
                ->add('email', 'text', array(
                    'label' => 'Email',
                    'attr' => array('class' => 'form-control')))
                ->add('course', 'text', array(
                    'attr' => array('class' => 'form-control')))
                ->add('majors', 'text', array(
                    'label' => 'Majors',
                    'attr' => array('class' => 'form-control')))
                ->add('address', 'text', array(
                    'label' => 'Address',
                    'attr' => array('class' => 'form-control')))
                ->add('cityTown', 'text', array(
                    'label' => 'City/Town',
                    'attr' => array('class' => 'form-control')))
                ->add('state', 'text', array(
                    'label' => 'State',
                    'attr' => array('class' => 'form-control')))
                ->add('zipCode', 'text', array(
                    'label' => 'Zip Code',
                    'attr' => array('class' => 'form-control')))
                ->add('country', 'text', array(
                    'label' => 'Country',
                    'attr' => array('class' => 'form-control')))
                ->add('phoneNumber', 'text', array(
                    'label' => 'Phone Number',
                    'attr' => array('class' => 'form-control')))
                ->add('aboutMe', 'textarea', array(
                    'label' => 'About Me',
                    'required' => false,
                    'attr' => array('class' => 'form-control bootstrap3-wysihtml5 form-control')))
                ->add('educationLevelId', "entity", array(
                    'class' => 'JobBundle:EducationLevel',
                    'property' => 'eduLevel',
                    'empty_value' => "Education Level",
                    'label' => 'Education Level',
                    'attr' => array("class" => 'form-control selectpicker show-tick mb-15')))
                ->add('save', 'submit', array("label" => "Save", "attr" => array('class' => 'btn btn-primary')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'JobBundle\Entity\JobSeeker'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'jobbundle_jobseeker';
    }

}
