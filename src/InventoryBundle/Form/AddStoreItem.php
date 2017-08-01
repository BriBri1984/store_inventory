<?php

namespace InventoryBundle\Form;

use InventoryBundle\Entity\StoreStock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;


class AddStoreItem extends AbstractType
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
        return 'inventory_bundle_add_store_item';
    }
}
