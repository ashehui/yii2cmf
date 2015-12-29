<?php

namespace common\models;

use common\behaviors\PushBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $author
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $cover
 */
class Article extends \yii\db\ActiveRecord
{
    CONST STATUS_ACTIVE = 1;
    CONST STATUS_INIT = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['status', 'category_id', 'view', 'up', 'down'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INIT]],
            [['category'], 'setCategory'],
            [['title', 'category', 'author'], 'string', 'max' => 50],
            [['author', 'cover'], 'string', 'max' => 255]
        ];
    }
    public function setCategory($attribute, $params)
    {
        $this->category = Category::find()->where(['id'=>$this->category_id])->select('title')->scalar();
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => '标题',
            'content' => '内容',
            'author' => '作者',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => '状态',
            'cover' => '封面',
            'category_id'=>'分类',
            'category'=>'分类'
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            PushBehavior::className()
        ];
    }
}
