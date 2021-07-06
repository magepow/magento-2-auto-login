<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magepow\Autologin\Controller\Adminhtml\Auth;
use Magepow\Autologin\Helper\Data;
use \Magento\Backend\App\Action\Context;
class AuthLogout extends \Magento\Backend\Controller\Adminhtml\Auth\Logout
{
	protected $data;
	protected $context;
    /**
     * Administrator logout action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    
     public function __construct( 
     	Context $context,
       Data $data
         
    ){
    	  parent::__construct($context,$data);
     	$this->data = $data;
     	$this->context = $context;
     }

    public function execute()
    {

        $this->_auth->logout();
        if($this->data->getConfigModule('admin/enabled') == 0){
        	  $this->messageManager->addSuccessMessage(__('You have logged out.'));
        }else{

        $this->messageManager->addSuccessMessage(__('The loged in admin have remained'));
    }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath($this->_helper->getHomePageUrl());
    }
}