<?php

/**
 * Instance.php
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
 * Override to allow smarter send.
 *
 * @author      Joseph Mastey <joseph.mastey@gmail.com>
 * @author      $Author$
 * @package     MM
 * @subpackage  TrulySimpleGmail
 * @version     $Id$
 * @copyright	Copyright (c) 2010 Joseph Mastey <joseph.mastey@gmail.com>
 * 
 * @name        MM_TrulySimpleGmail_Model_Email_Instance
 *
 */
class MM_TrulySimpleGmail_Model_Email_Instance extends Zend_Mail {

    // if a transport is already defined, use that. otherwise, use
    // this module to transport over gmail.
    public function send($transport = null) {
        if($transport) {
            return parent::send($transport);
        }

        return Mage::helper("trulysimplegmail")->send($this);
    }

    public function sendParent($transport = null) {
        return parent::send($transport);
    }
  
}//class MM_TrulySimpleGmail_Model_Email_Instance
