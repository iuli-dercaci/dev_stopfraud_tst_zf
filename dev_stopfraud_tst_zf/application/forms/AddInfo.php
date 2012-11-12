<?php
/**
 * uploading Excel file form
 * @author Iuli Dercaci <iuli.dercaci@site-me.info>
 */
class Application_Form_AddInfo extends Zend_Form
{
    protected $_countries = array();
    protected $_regions = array();

    public function init()
    {
        $this->setMethod('post')
            ->setAttrib('enctype', 'multipart/form-data')
            ->addElement('select', 'region', array(
                'label'    => 'Region:',
                'required' => true,
                'multioptions' => $this->getRegions(),
                'class' => 'width-100'
            ))
            ->addElement('select', 'country', array(
                'label'    => 'Country:',
                'required' => true,
                'multioptions' => $this->getCountries(),
                'class' => 'width-100'
            ))
            ->addElement('file', 'upload', array(
                'label' => 'File:',
                'required' => true,
                'validators' => array(array('Count', false, 1), array('Size', false, 102400000), array('Extension', false, 'xls,xlsx,odf,csv')),
                'destination' => APPLICATION_PATH . '/../uploads'
            ))
            ->addElement('submit', 'submit', array(
                'ignore' => true,
                'label'  => 'Submit info'
            ));
    }

    public function setCountries($countryAbbr){
        $this->_countries = $countryAbbr;
    }

    public function getCountries(){
        return $this->_countries;
    }

    public function setRegions($regions) {
        $this->_regions = $regions;
    }

    public function getRegions() {
        return $this->_regions;
    }

}

