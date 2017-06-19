<?php
namespace Album\Form;

use \Zend\Filter\StringTrim;
use \Zend\Filter\StripTags;

use \Zend\InputFilter\InputFilter;
use \Zend\InputFilter\Input;

use \Zend\Validator\NotEmpty;
class AlbumFilter extends InputFilter{
    
    public function __construct() {
        $artist = new Input('artist');
        $artist->setRequired(true)
            ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
        $artist->getValidatorChain()->attach(new NotEmpty());
        $this->add($artist);
    }
}
