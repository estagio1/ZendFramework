<?php
namespace Album\Form;

use Zend\Form\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;


class AlbumForm extends Form{
    //put your code here
    
    
    public function __construct() {
        parent::__construct(null);
        $this->setAttribute('method', 'POST');
        $this->setInputFilter(new AlbumFilter());
        
        
        //Input artist
        $artist = new Text('artist');
        $artist->setLabel('Artist:')->setAttributes([
            'maxlength' => 100
        ]);
        $this->add($artist);
        //Input title
        $title = new Text('title');
        $title->setLabel('Title:')->setAttributes([
            'maxlength' => 100
        ]);
        $this->add($title);
        
    }
    public function addBotaoSalvar(){
        //Botao submit
        $button = new Button('Submit');
        $button->setLabel("Salvar")
            ->setAttributes([
                'type' => 'submit',
                'class' => 'btn'
            ]);
        $this->add($button);
    }
    public function addBotaoAlterar(){
        //Botao submit
        $button = new Button('Submit');
        $button->setLabel("Alterar")
            ->setAttributes([
                'type' => 'submit',
                'class' => 'btn'
            ]);
        $this->add($button);
    }
}
