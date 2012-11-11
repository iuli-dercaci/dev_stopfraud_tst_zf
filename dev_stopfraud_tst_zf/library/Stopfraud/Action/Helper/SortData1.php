<?php
/**
 * the data for America
 * @author: Iuli Dercaci <iuli.dercaci@site-me.info>
 * @data: 11/12/12
 */

class Stopfraud_Action_Helper_SortData1 extends Zend_Controller_Action_Helper_Abstract
{
    //@todo
    public function direct(array $data)
    {
        if (false === ($region = $this->getRequest()->getPost('regions', false))){
            throw new Exception('region ID was not found');
        }
        $structure_id = $this->_getRegionId($region);
        $parsed_data = array();
        foreach ($data as $line) {
            $line_data = array();
            if ((int)$line[0]){// line has id
                $line_data['ParentID'] = $structure_id;
                $zones_pattern = '/(?<z1>\d)\D?(?<r3>\d{2})\D*(?<c5>\d*)/';
                if (false != ($numbers = preg_match($zones_pattern, $line[1], $m))){
                    $line_data['z1'] = $m['z1'];
                    $line_data['r3'] = $m['r3'];
                    $line_data['c5'] = $m['c5'];
                }
                $line_data['Full_Prefix'] = preg_replace('/\D/', '', $line[1]);
                $line_data['ZoneID'] = $region;
                $line_data['Region1_rus'] = $line_data['Region1_rom'] = $line_data['Region1_eng'] = $line[4];
                $line_data['City_rus'] = $line_data['City_rom'] = $line_data['City_eng'] = $line[2];
                $line_data['Name_rus'] = $line_data['Name_rom'] = $line_data['Name_eng'] = $line[3];
                $line_data['TypeID'] = $this->_getPhoneType($line[5]);
            }
            if (!empty($line_data)){
                $parsed_data[] = $line_data;
            }
        }
        return $data;
    }

    /**
     * @todo move to parent class
     * getting ParentId value by zone id
     * @param int $zoneId
     * @return string
     */
    private function _getRegionId($zoneId)
    {
        $mapper = new Application_Model_StructureMapper();
        return $mapper->getRegionIdByZoneId($zoneId);
    }
    //@todo
    private function _getPhoneType($name){
        /*$name = trim(strtolower($name));
        $result = 'Unknown';
        if(isset($this->_config['phone_types'][$name])){
            $result = $this->_config['phone_types'][$name];
        }
        return $result;*/
    }
}
