<?php

namespace PluginMaster\Validator\utilities;
/**
 * 
 */
class ValidateManager
{


    protected $validateStatus;
    protected static $message;


    public function checkRequired($options)
    {

        trim($options['data']) ? $this->validateStatus = true : $this->setError($options,  ' is required');
    }


    public function checkNumber($options)
    {
        preg_match("/^[0-9]*$/", $options['data']) ? $this->validateStatus = true : $this->setError($options,  ' must be  number');
    }

    public function checkFloatNumber($options)
    {
        preg_match("/\-?\d+\.\d+/", $options['data']) ? $this->validateStatus = true : $this->setError($options,  ' must be  float number');
    }


    public function checkNoNumber($options)
    {
        preg_match("/^([^0-9]*)$/", $options['data']) ? $this->validateStatus = true : $this->setError($options,  ' must not be  number');
    }

    public function checkLetter($options)
    {
        preg_match('/^.{' . $options['limit'] . '}$/', $options['data']) ? $this->validateStatus = true : $this->setError($options,  ' must be  letter(A-Z,a-z)');
    }

    public function checkNoSpecialChar($options)
    {
        !preg_match('/[`~!@#$%^&*()_|+\-=?;:\'",.<>\{\}\/]/', $options['data']) ? $this->validateStatus = true : $this->setError($options,  ' must be  letter(A-Z,a-z)');
    }


    public function checkLimit($options)
    {
        if (preg_match('/^.{' . $options['limit'] . '}$/', $options['data'])) {
            $this->validateStatus = true;
        } else {
            $limits = explode(',', $options['limit']);
            $this->setError($options,  ' must be between  ' . $limits[0] . ' and ' . $limits[1]);
        }
    }

    public function checkWordLimit($options)
    {
        $word = explode(" ", $options['data']);
        $limits = explode(",", $options['limit']);
        (count($word) > $limits[0] && count($word) < $limits[1]) ? $this->validateStatus = true : $this->setError($options,  ' must be between  ' . $limits[0] . ' and ' . $limits[1]);
    }

    public function checkEmail($options)
    {
        preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $options['data']) ? $this->validateStatus = true : $this->setError($options, ' must be an email');
    }


    protected function setError($field, $message)
    {
        self::$message[$field['fieldName']] = isset(self::$message[$field['fieldName']]) ? self::$message[$field['fieldName']] . ', ' . $message : $field['fieldName'] . $message;
    }
}
