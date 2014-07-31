<?php
class Creativestyle_MaxItem_Model_Observer
{
			public function checkProductQty(Varien_Event_Observer $observer)
			{

				$config = Mage::getStoreConfig('cataloginventory/cs_maximum_item');

				if($config['enable_max'] == '0') {
					return;
				}

				$maxproducts = $config['max_product_qty'];
				$maxqty = $config['max_item_qty'];


		        $quote = $observer->getEvent()->getQuote();
		        $products = $quote->getItemsCount();
		        $itemsqty = $quote->getItemsQty();

		        $errormsg = Mage::helper('maxitem')->__('Maximum number of items is: %s and maximum qty of products: %s',$maxproducts,$maxqty);

		        if ($products > $maxproducts || $itemsqty > $maxqty) {

		        	Mage::getSingleton('checkout/session')->addError($errormsg);
		        	Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('checkout/cart'));
		        	Mage::app()->getResponse()->sendResponse();
		        	exit;
		        }


       		}


}
