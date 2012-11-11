<?php
/**
 * @author Iuli Dercaci <iuli.dercaci@site-me.info>
 */
class Application_Model_StructureMapper
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
            $this->setDbTable('Application_Model_DbTable_Structure');
        }
        return $this->_dbTable;
    }

    public function getRegionIdByZoneId($id){
        $resultSet =
            $this->getDbTable()->fetchRow(
                $this->getDbTable()
                    ->select(array('ParentID'))
                    ->where(new Zend_Db_Expr('FolderName REGEXP "(Zone ' . $this->getDbTable()->getAdapter()->quote((int)$id) . ').*"'))
                    ->limit(1, 0)
            );
        if (!isset($resultSet->ParentID)){
            throw new Exception('Region Id for Zone Id ' . (int)$id . ' was not found');
        }
        return $resultSet->ParentID;
    }
}