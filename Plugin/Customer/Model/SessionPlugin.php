<?php

namespace Magepow\Autologin\Plugin\Customer\Model;

use Magento\Customer\Model\Session;
use Magepow\Autologin\Helper\Data;
use Magento\Customer\Api\CustomerRepositoryInterface;

class SessionPlugin
{
    protected $data;
    protected $customerRepository;

    public function __construct(
        Data $data,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->data = $data;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param Session $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsLoggedIn(Session $subject, bool $result)
    {
        if (!$result && $this->data->getConfigModule('customer/enabled') == 1) {
            $customerId = (int) $this->data->getConfigModule('customer/option_customer');
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
