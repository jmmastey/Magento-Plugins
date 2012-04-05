<?php

/**
 * Price.php
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
 * Check for minimal prices on products
 *
 * @author		    Joseph Mastey <joseph.mastey@gmail.com>
 * @author		    $Author$
 * @package		    MM
 * @subpackage		CatalogVisibility
 * @version		    $Id$
 * @copyright		Copyright (c) Mastering Magento, 2010-
 * 
 * @name            MM_CatalogVisibility_Model_Price
 *
 */
class MM_CatalogVisibility_Model_Price extends Mage_CatalogIndex_Model_Price {

    /**
     * Get the minimal price for a single product
     *
     * @param   catalog/product $product
     */
    public function getProductStorePrice( $product ) {
        $resource   = Mage::getModel("catalogvisibility/mysql4_price");
        
        $prices = $resource->getStorePrices(array($product->getId()));
        if(!$prices) {
            return 0;
        }
        
        return array_shift($prices);
    }//end getProductStorePrice
    
}//class MM_CatalogVisibility_Model_Price
