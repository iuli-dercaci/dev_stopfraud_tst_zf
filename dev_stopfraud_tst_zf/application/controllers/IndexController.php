<?php
/**
 * landing page
 * @author Iuli Dercaci <iuli.dercaci@site-me.info>
 */

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $mapper = new Application_Model_StructureMapper();
        Zend_Debug::dump($mapper->getRegionIdByZoneId(1));
    }


}

