<?php
/**
 * country list with different standards of abbreviations
 * @author: Iuli Dercaci <iuli.dercaci@site-me.info>
 * @data: 11/12/12
 */

class Stopfraud_Action_Helper_CountryAbbr extends Zend_Controller_Action_Helper_Abstract
{

    public function direct($format = 'iso3')
    {
        if (!file_exists(APPLICATION_PATH . '/configs/countries.csv')){
            throw new Exception('countries counfig was not found on a path: '
                . APPLICATION_PATH . '/configs/countries.csv');
        }
        $countriesData   = array();
        $countriesConfig = file(APPLICATION_PATH . '/configs/countries.csv');

        $legend = str_getcsv(array_shift($countriesConfig));
        $countryNameKey = array_search('name', $legend);
        $countryAbbrKey = array_search($format, $legend);

        if(!$countryAbbrKey){
            throw new Exception('Given country abbr format: "' . $format . '" was not found');
        }
        foreach ($countriesConfig as $line){
            $data = str_getcsv($line);
            $countriesData[$data[$countryAbbrKey]] = $data[$countryNameKey];
        }
        return $countriesData;
    }
}
