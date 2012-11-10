<?php

class AddController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $mapper = new Application_Model_PhonezoneMapper();
        $form = new Application_Form_AddInfo(array('regions' => $mapper->fetchFormSelectOptions()));

        $this->view->form = $form;
    }

    public function addAction()
    {
        // action body
    }


}



