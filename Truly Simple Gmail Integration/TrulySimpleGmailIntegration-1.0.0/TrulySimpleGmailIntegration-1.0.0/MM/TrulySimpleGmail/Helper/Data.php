<?php

/**
 * Data.php
 * 
 * Class definition file
 * 
 * @author  	Joseph Mastey <joseph.mastey@gmail.com>
 * @author  	$Author$
 * @version  	$Id$
 * @package  	MM
 * @subpackage  TrulySimpleGmail
 * @copyright   Copyright (c) 2010 Joseph Mastey <joseph.mastey@gmail.com>
 */

/**
 * Basic helper. Nothing to see here.
 *
 * @author  	Joseph Mastey <joseph.mastey@gmail.com>
 * @author  	$Author$
 * @package     MM
 * @subpackage  TrulySimpleGmail
 * @version  	$Id$
 * @copyright   Copyright (c) 2010 Joseph Mastey <joseph.mastey@gmail.com>
 * 
 * @name  		MM_TrulySimpleGmail_Helper_Data
 *
 */
class MM_TrulySimpleGmail_Helper_Data extends Mage_Core_Helper_Abstract {

    public function send( Zend_Mail $mail ) {
        // our overridden version will recurse infinitely unless we're careful
        if($mail instanceof MM_TrulySimpleGmail_Model_Email_Instance) {
            $sendMethod = "sendParent";
        } else {
            $sendMethod = "send";
        }

        if(!$this->sendingIsEnabled()) {
            return $mail->$sendMethod();
        }

        $config     = $this->getMailConfiguration();
        $transport  = new Zend_Mail_Transport_Smtp((string)Mage::getConfig()->getNode("trulysimplegmail/host"), $config);

        return $mail->$sendMethod($transport);
    }

    public function getMailConfiguration() {
        $config     = Mage::getConfig();
        $mailConfig = array(
            'ssl'       => (string)$config->getNode("trulysimplegmail/ssl"),
            'port'      => (int)$config->getNode("trulysimplegmail/port"),
            'auth'      => (string)$config->getNode("trulysimplegmail/auth"),
            'username'  => (string)Mage::getStoreConfig("email_delivery/gmail/username"),
            'password'  => Mage::helper("core")->getEncryptor()->decrypt(Mage::getStoreConfig("email_delivery/gmail/password")),
        );

        return $mailConfig;
    }

    public function sendingIsEnabled() {
        return (int)Mage::getStoreConfig("email_delivery/gmail/enable");
    }

}//class MM_TrulySimpleGmail_Helper_Data
