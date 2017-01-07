<?php

namespace JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkExpResumeType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('jobPosition', 'text', array(
            'label' => 'College/School',
            'required' =>false,
            'attr' => array('class' => 'form-control')));
        $builder->add('fromDate', 'text', array(
            'required' =>false,
            'attr' => ['class' => 'form-control js-datepicker'],
        ));
        $builder->add('toDate', 'text', array(
            'required' =>false,
            'attr' => ['class' => 'form-control js-datepicker'],
        ));
        $builder->add('company', 'text', array(
            'required' =>false,
            'label' => 'College/School',
            'attr' => array('class' => 'form-control')));
        $builder->add('details', 'textarea', array(
            'required' =>false,
            'label' => 'Aditional Info',
            'attr' => array('class' => 'bootstrap3-wysihtml5 form-control')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'JobBundle\Entity\WorkExpResume'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'jobbundle_workexpresume';
    }

}
