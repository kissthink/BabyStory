<?php

namespace Richpolis\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Richpolis\UsuariosBundle\Entity\Hijo;
use Richpolis\UsuariosBundle\Form\DataTransformer\UsuarioToNumberTransformer;

class HijoFrontendType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];
        $usuarioTransformer = new UsuarioToNumberTransformer($em);
        
        $builder
            ->add('nombre','text',array('label'=>'Nombre','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Nombre',
                'data-bind'=>'value: nombre'
             )))
            ->add('apodo','text',array('label'=>'Apodo','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Apodo',
                'data-bind'=>'value: apodo'
             )))
            ->add('usarApodo',null,array('label'=>'Usar apodo?','attr'=>array(
                'class'=>'checkbox-inline',
                'placeholder'=>'Usar apodo',
                'data-bind'=>'value: usarApodo'
             )))
            ->add('sexo','hidden')       
            ->add('fechaNacimiento',null,array('label'=>'Fecha nacimiento'))
            ->add('biografia',null,array('label'=>'Biografia','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'Biografia',
                'data-bind'=>'value: biografia'
             )))
            ->add('file','file',array('label'=>'Imagen',
                'required'=>false,
                'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Imagen usuario',
                    'data-bind'=>'value: imagen usuario'
             )))  
            ->add('imagen','hidden')
            ->add($builder->create('papa','hidden')->addModelTransformer($usuarioTransformer))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\UsuariosBundle\Entity\Hijo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'richpolis_usuariosbundle_hijo';
    }
}
