<?php

namespace Magepow\Autologin\Plugin\Backend\Model;

use Closure;
use Magento\Backend\Model\Auth;

class AuthPlugin
{
    /**
     * @var Magento\User\Model\ResourceModel\User\Collection
     */
    protected $collection;

    /**
     * @var data
    */
    protected $data;
    protected $request;
    protected $url;

   
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\UrlInterface $url,
        \Magento\User\Model\ResourceModel\User\Collection $collection,
        \Magepow\Autologin\Helper\Data $data,
    )
    {
        $this->collection = $collection;
        $this->data       = $data;
        $this->request    = $request;
        $this->url        = $url;
    }

    /**
     * @param Auth $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsLoggedIn(Auth $subject, bool $result)
    {
        $autlLogin = $this->request->getParam('autologin', 1);
        if($this->url->getUrl('/')){
            if (!$result && $this->data->getConfigModule('admin/enabled')==1) {  
                  try {
                    $user = $this->collection->getItemById($this->data->getConfigModule('admin/option_admin'));
                    if($user){
                        return $autlLogin ? $subject->login($user->getUserName(), $user->getPassword()) : $subject->logout();
                    }else{
                        return $result;
                    }
                } catch (\Exception $exception) {
                    return $result;
                }

            }         
        }else{
            return $result;
        }

        return $result;
    }

    
    public function aroundLogout(Auth $subject, Closure $proceed)
    {
        if ($this->data->getConfigModule('admin/enabled')==1) {
            return false;
        }
        return $proceed();
    }
}