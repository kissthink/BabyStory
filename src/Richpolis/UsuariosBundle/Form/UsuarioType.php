<?php

namespace Richpolis\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password')
            ->add('salt')
            ->add('email')
            ->add('ciudad')
            ->add('biografia')
            ->add('serMadre')
            ->add('imagen')
            ->add('rol')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\UsuariosBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'richpolis_usuariosbundle_usuario';
    }
}
