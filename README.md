# 开发 Yii2 的参数验证的扩展包

    基于Yii2框架的验证器，针对接口可以自动验证声明的参数；
    经过验证的参数，可以直接访问属性，不用再通过isset判断；
    验证规则和Yii2的rules规则一样

# 一.使用composer安装

## 1.安装
    
        composer require jsyqw/param-validate
        
## 2.使用

在控制器的方法中

```php
/**
     * 列表
     * 默认分页参数
     *      每页条数：per_page
     *      第几页： page
     * @return array
     */
    public function actionIndex(){
        $reqData = RequestHelper::get();
        //验证
        $validateModel = ParamsValidate::validate($reqData, [
            [['page','per_page'], 'integer'],
            ['username', 'filter', 'filter' => 'trim'],
            ['realname', 'filter', 'filter' => 'trim'],
            ['status', 'integer', 'message' => '状态参数必须是整型'],
            ['phone', 'safe'],
        ]);
        if($validateModel->hasErrors()){
            return $this->paramsError($validateModel->getFirstErrorMsg());
        }
        $query = new Query();
        $columns = [
            't.id',
            't.status',
            't.username',
            't.avatar',
            't.realname',
            't.phone',
            't.create_time',
            't.update_time',
        ];
        $query->select($columns);
        $query->from(SysUser::tableName() . ' t');
        $query->andFilterWhere([
            't.status' => $validateModel->status,
        ]);
        $query->andFilterWhere(['like', 't.username', $validateModel->username])
            ->andFilterWhere(['like', 't.realname', $validateModel->realname])
            ->andFilterWhere(['like', 't.phone', $validateModel->phone]);
        $query->orderBy('t.id desc');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $list = $dataProvider->getModels();
        $total = $dataProvider->getTotalCount();
        $result = [
            'list' => $list,
            'total' => $total,
        ];
        return $this->success($result);
    }

```