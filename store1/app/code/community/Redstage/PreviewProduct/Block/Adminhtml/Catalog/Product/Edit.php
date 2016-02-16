<?php

class Redstage_PreviewProduct_Block_Adminhtml_Catalog_Product_Edit extends Mage_Adminhtml_Block_Catalog_Product_Edit
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('previewproduct/catalog/product/edit.phtml');
    }

    protected function _prepareLayout()
    {
        if (!$this->getRequest()->getParam('popup')) {
            if (!$this->getProduct()->isReadonly()) {
                $this->setChild('save_and_preview_button',
                    $this->getLayout()->createBlock('adminhtml/widget_button')
                        ->setData(array(
                            'label'     => Mage::helper('catalog')->__('Save and Preview'),
                            'onclick'   => 'saveAndPreview(\''.$this->getSaveAndPreviewUrl().'\')',
                            'class' => 'save'
                        ))
                );
            }
        }

        return parent::_prepareLayout();
    }

    public function getSaveAndPreviewButtonHtml()
    {
        return $this->getChildHtml('save_and_preview_button');
    }

    public function getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current'   => true,
            'back'       => 'edit',
            'preview'    => 'false',
            'tab'        => '{{tab_id}}',
            'active_tab' => null
        ));
    }

    public function getSaveAndPreviewUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current'   => true,
            'back'       => 'edit',
            'preview'       => 'true',
            'tab'        => '{{tab_id}}',
            'active_tab' => null
        ));
    }

    public function getPreviewUrl()
    {
        if ($this->getRequest()->getParam('preview') == "true") {
            if (!Mage::app()->isSingleStoreMode()) {
                $storeId = $this->getRequest()->getParam('store');
                $store = Mage::getModel('core/store')->load($storeId?$storeId:Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);
            } else {
                $store = Mage::app()->getStore(Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID);
            }
            return $store->getUrl('catalog/product/preview/id/'.$this->getProductId(),
            	array("_secure" => true));
        }
        return false;
    }
}
