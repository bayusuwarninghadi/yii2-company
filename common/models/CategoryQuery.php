<?php
namespace common\models;
use yii\db\ActiveQuery;

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
 * Class CategoryQuery
 * @package common\models
 */
class CategoryQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}
