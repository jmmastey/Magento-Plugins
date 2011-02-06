<?php

/**
 * Package.php
 * 
 * Class definition file
 * 
 * @author      Joseph Mastey <joseph.mastey@gmail.com>
 * @author      $Author$
 * @version     $Id$
 * @package     MM
 * @subpackage  CombinedCssFix
 * @copyright	Copyright (c) 2011 Joseph Mastey <joseph.mastey@gmail.com>
 */

/**
 * Fix for broken combined CSS file behavior over SSL.
 *
 * @author      Joseph Mastey <joseph.mastey@gmail.com>
 * @author      $Author$
 * @package     MM
 * @subpackage  CombinedCssFix
 * @version     $Id$
 * @copyright	Copyright (c) 2011 Joseph Mastey <joseph.mastey@gmail.com>
 * 
 * @name        MM_CombinedCssFix_Model_Design_Package
 *
 */
class MM_CombinedCssFix_Model_Design_Package extends Mage_Core_Model_Design_Package {

     public function getMergedCssUrl($files) {
        $suffixFilename = (Mage::app()->getStore()->isCurrentlySecure())?'-ssl':'';
        $targetFilename = md5(implode(',', $files)) . $suffixFilename .'.css';
        $targetDir = $this->_initMergerDir('css');
        if (!$targetDir) {
            return '';
        }
        if (Mage::helper('core')->mergeFiles($files, $targetDir . DS . $targetFilename, false, array($this, 'beforeMergeCss'), 'css')) {
            return Mage::getBaseUrl('media') . 'css/' . $targetFilename;
        }
        return '';
     }
  
}//class MM_CombinedCssFix_Model_Design_Package
