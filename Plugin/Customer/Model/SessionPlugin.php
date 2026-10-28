<?php

namespace Magepow\Autologin\Plugin\Customer\Model;

use Magento\Customer\Model\Session;
use Magepow\Autologin\Helper\Data;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;

class SessionPlugin
{
    protected $data;
    protected $customerRepository;
    protected $customerFactory;

    public function __construct(
        Data $data,
        CustomerRepositoryInterface $customerRepository,
        CustomerFactory $customerFactory
    ) {
        $this->data = $data;
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
    }

    /**
     * @param Session $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsLoggedIn(Session $subject, bool $result)
    {
        if (!$result && $this->data->getConfigModule('customer/enabled') == 1) {
            $autoLoginFirst = (int) $this->data->getConfigModule('customer/auto_login_first');
            if ($autoLoginFirst === 1) {
                $collection = $this->customerFactory->create()->getCollection()->setPageSize(1)->setCurPage(1);
                $first = $collection->getFirstItem();
                $customerId = (int) $first->getId();
            } else {
                $customerId = (int) $this->data->getConfigModule('customer/option_customer');
            }
            if ($customerId <= 0) {
                return $result;
            }
            try {
                // Verify the configured customer actually exists before logging in
                $this->customerRepository->getById($customerId);
                $subject->loginById($customerId);
                return true;
            } catch (\Exception $exception) {
                return $result;
            }
        }
        return $result;
    }
}
