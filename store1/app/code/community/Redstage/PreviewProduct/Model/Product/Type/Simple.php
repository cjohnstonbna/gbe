<?php

class Redstage_PreviewProduct_Model_Product_Type_Simple extends Mage_Catalog_Model_Product_Type_Simple
{
    public function isSalable($product = null)
    {
        $salable = $this->getProduct($product)->getStockItem()->getIsInStock();
        if ($salable && $this->isComposite()) {
            $salable = null;
        }

        return (boolean) (int) $salable;
    }
}
