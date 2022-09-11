<?php

namespace PluginMaster\Validator;

use PluginMaster\Request\Request;
use PluginMaster\Contracts\Validator\ValidatorInterface;
use PluginMaster\Validator\utilities\ValidateManager;

class Validator extends ValidateManager implements ValidatorInterface
{

    /**
     * @var Validator
     */
    private static $instance;
    public $status;


    /**
     * for rest route
     * @param Request $request
     * @param $validatorData
     * @return Validator
     */

    public static function make(Request $request, $validatorData): self
    {
        static::$instance = static::$instance ?? (new self);
        static::$instance->messages = [];
        static::$instance->execute($request, $validatorData);
        return static::$instance;
    }


    /**
     * @param Request $request
     * @param array $rules
     * @return bool
     */
    protected function execute(Request $request, array $rules): bool
    {
        $this->status = true;

        foreach ($rules as $key => $option) {
            $options = [
                "checkers" => $option,
                "data" => $request->$key,
                "fieldName" => $key
            ];

            $valueAsArray = is_array($options['checkers']) ? $options['checkers'] : explode('|', $options['checkers']);

            foreach ($valueAsArray as $k => $value) {
                $validateOption = [
                    "data" => $options['data'],
                    "fieldName" => $options['fieldName'],
                ];

                $split = explode(':', $value);
                $validateOption['checker'] = $split[0];
                if (count($split) > 1) {
                    $validateOption['limit'] = $split[1];
                }


                $check = $this->validatingOptions($validateOption);

                if (!$check) {
                    $this->status = false;
                }
            }
        }

        return $this->status;
    }


    /**
     * @param array $options
     * @return bool
     */
    private function validatingOptions(array $options): bool
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
     * @return bool
     */
    public function fails(): bool
    {
        return !$this->status;
    }


    /**
     * @return mixed
     */
    public function errors(): array
    {
        return $this->messages;
    }
}
