<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\collection\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yuncms\collection\notifications\CollectionNotification;
use yuncms\db\ActiveRecord;
use yuncms\user\models\User;

/**
 * Class UserCollection
 *
 * @property integer $user_id
 * @property integer $model_id
 * @property string $model_class
 * @property string $subject
 * @property integer $created_at
 * @property integer $updated_at
 * @property ActiveRecord $source
 *
 * @property User $user
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @since 3.0
 */
class Collection extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%collections}}';
    }

    /**
     * 是否收藏
     * @param string $model
     * @param integer $modelId
     * @param integer $user_id
     * @return bool
     */
    public static function isCollected($model, $modelId, $user_id = null)
    {
        return static::find()->where([
            'user_id' => $user_id ? $user_id : Yii::$app->user->id,
            'model_class' => $model,
            'model_id' => $modelId
        ])->exists();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'user_id',
                ],
            ]];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id'], 'required'],
            [['subject'], 'filter', 'filter' => 'trim'],
        ];
    }

    /**
     * @return \yii\db\ActiveQueryInterface
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne($this->model_class, ['id' => 'model_id']);
    }

    /**
     * 获取源标题
     * @return string
     */
    public function getSourceTitle()
    {
        return null;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $this->source->updateCountersAsync(['collections' => 1]);
            $this->sendNotice();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * 发送通知
     */
    public function sendNotice()
    {
        try {
            Yii::$app->notification->send($this->source->user, new CollectionNotification([
                'data' => [
                    'username' => $this->user->nickname,
                    'entity' => $this->toArray(),
                    'source' => $this->source->toArray(),
                    'source_title' => $this->getSourceTitle(),
                    'source_id' => $this->model_id,
                    'source_class' => $this->model_class
                ]
            ]));
        } catch (InvalidConfigException $e) {
            Yii::error($e->getMessage(), __METHOD__);
        }
    }

    /**
     * @inheritdoc
     */
    public function afterDelete()
    {
        $this->source->updateCountersAsync(['collections' => -1]);
        parent::afterDelete();
    }
}
