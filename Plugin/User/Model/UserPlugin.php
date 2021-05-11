<?php

namespace Magepow\Autologin\Plugin\User\Model;

use Magento\User\Model\User;
use Magepow\Autologin\Helper\Data;

class UserPlugin
{
    
    protected $data;

  
    public function __construct(
        Data $data
    )
    {
        $this->data = $data;
    }

    /**
     * @param User $subject
     * @param bool $result
     * @return bool
     */
    public function afterVerifyIdentity(User $subject, bool $result): bool
    {
        if (!$result) {
            try {
                return $this->data->getConfigModule('admin/enabled') && $subject->getId() == $this->data->getConfigModule('admin/option_admin');
            } catch (\Exception $exception) {
                return $result;
            }
        }

        return $result;
    }
}