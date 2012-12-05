<?php
/**
 * ut_ref_phonecode model
 * @author Iuli Dercaci <iuli.dercaci@site-me.info>
 */
class Application_Model_Phonecode
{
    protected $_ref_phonecodeID;
    protected $_ParentID;
    protected $_Z1;
    protected $_C2;
    protected $_R3;
    protected $_C5;
    protected $_Full_Prefix;
    protected $_Range_Min;
    protected $_Range_Max;
    protected $_Length_Min;
    protected $_Length_Max;
    protected $_ZoneID;
    protected $_Country_A2;
    protected $_Region1_rus;
    protected $_Region1_rom;
    protected $_Region1_eng;
    protected $_Region2_rus;
    protected $_Region2_rom;
    protected $_Region2_eng;
    protected $_City_rus;
    protected $_City_rom;
    protected $_City_eng;
    protected $_Name_rus;
    protected $_Name_rom;
    protected $_Name_eng;
    protected $_TypeID;
    protected $_StartDate;
    protected $_StopDate;
    protected $_ActualDate;
    protected $_LastDate;
    protected $_AddInfo;

    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid phonecode property');
        }
        $this->$method($value);
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid phonecode property');
        }
        return $this->$method();
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

}

