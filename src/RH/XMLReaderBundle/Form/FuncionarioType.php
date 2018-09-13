<?php

namespace RH\XMLReaderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FuncionarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nome',TextType::class,array('label' => 'Nome',
                                            'attr'=>array('class'=> 'input-sm')))
                ->add('cpf',TextType::class,array('label' => 'Cpf',
                                            'attr'=>array('class' => 'input-sm')))
                ->add('drt')
                ->add('pis')
                ->add('status');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RH\XMLReaderBundle\Entity\Funcionario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'rh_xmlreaderbundle_funcionario';
    }


}
