<?php

namespace JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ResumeEducationType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('collegeSchool', 'text', array(
            'label' => 'College/School',
            'attr' => array('class' => 'form-control')));
        $builder->add('universityBoard', 'text', array(
            'label' => 'University/Board',
            'attr' => array('class' => 'form-control')));
        $builder->add('fromDate', 'text', array(
            'attr' => ['class' => 'form-control js-datepicker'],
        ));
        $builder->add('toDate', 'text', array(
            'attr' => ['class' => 'form-control js-datepicker'],
        ));
        $builder->add('universityBoard', 'text', array(
            'label' => 'University/Board',
            'attr' => array('class' => 'form-control')));
        $builder->add('educationLevelId', "entity", array(
            'class' => 'JobBundle:EducationLevel',
            'property' => 'eduLevel',
            'empty_value' => "Education Level",
            'label' => 'Education Level',
            'attr' => array("class" => 'form-control selectpicker show-tick mb-15')));
        $builder->add('course', 'text', array(
            'label' => 'Course',
            'attr' => array('class' => 'form-control')));
        $builder->add('specialisation', 'text', array(
            'label' => 'Specialisation',
            'attr' => array('class' => 'form-control required')));
        $builder->add('gpaPercentage', ChoiceType::class, array(
            'choices' => array(
                'g' => 'GPA',
                'p' => 'Percentage',
            ),
        ));
        $builder->add('result', 'text', array(
            'label' => 'Result',
            'attr' => array('class' => 'form-control')));
        $builder->add('aditionalInfo', 'textarea', array(
            'required' => false,
            'label' => 'Aditional Info',
            'attr' => array('class' => 'bootstrap3-wysihtml5 form-control')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'JobBundle\Entity\ResumeEducation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'jobbundle_resumeeducation';
    }

}
