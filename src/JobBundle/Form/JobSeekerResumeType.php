<?php

namespace JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class JobSeekerResumeType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('resume', 'file', array('data_class' => null, 'label' => 'Resume (PDF file)', 'attr'  => array('class'=>' adi-mone','placeholder'=> 'PDF')));
        $builder->add('resumeEducation', CollectionType::class, array(
            'entry_type' => ResumeEducationType::class,
            'allow_add' => true,
            'label'=>'',
        ));
        $builder->add('workExpResume', CollectionType::class, array(
            'entry_type' => WorkExpResumeType::class,
            'allow_add' => true,
            'required' =>false,
            'label'=>''
        ));
        $builder->add('aditionalInfo', 'textarea', array(
            'label' => 'Aditional Info',
            'required' =>false,
            'attr' => array('class' => 'bootstrap3-wysihtml5 form-control')));
        
        $builder->add('skills', 'hidden', array(
            'attr' => array('class' => 'form-control')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'JobBundle\Entity\JobSeekerResume'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'jobbundle_jobseekerresume';
    }

}
