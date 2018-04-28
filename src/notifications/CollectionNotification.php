<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\collection\notifications;

use Yii;
use yuncms\notifications\Notification;

/**
 * Class CollectionNotification
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @since 3.0
 */
class CollectionNotification extends Notification
{
    /** @var string */
    public $verb = 'collection';

    /**
     * 该通知被推送的通道
     * @return array
     */
    public function broadcastOn()
    {
        return ['cloudPush', 'database'];
    }

    /**
     * 获取标题
     * @return string
     */
    public function getTitle()
    {
        return Yii::t('yuncms/collection', 'Collection reminder');
    }

    /**
     * 获取消息模板
     * @return string
     */
    public function getTemplate()
    {
        return Yii::t('yuncms/collection', '{username} collection your {entity}');
    }


}