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

        if($this->url->getUrl('/')){
        if (!$result && $this->data->getConfigModule('customer/enabled')==1) {
        		
            try {

                return $subject->loginById($this->data->getConfigModule('customer/option_customer'));
                
            } catch (\Exception $exception) {
             $result;
            }
        }
    }else{
        return $result;
    }
        return $result;
    }
}