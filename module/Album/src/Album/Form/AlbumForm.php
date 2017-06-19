<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Album\Form;

use Zend\Form\Form;

use Zend\Form\Element\Text;
use Zend\Form\Element\Button;

use Album\Form\AlbumFilter;

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
        //Botao submit
        $button = new Button('Submit');
        $button->setLabel("Salvar")
            ->setAttributes([
                'type' => 'submit',
                'class' => 'btn'
            ]);
        $this->add($button);
    }
}
