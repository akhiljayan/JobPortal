<?php

namespace JobBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobSubCategoryType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('subCategory','text',array(
            'label'=>'Sub Category Name',
            'attr'=>array('class'=>'form-control')
        ));
        $builder->add('category','entity',array(
            'label'=>'Category',
            'class' => 'JobBundle:JobCategory',
            'property'=>'category',
            'empty_value' => 'Select a Category',
            'attr'=>array('class'=>'form-control')
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JobBundle\Entity\JobSubCategory'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'jobbundle_jobsubcategory';
    }


}
