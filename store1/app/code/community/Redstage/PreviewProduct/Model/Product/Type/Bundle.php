<?php

class Redstage_PreviewProduct_Model_Product_Type_Bundle extends Mage_Bundle_Model_Product_Type
{
    public function isSalable($product = null)
    {
        $optionCollection = $this->getOptionsCollection($product);

        if (!count($optionCollection->getItems())) {
            return false;
        }

        $requiredOptionIds = array();

        foreach ($optionCollection->getItems() as $option) {
            if ($option->getRequired()) {
                $requiredOptionIds[$option->getId()] = 0;
            }
        }

        $selectionCollection = $this->getSelectionsCollection($optionCollection->getAllIds(), $product);

        if (!count($selectionCollection->getItems())) {
            return false;
        }
        $salableSelectionCount = 0;
        foreach ($selectionCollection as $selection) {
            if ($selection->isSalable()) {
                $requiredOptionIds[$selection->getOptionId()] = 1;
                $salableSelectionCount++;
            }

        }

        return (array_sum($requiredOptionIds) == count($requiredOptionIds) && $salableSelectionCount);
    }
}