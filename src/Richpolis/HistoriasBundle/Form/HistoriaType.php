<?php

namespace Richpolis\HistoriasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Richpolis\UsuariosBundle\Entity\Usuario;

class HistoriaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario',null,array('label'=>'Usuario','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Usuario',
                'data-bind'=>'value: usuario'
             )))
            ->add('hijo',null,array('label'=>'Hijo(a)','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Hijo(a)',
                'data-bind'=>'value: hijo(a)'
             )))    
            ->add('historia',null,array('label'=>'Historia','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Historia',
                'data-bind'=>'value: historia'
             )))
            ->add('fecha','date',array('label'=>'Fecha historia','widget' => 'single_text',
                'format' => 'yyyy-MM-dd','attr'=>array('class'=>'form-control')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\HistoriasBundle\Entity\Historia'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'richpolis_historiasbundle_historia';
    }
}
