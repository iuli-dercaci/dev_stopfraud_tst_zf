<?php
/**
 * the data for America
 * @author: Iuli Dercaci <iuli.dercaci@site-me.info>
 * @data: 11/12/12
 */

class Stopfraud_Action_Helper_SortData1 extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * assembling the data for inserting into the DB
     * @param array $data
     * @return array
     * @throws Exception
     */
    public function direct(array $data)
    {
        if (false === ($region = $this->getRequest()->getPost('region', false))){
            throw new Exception('region ID was not found');
        }
        if (false === ($country = $this->getRequest()->getPost('country', false))){
            throw new Exception('region ID was not found');
        }
        $structure_id = $this->_getRegionId($region);
        $parsed_data = array();

        $codeDetector = $this->getActionController()->getHelper('DetectPhoneCodes');//phone code parser
        foreach ($data as $line) {
            $line_data = array();

            if ((int)$line[0]){// line has id

                $line_data['ParentID'] = $structure_id;
                $line_data['Country_A2'] = $country;
                $line_data['ZoneID'] = $region;
                $line_data['Region1_rus'] = $line_data['Region1_rom'] = $line_data['Region1_eng'] = $line[4];
                $line_data['City_rus'] = $line_data['City_rom'] = $line_data['City_eng'] = $line[2];
                $line_data['Name_rus'] = $line_data['Name_rom'] = $line_data['Name_eng'] = $line[3];
                $line_data['TypeID'] = $this->_getPhoneType($line[5]);

                //detect number related data
                $line_data += $codeDetector->direct($line[1]);
                Zend_Debug::dump($line_data);
                exit;
            }
            if (!empty($line_data)){
                $parsed_data[] = $line_data;
            }
        }
        return $parsed_data;
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

    /**
     * getting phone type abbreviation
     * @param string $name
     * @return string
     */
    private function _getPhoneType($name){
        $name = ucfirst(trim($name));
        $types = array(
            'LL' => 'Landline',
            'MB' => 'Cell Number',
            'GS' => '',
            'VO' => '',
            'UK' => 'Unknown',
            'NC' => '',
            'RC' => ''
        );
        if (false === ($type = array_search($name, $types))){
            $type = 'UK';
        }
        return $type;
    }
}
