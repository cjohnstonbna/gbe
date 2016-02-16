<?php

class Redstage_PreviewProduct_Model_Product_Type_Grouped extends Mage_Catalog_Model_Product_Type_Grouped
{
    public function isSalable($product = null)
    {
        $salable = false;
        foreach ($this->getAssociatedProducts($product) as $associatedProduct) {
            $salable = $salable || $associatedProduct->isSalable();
        }
        return $salable;
    }
}