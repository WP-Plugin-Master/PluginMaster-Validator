<?php

namespace PluginMaster\Validator\utilities;

class ValidateManager
{


    protected $validateStatus;
    protected $message;


    /**
     * @param $options
     */
    public function checkRequired($options)
    {
        trim($options['data']) ? $this->validateStatus = true : $this->setError($options, ' is required');
    }

    /**
     * @param $field
     * @param $message
     */
    protected function setError($field, $message)
    {
        $this->message[$field['fieldName']] = isset($this->message[$field['fieldName']]) ? $this->message[$field['fieldName']] . ', ' . $message : $field['fieldName'] . $message;
    }

    /**
     * @param $options
     */
    public function checkNumber($options)
    {
        preg_match("/^[0-9]*$/", $options['data']) ? $this->validateStatus = true : $this->setError($options, ' must be  number');
    }

    /**
     * @param $options
     */
    public function checkFloatNumber($options)
    {
        preg_match("/\-?\d+\.\d+/", $options['data']) ? $this->validateStatus = true : $this->setError($options, ' must be  float number');
    }

    /**
     * @param $options
     */
    public function checkNoNumber($options)
    {
        preg_match("/^([^0-9]*)$/", $options['data']) ? $this->validateStatus = true : $this->setError($options, ' must not be  number');
    }

    /**
     * @param $options
     */
    public function checkLetter($options)
    {
        preg_match('/^.{' . $options['limit'] . '}$/', $options['data']) ? $this->validateStatus = true : $this->setError($options, ' must be  letter(A-Z,a-z)');
    }

    /**
     * @param $options
     */
    public function checkNoSpecialChar($options)
    {
        !preg_match('/[`~!@#$%^&*()_|+\-=?;:\'",.<>\{\}\/]/', $options['data']) ? $this->validateStatus = true : $this->setError($options, ' must be  letter(A-Z,a-z)');
    }

    /**
     * @param $options
     */
    public function checkLimit($options)
    {
        if (preg_match('/^.{' . $options['limit'] . '}$/', $options['data'])) {
            $this->validateStatus = true;
        } else {
            $limits = explode(',', $options['limit']);
            $this->setError($options, ' must be between  ' . $limits[0] . ' and ' . $limits[1]);
        }
    }

    /**
     * @param $options
     */
    public function checkWordLimit($options)
    {
        $word = explode(" ", $options['data']);
        $limits = explode(",", $options['limit']);
        (count($word) > $limits[0] && count($word) < $limits[1]) ? $this->validateStatus = true : $this->setError($options, ' must be between  ' . $limits[0] . ' and ' . $limits[1]);
    }

    /**
     * @param $options
     */
    public function checkEmail($options)
    {
        preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $options['data']) ? $this->validateStatus = true : $this->setError($options, ' must be an email');
    }
}
