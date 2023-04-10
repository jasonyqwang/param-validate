<?php
/**
 * Created by PhpStorm.
 * @author  jason <jasonwang1211@gmail.com>
 */

namespace Jsyqw\ParamValidate\filters;

use Jsyqw\ParamValidate\ValidateModel;

class ActiveDataFilter extends \yii\data\ActiveDataFilter
{
    //过滤提交过来的数据
    public $filterAttributeName = 'filter';
    //不需要自动过滤的参数
    public $ignoreSearchAttributes = [
        'page',
        'per_page',
        'per-page',
        'perPage',
        'pageNum',
        'page_index',
        'page-index',
        'pageIndex',
    ];

    //每种方法支持查询的类型
    public $operatorTypes = [
        '<' => [self::TYPE_STRING, self::TYPE_INTEGER, self::TYPE_FLOAT, self::TYPE_DATETIME, self::TYPE_DATE, self::TYPE_TIME],
        '>' => [self::TYPE_STRING, self::TYPE_INTEGER, self::TYPE_FLOAT, self::TYPE_DATETIME, self::TYPE_DATE, self::TYPE_TIME],
        '<=' => [self::TYPE_STRING, self::TYPE_INTEGER, self::TYPE_FLOAT, self::TYPE_DATETIME, self::TYPE_DATE, self::TYPE_TIME],
        '>=' => [self::TYPE_STRING, self::TYPE_INTEGER, self::TYPE_FLOAT, self::TYPE_DATETIME, self::TYPE_DATE, self::TYPE_TIME],
        '=' => '*',
        '!=' => '*',
        'IN' => '*',
        'NOT IN' => '*',
        'LIKE' => [self::TYPE_STRING, self::TYPE_INTEGER],
    ];

    /**
     * 当前适用通用的查询模式，比如统计等比较复杂的模式不适用
     * @param $validateModel ValidateModel
     * @param $searchMatchModels
     * @return "filter": {
                    "status": "1",
                    "name": {
                        "like": "庆"
                    }
                }
     */
    public function loadValidateModel(ValidateModel $validateModel, $searchMatchModels=[]){
        //默认的查询规则
        $defaultOperatorRules = $validateModel->buildOperatorRules($this->ignoreSearchAttributes);
        //自定义的查询规则
        $customOperatorRules = [];
        /**
         * @var $searchMatch SearchMatch
         */
        foreach ($searchMatchModels as $searchMatch){
            $oriAttribute = $searchMatch->ori_attribute;
            //如果默认搜索已经存在了，则剔除掉
            if(isset($defaultOperatorRules[$oriAttribute])){
                unset($defaultOperatorRules[$oriAttribute]);
            }
            //判断原
            if($validateModel->hasAttribute($oriAttribute) && $validateModel->$oriAttribute != ""){
                $customOperatorRules[$searchMatch->attribute] = [
                    $searchMatch->operator => $validateModel->$oriAttribute
                ];
            }
        }
        $data = [$this->filterAttributeName  => array_merge($defaultOperatorRules, $customOperatorRules)];
        //把查询条件封装成框架识别的格式
        $this->load($data);
        return $data;
    }
}