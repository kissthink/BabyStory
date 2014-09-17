<?php

namespace Richpolis\UsuariosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HijoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apodo')
            ->add('usarApodo')
            ->add('fechaNacimiento')
            ->add('biografia')
            ->add('imagen')
            ->add('papa')
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
