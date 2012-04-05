<?php

/**
 * Tabs.php
 * 
 * Class definition file
 * 
 * @author		    Joseph Mastey <joseph.mastey@gmail.com>
 * @author		    $Author$
 * @version		    $Id$
 * @package		    MM
 * @subpackage		CatalogVisibility
 * @copyright		Copyright (c) Joseph Mastey, 2010-
 * @copyright       Licensed under the Creative Commons "Attribution-Noncommercial-Share Alike" License
 *                  http://creativecommons.org/licenses/by-nc-sa/3.0/us/
 */

/**
 * Extra tabs for catalog view
 *
 * @author		    Joseph Mastey <joseph.mastey@gmail.com>
 * @author		    $Author$
 * @package		    MM
 * @subpackage		CatalogVisibility
 * @version		    $Id$
 * @copyright		Copyright (c) Joseph Mastey, 2010-
 * @copyright       Licensed under the Creative Commons "Attribution-Noncommercial-Share Alike" License
 *                  http://creativecommons.org/licenses/by-nc-sa/3.0/us/
 * 
 * @name            MM_CatalogVisibility_Block_Adminhtml_Catalog_Product_Edit_Tabs
 *
 */
class MM_CatalogVisibility_Block_Adminhtml_Catalog_Product_Edit_Tabs extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs {

    protected function _prepareLayout() {
        $ret    = parent::_prepareLayout();
        
        
        $product = $this->getProduct();        
        if($product->getId()) {
            $this->addTab('visibility', array(
                'label'     => Mage::helper('catalogvisibility')->__('Catalog Visibility'),
                'content'   => $this->getLayout()->createBlock('catalogvisibility/product_inventory_view')->setProduct($product)->toHtml(),
            ));
        }
        
        return $ret;
    }//end _prepareLayout

}//class MM_CatalogVisibility_Block_Adminhtml_Catalog_Product_Edit_Tabs