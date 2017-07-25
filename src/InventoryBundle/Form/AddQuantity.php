<?php

namespace InventoryBundle\Form;

use InventoryBundle\Entity\StockQuantity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddQuantity
 * @package InventoryBundle\Form
 */
class AddQuantity extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', NumberType::class)
            ->add('stock_quantity', NumberType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StockQuantity::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'inventory_bundle_add_quantity';
    }
}
