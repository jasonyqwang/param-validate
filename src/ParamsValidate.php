<?php
/**
 * Created by PhpStorm.
 * @author  jason <jasonwang1211@gmail.com>
 */

namespace Jsyqw\ParamValidate;

class ParamsValidate
{
    /**
     * 验证参数,注意：当前会自动过滤非定义的字段
     * @param $data
     * @param $rules eg：
     *  ['字段名', 'default', 'value' => 1],
        ['password', 'compare', "compareAttribute" => "confirm_password", "operator" => "==",'message' => '两次密码不一致'],
        ['字段名', 'required', 'message' => '提示信息', 'on' => '场景名'], // 必填验证
        ['字段名', 'email', 'message' => '提示信息', 'on' => '场景名'], // 邮箱格式验证
        ['字段名', 'url', 'message' => '提示信息', 'on' => '场景名'], // 网址格式验证
        ['字段名', 'match', 'pattern' => '正则表达式'], // 正则验证
        ['字段名', 'captcha'], // Yii 验证码验证
        ['字段名', 'safe'], // 安全不验证
        ['字段名', 'string', 'length' => [6, 18]], // 字符串长度验证，必须在6至18长度以内的
        ['字段名', 'unique'], // 值在本字段中的唯一性验证
        ['字段名', 'integer', 'max' => '上限', 'min' => '下限'], // 整数验证
        ['字段名', 'number', 'max' => '上限', 'min' => '下限'], // 数字验证
        ['字段名', 'double'], // 双精度浮点数验证
        ['字段名', 'in', 'range' => [1, 2, 3]], // 范围验证，必须在1,2,3以内的
        ['字段名', 'filter', 'filter' => 'trim'], // 过滤,删除字段两边的空格
        ['字段名', 'exist', 'targetClass' => '模型名'], // 字段名必须在模型名中存在
        ['字段名', 'file', 'extension' => 'jpg,png', 'maxSize' => 1024 * 1024 * 1024], // 允许上传以jpg，png为后缀，文件最大1024*1024*1024 Byte的文件
        ['字段名', 'validateType'], // 自定义函数验证
     * @return ValidateModel
     */
    public static function validate(&$data, $rules){
        $model = new ValidateModel();
        $model->setRules($rules);
        $model->setAttributes($data);
        $model->validate();
        //如果验证过后，则需要把data的重新赋值，以便适配 ['字段名', 'filter', 'filter' => 'trim'] 的字段
        $data = $model->toArray();
        return $model;
    }
}