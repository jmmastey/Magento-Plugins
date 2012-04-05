<?php

/**
 * Template.php
 * 
 * Class definition file
 * 
 * @author      Joseph Mastey <joseph.mastey@gmail.com>
 * @author      $Author$
 * @version     $Id$
 * @package     MM
 * @subpackage  TrulySimpleGmail
 * @copyright	Copyright (c) 2010 Joseph Mastey <joseph.mastey@gmail.com>
 */

/**
 * Override w/ gmail as a sendmail transport
 *
 * @author      Joseph Mastey <joseph.mastey@gmail.com>
 * @author      $Author$
 * @package     MM
 * @subpackage  TrulySimpleGmail
 * @version     $Id$
 * @copyright	Copyright (c) 2010 Joseph Mastey <joseph.mastey@gmail.com>
 * 
 * @name        MM_TrulySimpleGmail_Model_Email_Template
 *
 */
class MM_TrulySimpleGmail_Model_Email_Template extends Mage_Core_Model_Email_Template {

    /**
     * Retrieve mail object instance. Use one of ours instead and override 
     * the send method to be sneaky.
     *
     * @return Zend_Mail
     */
    public function getMail() {
        if (is_null($this->_mail)) {
            $this->_mail = new MM_TrulySimpleGmail_Model_Email_Instance('utf-8');
        }
        return $this->_mail;
    }
  
}//class MM_TrulySimpleGmail_Model_Email_Template
