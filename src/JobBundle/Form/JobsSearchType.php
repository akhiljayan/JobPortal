<?php

namespace JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityRepository;

class JobsSearchType extends AbstractType {
    

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('jobTitle', 'text', array(
            'attr' => array('class' => 'form-control','placeholder'=>'Search Key. Ex: Software java'),
        ));
        $builder->add('company', 'text', array(
            'attr' => array('class' => 'form-control','placeholder'=>'Company Name. Ex: Google'),
            'required'=>false
        ));
        
        $builder->add('salaryRange', 'text', array(
            'attr' => array('class' => 'price_range'),
            'mapped'=>false,
            'required'=>false
        ));
        
        $builder->add('experienceRange', 'text', array(
            'attr' => array('class' => 'experience_range'),
            'mapped'=>false,
            'required'=>false
        ));
        
        $builder->add('skillsRequired', 'hidden', array(
            'attr' => array('class' => 'form-control'),
            'label' => 'Skills Required',
            'required' => false
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
                'attr' => array('class' => 'form-control selectpicker','data-show-subtext'=>'true'),
                'label' => 'Job Sub-Category',
                 'empty_value' => 'Select a Sub-Category',
                'required'=>false,
                'query_builder' => function (EntityRepository $er) use($category) {
                    return $er->createQueryBuilder('s')->where('s.category=' . $category)->orderBy('s.subCategory', 'ASC');
              }));
        };
        
        $builder->add('category', 'entity', array(
             'class' => 'JobBundle:JobCategory',
            'property'=>'category',
            'empty_value' => 'Select a Category',
            'attr' => array('class' => 'form-control selectpicker','data-show-subtext'=>'true'),
            'label' => 'Job Catagory',
            'required'=>false
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
