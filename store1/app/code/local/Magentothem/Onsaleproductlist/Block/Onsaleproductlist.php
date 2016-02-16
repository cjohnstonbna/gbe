<?php
class Magentothem_Onsaleproductlist_Block_Onsaleproductlist extends Mage_Catalog_Block_Product_List
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

    public function getColumnCount()
    {
        return $this->getConfig('items');
    }

    protected function _getProductCollection()
    { 
		$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		$collection = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToSelect('*')
			->addMinimalPrice()
			->addFinalPrice()
			->addUrlRewrite()
			->addTaxPercents()			
			->addStoreFilter()
			->addAttributeToFilter('special_price', array('notnull' => true))
			->addAttributeToFilter('special_from_date', array('date'=>true, 'to'=> $todayDate))
			->addAttributeToFilter(array(array('attribute'=>'special_to_date', 'date'=>true, 'from'=>$todayDate), array('attribute'=>'special_to_date', 'is' => new Zend_Db_Expr('null'))),'','left')
			->setOrder(Mage::getBlockSingleton('catalog/product_list_toolbar')->getCurrentOrder(), Mage::getBlockSingleton('catalog/product_list_toolbar')->getCurrentDirection());
			
			Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
			Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
			$limit = (int)$this->getRequest()->getParam('limit') ? (int)$this->getRequest()->getParam('limit') : (int)$this->getToolbarBlock()->getDefaultPerPageValue();
			$collection->setPageSize($limit)->setCurPage($this->getRequest()->getParam('p'));
			Mage::getModel('review/review')->appendSummary($collection);
			//$collection->load();
			return $collection;
    }
	
	protected function getAllonsale()
    { 
		$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		$collection = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToSelect('*')
			->addMinimalPrice()
			->addFinalPrice()
			->addUrlRewrite()
			->addTaxPercents()			
			->addStoreFilter()
			->addAttributeToFilter('special_price', array('notnull' => true))
			->addAttributeToFilter('special_from_date', array('date'=>true, 'to'=> $todayDate))
			->addAttributeToFilter(array(array('attribute'=>'special_to_date', 'date'=>true, 'from'=>$todayDate), array('attribute'=>'special_to_date', 'is' => new Zend_Db_Expr('null'))),'','left');
			
			Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
			Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
			
			return $collection;
    }
	
	public function getConfig($att) 
	{
		$config = Mage::getStoreConfig('onsaleproductlist');
		if (isset($config['onsaleproductlist_config'][$att]) ) {
			$value = $config['onsaleproductlist_config'][$att];
			return $value;
		}
	}
}