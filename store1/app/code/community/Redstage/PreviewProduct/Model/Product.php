<?php

class Redstage_PreviewProduct_Model_Product extends Mage_Catalog_Model_Product
{
    public function getTypeInstance($singleton = false)
    {
        if ($singleton === true) {
            if (is_null($this->_typeInstanceSingleton)) {
                $this->_typeInstanceSingleton = Mage::getSingleton('previewproduct/product_type')
                    ->factory($this, true);
            }
            return $this->_typeInstanceSingleton;
        }

        if ($this->_typeInstance === null) {
            $this->_typeInstance = Mage::getSingleton('previewproduct/product_type')
                ->factory($this);
        }
        return $this->_typeInstance;
    }
}
