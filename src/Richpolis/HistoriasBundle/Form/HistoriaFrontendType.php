<?php

namespace Richpolis\HistoriasBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Richpolis\UsuariosBundle\Entity\Usuario;

class HistoriaFrontendType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->usuario = $options['usuario'];
        
        $builder
            ->add('hijo','entity',array(
                'class'=> 'UsuariosBundle:Hijo',
                'label'=>'Niño(a)',
                'required'=>true,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('h')
                        ->where('h.papa=:papa')
                        ->orderBy('h.sexo', 'ASC')
                        ->addOrderBy('h.nombre','ASC')    
                        ->setParameter('papa',$this->usuario->getId());
                },
                'attr'=>array(
                    'class'=>'form-control placeholder',
                    'placeholder'=>'Hijo',
                    'data-bind'=>'value: hijo',
                    )
                ))    
            ->add('fecha',null,array('label'=>'Fecha historia','attr'=>array(
                'class'=>'validate[required] form-control placeholder',
                'placeholder'=>'fecha',
                'data-bind'=>'value: fecha'
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
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Richpolis\HistoriasBundle\Entity\Historia',
            ))
            ->setRequired(array(
                'usuario',
            ))
            ->setAllowedTypes(array(
                'usuario' => 'Richpolis\UsuariosBundle\Entity\Usuario',
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
