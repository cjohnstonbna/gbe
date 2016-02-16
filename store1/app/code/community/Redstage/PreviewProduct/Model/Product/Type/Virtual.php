<?php

class Redstage_PreviewProduct_Model_Product_Type_Virtual extends Mage_Catalog_Model_Product_Type_Virtual
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
