<?php

namespace Richpolis\HistoriasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComentarioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comentario',null,array('label'=>'Historia','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Historia',
                'data-bind'=>'value: historia'
             )))
            ->add('calificacion')
            ->add('usuario',null,array('label'=>'Usuario','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Usuario',
                'data-bind'=>'value: usuario'
             )))
            ->add('historia',null,array('label'=>'Historia','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Historia',
                'data-bind'=>'value: historia'
             )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\HistoriasBundle\Entity\Comentario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'richpolis_historiasbundle_comentario';
    }
}
