<?php
/**
 * PHPExcel lib wrapper
 * @author Iuli Dercaci <iuli.dercaci@site-me.info>
 */
include_once APPLICATION_PATH . '/../library/Excel/lib/PHPExcel/PHPExcel.php';

class Excel_Parcer
{
    private $_file = false;

    public function __construct($fileName){
        $this->_file = $fileName;
    }

    public function toArray($remove = false){
        $PHPExcel = PHPExcel_IOFactory::load($this->_file);
        if ($remove){
            unlink($this->_file);
        }
        return $PHPExcel->getActiveSheet()->toArray();
    }
}