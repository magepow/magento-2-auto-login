<?php

namespace Magepow\Autologin\Plugin\Customer\Model;

use Magento\Customer\Model\Session;
use Magepow\Autologin\Helper\Data;

class SessionPlugin
{
    
    protected $data;

  
    public function __construct(
       Data $data
    )
    {
        $this->data = $data;
    }

    /**
     * @param Session $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsLoggedIn(Session $subject, bool $result)
    {

        if (!$result && $this->data->getConfigModule('customer/enabled')==1) {
            try {

               $subject->loginById($this->data->getConfigModule('customer/option_customer'));
               return true;
                
            } catch (\Exception $exception) {
             return $result;
            }
        }
        return $result;
    }
        
    
}