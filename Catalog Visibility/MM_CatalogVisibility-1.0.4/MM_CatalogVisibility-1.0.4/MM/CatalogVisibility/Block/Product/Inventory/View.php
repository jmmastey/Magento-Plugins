<?php

/**
 * View.php
 * 
 * Class definition file
 * 
 * @author		    Joseph Mastey <joseph.mastey@gmail.com>
 * @author		    $Author$
 * @version		    $Id$
 * @package		    MM
 * @subpackage		CatalogVisibility
 * @copyright		Copyright (c) Joseph Mastey, 2010-
 */

/**
 * Rendered view for product inventory troubles.
 *
 * @author		    Joseph Mastey <joseph.mastey@gmail.com>
 * @author		    $Author$
 * @package		    MM
 * @subpackage		CatalogVisibility
 * @version		    $Id$
 * @copyright		Copyright (c) Joseph Mastey, 2010-
 * 
 * @name            MM_CatalogVisibility_Block_Product_Inventory_View
 *
 */
class MM_CatalogVisibility_Block_Product_Inventory_View extends Mage_Core_Block_Template {

    /**
     * Construct and preset some information.
     *
     */
    public function __construct() {
        $this->setTemplate("catalogvisibility/view.phtml");
        $this->setAdvice(array());
    }//end __construct
    
    /**
     * Add more things to let the user know about.
     *
     * @param   mixed  $advice
     */
    public function addAdvice( $advice ) {
        if(!is_array($advice)) {
            $advice = array($advice);
        }
        
        foreach($advice as $idx => $item) {
            $advice[$idx]   = $this->__($item);
        }
        
        $this->setAdvice(array_merge($this->getAdvice(),$advice));
    }//end addAdvice

    /**
     * Check to see whether the product is visible
     *
     * @param   catalog/product $product
     */
    public function isVisible( $product ) {
        switch($product->getVisibility()) {
            case Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE:
                return false;
            default:
                return true;
        }
    }//end isVisible

    /**
     * Check to see whether the product is visible in the catalog
     *
     * @param   catalog/product $product
     */
    public function isVisibleInCatalog( $product ) {
        switch($product->getVisibility()) {
            case Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG:
            case Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH:
                return true;
            default:
                return false;
        }
    }//end isVisibleInCatalog
    
    /**
     * Is the product enabled in the catalog?
     *
     */
    public function isEnabled( $product ) {
        return $product->getStatus() == Mage_Catalog_Model_Product_Status::STATUS_ENABLED;
    }//end isEnabled
    
    /**
     * Is the product marked as "In Stock"?
     *
     * @param   catalog/product $product
     */
    public function isInStock( $product ) {
        return (int)$product->getStockItem()->getIsInStock();
    }//end isInStock
    
    /**
     * Does the product have any qty in stock?
     *
     * @param   catalog/product $product
     */
    public function hasQty( $product ) {
        if(0 != strcmp("simple", $product->getTypeId())) {
            return true;
        }
        
        return (int)$product->getStockItem()->getQty() > $this->getMinQty($product);
    }//end hasQty
    
    /**
     * Get the minimum quantity to add to the cart for users.
     *
     * @param   catalog/product $product
     */
    public function getMinQty( $product ) {
        return $product->getStockItem()->getMinQty();
    }//end getMinQty
    
    /**
     * Check to see whether backorders are allowed.
     *
     * @param   catalog/product $product
     */
    public function allowsBackorders( $product ) {
        return $product->getStockItem()->getBackorders();
    }//end allowsBackorders
    
    /**
     * Is stock managed?
     *
     * @param   catalog/product $product
     */
    public function stockIsManaged( $product ) {
        return $product->getStockItem()->getManageStock();
    }//end stockIsManaged
    
    /**
     * Is the product in any categories? Yes, then return them.
     *
     * @param   catalog/product $product
     */
    public function getCategories( $product ) {
        return $product->getCategoryCollection()->addNameToResult();
    }//end getCategories
    
    /**
     * Get any websites for which the product is active.
     *
     * @param   catalog/product $product
     */
    public function getWebsites( $product ) {
        $ids    = $product->getWebsiteIds();
        if(!count($ids)) {
            return array();
        }
        
        foreach($ids as $index => $id) {
            $site           = Mage::getModel("core/website")->load($id);
            $ids[$index]    = $site->getName();
        }
        
        return $ids;
    }//end getWebsites
    
    /**
     * Can we add to the cart?
     *
     * @param   catalog/product $product
     */
    public function isSalable( $product ) {
        Mage::app()->setCurrentStore(1);

        // reset
        $websiteId  = 1;
        $status     = Mage::getSingleton("cataloginventory/stock_status");
        $statuses   = $status->getProductStatus($product->getId(), $websiteId, 1);
        
        $salable    = isset($statuses[$product->getId()])?$statuses[$product->getId()]:null;
        $product->setIsSalable($salable);

        return $product->isSalable();
    }//end isSalable
    
    /**
     * Does the configurable product have child products?
     *
     * @param   catalog/product $product
     */
    public function hasValidChildProducts( $product ) {
        if(0 !== strcmp("configurable", $product->getTypeId())) {
            return true;
        }
        
        $children   = $product->getTypeInstance(true)->getUsedProductCollection($product);
        if(count($children)) {
            return true;
        }
        
        return false;
    }//end hasValidChildProducts
    
    /**
     * Is there a price in the price indices? This will probably be confusing later on...
     *
     * @param   catalog/product $product
     */
    public function hasMinimalPrice( $product ) {
        Mage::app()->setCurrentStore(1);
        $priceModel = Mage::getModel("catalogvisibility/price");
        
        $price      = $priceModel->getProductStorePrice($product);
        if($price) {
            return true;
        }
        
        return false;
    }//end hasMinimalPrice
    
}//class MM_CatalogVisibility_Block_Product_Inventory_View