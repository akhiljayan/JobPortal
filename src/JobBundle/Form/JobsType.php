<?php

namespace JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityRepository;

class JobsType extends AbstractType {
    
    private $array;
    function __construct($array) {
        $this->array = $array;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('jobTitle', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Job Title'
        ));
        $builder->add('company', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Company Name'
        ));
        $builder->add('experYearFrom', 'choice', array(
            'choices' => $this->array,
            'empty_value' => false,
            'attr' => array('class' => 'form-control  small-width'),
            'label' => 'Experience From (years)'
        ));
        $builder->add('exprYearTo', 'choice', array(
            'choices' => $this->array,
            'empty_value' => false,
            'attr' => array('class' => 'form-control  small-width'),
            'label' => 'Experience To (years)'
        ));
        $builder->add('jobDescription', 'textarea', array(
            'attr' => array('class' => 'form-control bootstrap3-wysihtml5'),
            'label' => 'Job Description'
        ));
        $builder->add('responsibilities', 'textarea', array(
            'attr' => array('class' => 'form-control bootstrap3-wysihtml5'),
            'label' => 'Job Responsibilities',
            'required' => false
        ));
        $builder->add('slaryStart', 'text', array(
            'attr' => array('class' => 'form-control  small-width'),
            'label' => 'Salary Range From',
            'required' => false
        ));
        $builder->add('salaryTo', 'text', array(
            'attr' => array('class' => 'form-control small-width'),
            'label' => 'Salary Range To',
            'required' => false
        ));
        $builder->add('jobDesignation', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Job Designation'
        ));
        $builder->add('skillsRequired', 'hidden', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Skills Required',
            'required' => false
        ));
        $builder->add('qualification', 'textarea', array(
            'attr' => array('class' => 'form-control bootstrap3-wysihtml5'),
            'label' => 'Qualifications Required',
            'required' => false
        ));
        $builder->add('vacancy', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Vacancys'
        ));
        
         $builder->add('location', 'text', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Location'
        ));
        
        
        
        $subCategorySelector = function(FormInterface $form, \JobBundle\Entity\JobCategory $category = null) {
            if ($category instanceof \JobBundle\Entity\JobCategory) {
                $category = $category->getId();
            } else {
                $category = 0;
            }
            $form->add('subCategory', 'entity', array(
                'class' => 'JobBundle:JobSubCategory',
                'property'=>'subCategory',
                'attr' => array('class' => 'form-control'),
                'label' => 'Job Sub-Category',
                 'empty_value' => 'Select a Sub-Category',
                'query_builder' => function (EntityRepository $er) use($category) {
                    return $er->createQueryBuilder('s')->where('s.category=' . $category)->orderBy('s.subCategory', 'ASC');
              }));
        };
        
        $builder->add('category', 'entity', array(
             'class' => 'JobBundle:JobCategory',
            'property'=>'category',
            'empty_value' => 'Select a Category',
            'attr' => array('class' => 'form-control'),
            'label' => 'Job Catagory'
        ));
        $builder->get('category')->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) use ($subCategorySelector) {
            $subCategorySelector($event->getForm()->getParent(), $event->getForm()->getData());
        });
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) use ($subCategorySelector) {
            $data = $event->getData();
            $subCategorySelector($event->getForm(), $data->getCategory());
        });
        
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'JobBundle\Entity\Jobs'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'jobbundle_jobs';
    }

    

}
