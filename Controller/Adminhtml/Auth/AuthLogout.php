<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magepow\Autologin\Controller\Adminhtml\Auth;

class AuthLogout extends \Magento\Backend\Controller\Adminhtml\Auth\Logout
{
    /**
     * Administrator logout action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $this->_auth->logout();
        $this->messageManager->addSuccessMessage(__('The loged in admin have remained'));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath($this->_helper->getHomePageUrl());
    }
}