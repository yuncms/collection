<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

return [
    'id' => 'collection',
    'migrationPath' => '@vendor/yuncms/collection/migrations',
    'translations' => [
        'yuncms' => [
            'class' => yii\i18n\PhpMessageSource::class,
            'basePath' => '@vendor/yuncms/collection/messages',
            'sourceLanguage' => 'en-US',
        ],
    ],
];