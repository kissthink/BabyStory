<?php

namespace Richpolis\HistoriasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ComponenteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo')
            ->add('componente')
            ->add('tipoUsuario')
            ->add('position')
            ->add('papa')
            ->add('hijo')
            ->add('historia')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\HistoriasBundle\Entity\Componente'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'richpolis_historiasbundle_componente';
    }
}
