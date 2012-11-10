<?php

class Application_Model_PhonezoneMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Phonezone');
        }
        return $this->_dbTable;
    }

    public function fetchFormSelectOptions(){
        $resultSet = $this->getDbTable()->fetchAll();
        $regions = array();
        foreach ($resultSet as $row){
            $regions[$row->ref_phonezoneID] = $row->Caption_eng;
        }
        return $regions;
    }
}

