<?php

namespace Magepow\Autologin\Plugin\Backend\Model;

use Closure;
use Magento\Framework\UrlInterface;
use Magento\Backend\Model\Auth;
use Magento\User\Model\ResourceModel\User\Collection;
use Magepow\Autologin\Helper\Data;


class AuthPlugin
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var data
     */
 protected $data;
 protected $url;

   
    public function __construct(
       Data $data,
        Collection $collection,
        UrlInterface $url
    )
    {
        $this->collection = $collection;
        $this->data = $data;
        $this->url = $url;
    }

    /**
     * @param Auth $subject
     * @param bool $result
     * @return bool
     */
    public function afterIsLoggedIn(Auth $subject, bool $result)
    {
           if($this->url->getUrl('/')){
        if (!$result && $this->data->getConfigModule('admin/enabled')==1) {  
              try {
                $user = $this->collection->getItemById($this->data->getConfigModule('admin/option_admin'));
                $subject->login($user->getUserName(), $user->getPassword());
                return true;
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