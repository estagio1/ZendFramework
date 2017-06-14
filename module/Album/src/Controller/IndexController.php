<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $albums = [
            [
                'title' => 'Musica',
                'artist' => 'Artista',
                'id' => 1
            ]
        ];
        return new ViewModel(['albums' => $albums]);
    }

    public function addAction()
    {
        
    }

    public function editAction()
    {
        
    }

    public function deleteAction()
    {
       
    }
}