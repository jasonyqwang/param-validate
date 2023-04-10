<?php
/**
 * 查询字段匹配
 * Created by Jason Wang.
 * @author  jason <jasonwang1211@gmail.com>
 */

namespace Jsyqw\ParamValidate\filters;

class SearchMatch
{
    //原字段
    public $ori_attribute = '';
    //转化后的字段
    public $attribute = '';
    //对应的操作
    /**
     * 不区分大小写，左右两边都可以
     * @var string
     *  'and' => 'AND',
        'or' => 'OR',
        'not' => 'NOT',
        'lt' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '>=',
        'eq' => '=',
        'neq' => '!=',
        'in' => 'IN',
        'nin' => 'NOT IN',
        'like' => 'LIKE',
     */
    public $operator = '';

    /**
     * SearchMatch constructor.
     * @param $oriAttribute
     * @param $attribute
     * @param $operator
     */
    public function __construct($oriAttribute, $attribute, $operator = '=')
    {
        $this->ori_attribute = $oriAttribute;
        $this->attribute = $attribute;
        $this->operator = $operator;
    }

}