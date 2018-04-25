<?php
return [
    'id' => 'collection',
    'migrationPath' => '@vendor/yuncms/collection/migrations',
    'translations' => [
        'yuncms/collection' => [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/yuncms/collection/messages',
        ],
    ],
    'frontend' => [
        'class' => 'yuncms\collection\frontend\Module',
    ],
];