<?php
/**
 * uploading Excel file, parsing it into an array,
 * sorting and assembling resulting data for the DB
 * @author Iuli Dercaci <iuli.dercaci@site-me.info>
 */
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

        if ($this->_request->isPost()){
            $formData = $this->_request->getPost();
            if ($form->isValid($formData)){
                $upload = new Zend_File_Transfer_Adapter_Http();
                try{
                    $upload->receive();
                } catch (Zend_File_Transfer_Exception $e) {
                    echo $e->message();
                }
                //resulting file contents
                $parser = new Excel_Parcer($upload->getFileName('upload'));
                $data = $parser->toArray(true);
                $this->forward('add',null,null,array('data' => $data));
            } else {
                //data is not valid
                $form->populate($formData);
            }
        }
        $this->view->form = $form;
    }

    public function addAction()
    {
        Zend_Debug::dump($this->_request->getParam('data'));
    }


}



