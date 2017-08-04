<?php

namespace InventoryBundle\Form;

use InventoryBundle\Entity\StoreStockQuantity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddStoreStockQuantity extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', NumberType::class)
            ->add('store_stock_quantity', NumberType::class)
            ->add('date', DateType::class, [
                'html5' => true,
                'required' => true
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StoreStockQuantity::class
        ]);

    }

    public function getBlockPrefix()
    {
        return 'inventory_bundle_add_store_stock_quantity';
    }
}
