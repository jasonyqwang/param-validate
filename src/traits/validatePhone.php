<?php
/**
 * Created by Jason Wang.
 * @author  jason <jasonwang1211@gmail.com>
 */

namespace Jsyqw\ParamValidate\traits;
use Jsyqw\Utils\ValidateHelper;

trait validatePhone
{
    /**
     * @param $attribute
     * @param $params
     * @param $validator
     */
    public function validatePhone($attribute, $params, $validator){
        if(!$this->hasErrors()){
            //如果有值的情况下，进行数据验证
            if($this->$attribute && !ValidateHelper::checkPhone($this->$attribute)){
                $message = $validator->message;
                if(!$message){
                    $message = "手机号格式有误";
                }
                $this->addError($attribute, $message);
            }
        }
    }
}