<?php

class Redstage_PreviewProduct_Model_Product_Type_Configurable extends Mage_Catalog_Model_Product_Type_Configurable
{
    public function isSalable($product = null)
    {
        foreach ($this->getUsedProducts(null, $product) as $child) {
            if ($child->isSalable()) {
                $salable = true;
                break;
            }
        }

        return $salable;
    }
}
