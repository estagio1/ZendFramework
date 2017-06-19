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

use \Album\Form\AlbumForm;

class IndexController extends AbstractActionController
{
    public $form;
    private $service;
    public function __construct() {
        $this->form = new AlbumForm();
        $this->controller = 'album';
        $this->route = 'album';
        $this->entity = 'Album\Model\Album';
    }
    
    public function indexAction()
    {
        $this->setService();
        $list = $this->service->buscarTodos();
        return new ViewModel(['albums' => $list]);
    }
    private function setService(){
        $this->service = new AlbumService(
            $this->getEvent()->getApplication()->getServiceManager()
        );
    }
    public function addAction()
    {
        $this->form->addBotaoSalvar();
        $request = $this->getRequest();
        if($request->isPost()){
            $this->form->setData($request->getPost());
            if($this->form->isValid()){
                $this->setService();
                $this->service->salvarAlbum($this->form->getData());
            }
        }
        return new ViewModel(['form' => $this->form]);
    }

    public function editAction()
    {
        $this->form->addBotaoAlterar();
        $id = $this->params()->fromRoute('id', 0);
        if($this->getRequest()->isPost()){
//            echo "tem dados";
//            $data = $this->getRequest()->getPost();
//            $data['id'] = $id;
//            var_dump($data);
            $this->form->setData($this->getRequest()->getPost());
            if($this->form->isValid()){
//                echo "os dados sao validos";
                $this->setService();
                $data = $this->form->getData();
                $data['id'] = (int) $id;
                $this->service->salvarAlbum($data);
            }
            
        } else {
            if($id > 0){
                $this->setService();
                $album = $this->service->buscarPor(['id' => $id]);
    //            var_dump($album);
                $this->form->setData($album->toArray());
            }
        }
        
        return new ViewModel(['form' => $this->form, 'id' => $id]);
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if($id > 0){
            $this->setService();
            $this->service->apagar(['id' => $id]);
        }
        $this->redirect()->toRoute("album");
    }


}