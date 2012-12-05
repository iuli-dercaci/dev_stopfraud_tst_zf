<?php
/**
 * phone code parser
 * @author: Iuli Dercaci <iuli.dercaci@site-me.info>
 * @data: 03/12/12
 */

class Stopfraud_Action_Helper_DetectPhoneCodes extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * default method of parsing numbers
     * @param $number
     * @return array
     */
    public function direct($number)
    {
        $result = false;
        $defaultData = array(
        'z1' => null,
        'r3' => null,
        'c5' => null,
        'Full_Prefix' => null,
        'Range_Min'   => null,
        'Range_Max'   => null
        );
        $number = preg_replace('/\s/', '', $number);

        if (!strlen($number)){
            return $result;
        }
        //different types of numbers
        if (preg_match('/^\d+[xX]*\d*-\d+[xX]*\d*$/', $number)){ //type 1xxx-3xxx
            $result = $this->twoDigitRange($number);
        } elseif (preg_match('/[xX]+/', $number)){ //type 1xXxXxX
            $result = $this->oneDigitRange($number);
        } elseif (preg_match('/\d+/', $number)){ //type 10000
            $result = $this->simpleDigit($number);
        } else {
            //@todo log error - number was not determined
        }

        return $result + $defaultData;
    }

    /**
     * @param string $number
     * @return bool|mixed
     */
    public function simpleDigit($number){

        $result = false;
        $number = preg_replace('/\D/', '', $number);
        $l = strlen($number);
        if($l){
            //value for column z1
            $result['z1'] = $number[0];
            //value for column r3
            if ($l > 1){
                $result['r3'] = $number[1];
                if(strlen($number > 2)){
                    $result['r3'] .= $number[2];
                }
                //value for column c5
                $rest = substr($number, strlen($result['z1'] . $result['r3']));
                $result['c5'] = strlen($rest) ? $rest : null;
            }
            //value for column Full_Prefix
            $result['Full_Prefix'] = $number;
        }
        return $result;
    }

    /**
     * 1xxx => 1000-1999
     * @param string $number
     * @return null|string
     */
    public function oneDigitRange($number){

        $result = array(
            'Range_Min' => preg_replace('/[xX]/','0', $number),
            'Range_Max' => preg_replace('/[xX]/','9',$number)
        );

        return $result;
    }

    /**
     * 1xxx-2xxx => 1000-2999
     * @param $number
     * @return array|null
     */
    public function twoDigitRange($number){

        $result = null;

        list($start, $end) = explode('-', $number, 2);

        if ($start && $end){
            $start = $this->oneDigitRange($start);
            $end   = $this->oneDigitRange($end);

            if (   isset($start['Range_Min'])
                && strlen($start['Range_Min'])
                && isset($end['Range_Max'])
                && strlen($end['Range_Max']))

                $result = array(
                    'Range_Min' => $start['Range_Min'],
                    'Range_Max' => $end['Range_Max']
                );
        }

        return $result;
    }
}
