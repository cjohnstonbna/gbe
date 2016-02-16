<?php
class Magentothem_Onsaleproductlist_Model_Config_Onsaleproduct
{

    public function toOptionArray()
    {
		$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		$collection = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToSelect('*')
			->addAttributeToFilter('status', array('eq'=>'1'))
			->addAttributeToFilter('special_price', array('notnull' => true))
			->addAttributeToFilter('special_from_date', array('date'=>true, 'to'=> $todayDate))
			->addAttributeToFilter(array(array('attribute'=>'special_to_date', 'date'=>true, 'from'=>$todayDate), array('attribute'=>'special_to_date', 'is' => new Zend_Db_Expr('null'))),'','left')
			->setOrder('entity_id', 'asc');
			
		$products = array();
		foreach($collection as $product)
		{
			$products[] = array('value'=>$product->getId(), 'label'=>Mage::helper('adminhtml')->__($product->getId()));
		}
        return $products;
    }

}
