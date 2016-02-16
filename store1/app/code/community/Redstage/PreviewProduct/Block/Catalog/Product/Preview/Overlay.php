<?php

class Redstage_PreviewProduct_Block_Catalog_Product_Preview_Overlay extends Mage_Core_Block_Template
{
    public function getProduct()
    {
        if (!Mage::registry('product') && $this->getProductId()) {
            $product = Mage::getModel('catalog/product')->load($this->getProductId());
            Mage::register('product', $product);
        }
        return Mage::registry('product');
    }
    public function getCloseButtonHtml() {
            $this->setChild('close_button',
                $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                        'label'     => Mage::helper('catalog')->__('Close Window'),
                        'onclick'   => 'window.close();',
                        'class' => 'cancel'
                    ))
            );
                    
            return $this->getChildHtml('close_button');
    }
}
