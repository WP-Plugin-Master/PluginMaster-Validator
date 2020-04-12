<?php

namespace PluginMaster\Validator;

use PluginMaster\Validator\base\ValidatorBase;
use PluginMaster\Validator\utilities\ValidateManager;

class Validator extends ValidateManager implements ValidatorBase
{


    public $status;
    /**
     * @var array
     */

    /**
     * for rest route
     * @param $request
     * @param $validatorData
     * @return Validator
     */

    public static function make($request, $validatorData)
    {
        $self = (new self);
        $self->message = [];
        $self->execute($request, $validatorData);
        return $self;
    }


    /**
     * @param $request
     * @param $rules
     * @return bool
     */
    protected function execute($request, $rules)
    {

        $this->status = true;

        foreach ($rules as $key => $option) {
            $options = [
                "checkers" => $option,
                "data" => $request->$key,
                "fieldName" => $key
            ];

            $valueAsArray = explode('|', $options['checkers']);

            foreach ($valueAsArray as $k => $value) {

                $validateOption = [
                    "data" => $options['data'],
                    "fieldName" => $options['fieldName'],
                ];

                $split = explode(':', $value);
                $validateOption['checker'] = $split[0];
                if (count($split) > 1) $validateOption['limit'] = $split[1];


                $check = $this->validatingOptions($validateOption);

                if (!$check) {
                    $this->status = false;
                }
            }
        }

        return $this->status;
    }


    /**
     * @param $options
     * @return bool
     */
    protected function validatingOptions($options)
    {
        $this->validateStatus = false;
        switch ($options['checker']) {
            case 'required':
                $this->checkRequired($options);
                break;
            case 'number':
                $this->checkNumber($options);
                break;
            case 'floatNumber':
                $this->checkFloatNumber($options);
                break;
            case 'noNumber':
                $this->checkNoNumber($options);
                break;
            case 'letter':
                $this->checkLetter($options);
                break;
            case 'noSpecialChar':
                $this->checkNoSpecialChar($options);
                break;
            case 'limit':
                $this->checkLimit($options);
                break;
            case 'wordLimit':
                $this->checkWordLimit($options);
                break;
            case 'email':
                $this->checkEmail($options);
                break;
        }

        return $this->validateStatus;
    }


    /**
     * @return bool|mixed
     */
    public function fails()
    {
        return !$this->status ? true : false;
    }


    /**
     * @return mixed
     */
    public function errors()
    {
        return $this->message;
    }
}
