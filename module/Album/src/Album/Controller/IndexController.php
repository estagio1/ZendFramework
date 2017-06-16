<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Service\AlbumService;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $albumService = new AlbumService(
                    $this->getEvent()->getApplication()->getServiceManager());
        
        $list = $albumService->buscarTodos();
//        die;
        
        return new ViewModel(['albums' => $list]);
    }

    public function addAction()
    {
//        $albumService = new \Album\Sevice\AlbumService(
//        $this->getEvent()->getApplication()->getServiceManager());
        return new ViewModel();
    }

    public function editAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        return new ViewModel();
    }
}