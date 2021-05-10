<?php
namespace Magepow\Autologin\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Customer
 * @package Vendor\Package\Model\Config\Source
 */

    
class Customer implements OptionSourceInterface

{
    protected $_customerFactory;
     public function __construct(
                                \Magento\Customer\Model\CustomerFactory $customerFactory
    )
    {
        $this->_customerFactory = $customerFactory;
    }
    /**
     * @return array
     */
    public function toOptionArray() : array
     
    {
        $customers = [];
       $customerCollection = $this->_customerFactory->create()->getCollection();
       foreach ($customerCollection as $user) {
         $customers[] = [
             'label' => $user->getEmail(),
                'value' => $user->getId()
         ];

       }
       return $customers;

    }
}