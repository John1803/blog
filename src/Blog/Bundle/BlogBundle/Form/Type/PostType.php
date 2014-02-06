<?php

namespace Blog\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder->add('title', 'text')
            ->add('author', 'text')
            ->add('post', 'textarea')
            ->add('createdAt', 'date')
//            ->add('category', 'entity',
//                array(
//                   'class'=>'BlogBlogBundle:Category',
//                    'property'=>'title'))
            ->add('submit', 'submit')
            ;
    }

    public function getName()
    {
        return 'post';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blog\Bundle\BlogBundle\Entity\Post'
        ));
    }
} 