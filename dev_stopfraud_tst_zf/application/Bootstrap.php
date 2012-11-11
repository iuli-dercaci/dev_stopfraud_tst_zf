<?php
/**
 * framework bootstrap
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
    }

    protected function _initAutoload()
    {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('Excel_');
    }

    protected function _initHelpers()
    {
        Zend_Controller_Action_HelperBroker::addPrefix('Stopfraud_Action_Helper');
    }
}

