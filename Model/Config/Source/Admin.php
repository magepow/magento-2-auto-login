<?php
namespace Magepow\Autologin\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Customer
 * @package Vendor\Package\Model\Config\Source
 */

    
class Admin implements OptionSourceInterface

{
    protected $_userFactory;
     public function __construct(
                                \Magento\User\Model\ResourceModel\User\CollectionFactory $userCollectionFactory
    )
    {
        $this->_userFactory = $userCollectionFactory;
    }
    /**
     * @return array
     */
    public function toOptionArray() : array
     
    {
        $admins = [];
       $adminCollection = $this->_userFactory->create();
       foreach ($adminCollection as $adminUser) {
         $admins[] = [
             'label' => $adminUser->getEmail(),
                'value' => $adminUser->getId()
         ];

       }
       return $admins;

    }
}