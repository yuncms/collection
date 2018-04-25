<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\collection\rest\models;

use yuncms\rest\models\User;

/**
 * Class Collection
 *
 * @author Tongle Xu <xutongle@gmail.com>
 * @since 3.0
 */
class Collection extends \yuncms\collection\models\Collection
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}