<?php

namespace PluginMaster\Validator\base;


interface ValidatorBase
{
    /**
     * @param $request
     * @param $validatorData
     * @return mixed
     */
    static public function validate($request, $validatorData);

    /**
     * @return mixed
     */
    public function fails();

    /**
     * @return mixed
     */
    public function errors();

}
