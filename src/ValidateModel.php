<?php
/**
 * Created by PhpStorm.
 * @author  jason <jasonwang1211@gmail.com>
 * 继承Yii本身的验证规则
 * 1.验证规则可从对象外部进行设置。
 * 2.从验证规则中获取可赋值的属性。
 */

namespace Jsyqw\ParamValidate;

use Jsyqw\ParamValidate\traits\validatePhone;
use yii\db\ActiveRecord;

class ValidateModel extends ActiveRecord
{
    
    /**
     * 自定义的一些 trait 验证器
     */
    use validatePhone;


    /**
     * @var array 验证规则
     */
    private $_rules = [];

    /**
     * @var array 虚拟属性,不是数据库字段
     */
    private $_visionAttributes = [];

    // 设置验证规则
    public function setRules($rules)
    {
        $this->_rules = $rules;
        foreach ($rules as $item) {
            $this->_visionAttributes = array_unique(array_merge($this->_visionAttributes, (array)$item[0]));
        }
    }

    // 重写获取验证规则
    public function rules()
    {
        return $this->_rules;
    }

    // 设置可用属性列表
    public function attributes()
    {
        return $this->_visionAttributes;
    }

    /**
     * 构建默认的搜索条件（默认是等于查询）
     * @param array $ignoreSearchAttributes 不需要参与查询构建的字段
     * @return array
     */
    public function buildOperatorRules($ignoreSearchAttributes = []){
        $rules = [];
        foreach ($this->toArray() as $attribute => $value){
            //不需要的过滤条件 比如 分页参数
            if(in_array($attribute, $ignoreSearchAttributes)){
                continue;
            }
            //过滤掉为空的搜索条件
            if($value === '' or $value === null){
                continue;
            }
            $rules[$attribute] = $value;
        }
        return $rules;
    }

    /**
     * 获取第一个错误信息
     * @return mixed
     */
    public function getFirstErrorMsg()
    {
        $error = $this->getErrorSummary(false);
        return current($error);
    }
}