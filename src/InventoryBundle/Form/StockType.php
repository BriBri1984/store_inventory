<?php

namespace InventoryBundle\Form;

use InventoryBundle\Entity\Stock;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

/**
 * Class StockType
 * @package InventoryBundle\Form
 */
class StockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', Type\TextType::class, [
                'required' => true,
                'constraints' => [

                    ]
            ])
            ->add('date', Type\DateType::class, [
                'html5' => true,
                'required' => true
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stock::class
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'inventory_bundle_stock_type';
    }
}
