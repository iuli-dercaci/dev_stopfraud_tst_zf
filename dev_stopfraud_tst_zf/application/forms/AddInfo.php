<?php

class Application_Form_AddInfo extends Zend_Form
{
    protected $_regions = array();

    public function init()
    {
        $this->setMethod('post');
        $this->addElement('select', 'regions', array(
            'label'    => 'Region:',
            'required' => true,
            'multioptions' => $this->getRegions()
        ));
        $this->addElement('file', 'upload', array(
            'label' => 'File:',
            'required' => true,
            'validators' => array(array('Count', false, 1), array('Size', false, 102400), array('Extension', false, 'xls,odt'))
//            'destination' => $this->directory,

        ));
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label'  => 'Submit info'
        ));
        $this->addElement('hash', 'csrf', array(
            'ignore' => true
        ));
    }

    public function setRegions($regions) {
        $this->_regions = $regions;
    }

    public function getRegions() {
        return $this->_regions;
    }

}

