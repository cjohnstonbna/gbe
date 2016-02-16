<?php

require_once("Mage/Catalog/controllers/ProductController.php");
class Redstage_PreviewProduct_ProductController extends Mage_Catalog_ProductController
{
    public function addActionLayoutHandles()
    {
        parent::addActionLayoutHandles();
        if ($this->getFullActionName() != "catalog_product_preview") {
            return $this;
        }
        $update = $this->getLayout()->getUpdate();

        // load action handle
        $delimiter = '_';
        $update->addHandle(strtolower(
            $this->getRequest()->getRequestedRouteName().$delimiter.
            $this->getRequest()->getRequestedControllerName().$delimiter.
            "view"
         ));

        return $this;
    }
    
    protected function _switchSession($namespace, $id = null)
    {
        session_write_close();
        $GLOBALS['_SESSION'] = null;
        $session = Mage::getSingleton('core/session');
        if ($id) {
            $session->setSessionId($id);
        }
        $session->start($namespace);
    }
    
    public function previewAction()
    {
        $switchSessionName = 'adminhtml';
        $currentSessionId = Mage::getSingleton('core/session')->getSessionId();
        $currentSessionName = Mage::getSingleton('core/session')->getSessionName();
        if ($currentSessionId && $currentSessionName && isset($_COOKIE[$currentSessionName])) {
            $switchSessionId = $_COOKIE[$switchSessionName];
            $this->_switchSession($switchSessionName, $switchSessionId);
            if (!Mage::getSingleton('admin/session', array('name' => 'adminhtml'))->isLoggedIn()) {
                 $this->_redirect('/'); 
            }
            $this->_switchSession($currentSessionName, $currentSessionId);
        }

        Mage::getSingleton('core/session', array('name' => $this->_sessionNamespace))->start();
        // Get initial data from request
        $categoryId = (int) $this->getRequest()->getParam('category', false);
        $productId  = (int) $this->getRequest()->getParam('id');
        $specifyOptions = $this->getRequest()->getParam('options');

        // Prepare helper and params
        $viewHelper = Mage::helper('previewproduct/product_view');

        $params = new Varien_Object();
        $params->setCategoryId($categoryId);
        $params->setSpecifyOptions($specifyOptions);


        $this->getLayout()->getUpdate()->addUpdate('catalog_product_view');
        // Render page
        try {
            $viewHelper->prepareAndRender($productId, $this, $params);
        } catch (Exception $e) {
            if ($e->getCode() == $viewHelper->ERR_NO_PRODUCT_LOADED) {
                if (isset($_GET['store'])  && !$this->getResponse()->isRedirect()) {
                    $this->_redirect('');
                } elseif (!$this->getResponse()->isRedirect()) {
                    $this->_forward('noRoute');
                }
            } else {
                Mage::logException($e);
                $this->_forward('noRoute');
            }
        }
    }
}
