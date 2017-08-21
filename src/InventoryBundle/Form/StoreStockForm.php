<?php

namespace InventoryBundle\Form;

use InventoryBundle\Entity\StoreStock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreStockForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('store', EntityType::class, [
                'class' => 'InventoryBundle\Entity\Store',
                'choice_label' => 'getStoreName',
            ])
            ->add('stock', EntityType::class, [
                'class' => 'InventoryBundle\Entity\Stock',
                'choice_label' => 'getName',
            ])
            ->add('quantity', NumberType::class)
            ->add('date_given', DateType::class, [
                'html5' => 'true',
                'required' => 'true'
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StoreStock::class
        ]);

    }

    public function getBlockPrefix()
    {
        return 'inventory_bundle_store_stock_form';
    }
}
