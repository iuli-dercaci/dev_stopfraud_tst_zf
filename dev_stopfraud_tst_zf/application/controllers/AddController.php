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
    }

    public function indexAction()
    {
        $mapper = new Application_Model_PhonezoneMapper();
        $form = new Application_Form_AddInfo(
            array(
                'regions' => $mapper->fetchFormSelectOptions(),
                'countries' => $this->_helper->CountryAbbr()
            )
        );

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
                $this->forward('save', null, null, array('data' => $parser->toArray(true)));
            } else {
                //data is not valid
                $form->populate($formData);
            }
        }
        $this->view->form = $form;
    }

    public function saveAction()
    {
        $data = $this->_request->getParam('data');
        try {
            $regionId = $this->_request->getPost('region', false);
            $processedData = $this->_helper->{'SortData' . $regionId}($data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $mapper = new Application_Model_PhonecodeMapper();
        $this->vew->message = $mapper->addInfo($processedData);
    }


}



