<?php

/**
 * Email.php
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
 * @name        MM_TrulySimpleGmail_Model_Email
 *
 */
class MM_TrulySimpleGmail_Model_Email extends Mage_Core_Model_Email {

    // send email. identical to parent except for the send() call
    public function send() {
        if (Mage::getStoreConfigFlag('system/smtp/disable')) {
            return $this;
        }

        $mail = new Zend_Mail();

        if (strtolower($this->getType()) == 'html') {
            $mail->setBodyHtml($this->getBody());
        }
        else {
            $mail->setBodyText($this->getBody());
        }

        $mail->setFrom($this->getFromEmail(), $this->getFromName())
            ->addTo($this->getToEmail(), $this->getToName())
            ->setSubject($this->getSubject());
        Mage::helper("trulysimplegmail")->send();

        return $this;
    } 

}//class MM_TrulySimpleGmail_Model_Email
