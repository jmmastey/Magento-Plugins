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
 * @copyright       Licensed under the Creative Commons "Attribution-Noncommercial-Share Alike" License
 *                  http://creativecommons.org/licenses/by-nc-sa/3.0/us/
 */

/**
 * We will hack the data out of the database...
 *
 * @author		    Joseph Mastey <joseph.mastey@gmail.com>
 * @author		    $Author$
 * @package		    MM
 * @subpackage		CatalogVisibility
 * @version		    $Id$
 * @copyright		Copyright (c) Mastering Magento, 2010-
 * @copyright       Licensed under the Creative Commons "Attribution-Noncommercial-Share Alike" License
 *                  http://creativecommons.org/licenses/by-nc-sa/3.0/us/
 * 
 * @name            MM_CatalogVisibility_Model_Mysql4_Price
 *
 */
class MM_CatalogVisibility_Model_Mysql4_Price extends Mage_CatalogIndex_Model_Mysql4_Price {

    public function getStorePrices($ids) {
        if (!$ids) {
            return array();
        }
        
        $select = $this->_getReadAdapter()->select();
        $select->from(array('price_table'=>$this->getMainTable()),
            array('price_table.entity_id', 'value'=>"(price_table.price)", 'tax_class_id'=>'(price_table.tax_class_id)'))
            ->where('price_table.entity_id in (?)', $ids);
            
        return $this->_getReadAdapter()->fetchAll($select);
    }//end getStorePrices

}//class MM_CatalogVisibility_Model_Mysql4_Price