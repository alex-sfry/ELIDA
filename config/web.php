<?php

$params = require __DIR__ . '/params.php';
$routes = require __DIR__ . '/routes.php';
$container = require __DIR__ . '/container.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    // 'sourceLanguage' => 'en-US',
    'components' => [
        // 'errorHandler' => [
        //     'maxSourceLines' => 20,
        // ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'assetManager' => [
            'converter' => [
                'class' => 'yii\web\AssetConverter',
                'commands' => [
                    'sass' => [
                        'css',
                        'sass --style=compressed {from} {to}',
                    ],
                ],
            ],
            'appendTimestamp' => true,
            // 'linkAssets' => true,
            // 'forceCopy' => YII_ENV_DEV ? true : false,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js']
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
                'app\assets\BootstrapAssetMin' => [
                    'baseUrl' => '@web/templates/',
                    'css' => [YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css'],
                    'js' => [YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js']
                ],
                'yii\web\YiiAsset' => [
                    'sourcePath' => YII_ENV_DEV ? '@yii/assets' : '@app/assetsMin',
                    'js' => ['yii.js']
                ],
                'yii\grid\GridViewAsset' => [
                    'sourcePath' => YII_ENV_DEV ? '@yii/assets' : '@app/assetsMin',
                    'js' => ['yii.gridView.js']
                ],
                'yii\captcha\CaptchaAsset' => [
                    'sourcePath' => YII_ENV_DEV ? '@yii/assets' : '@app/assetsMin',
                    'js' => ['yii.captcha.js']
                ],
                'yii\widgets\ActiveFormAsset' => [
                    'sourcePath' => YII_ENV_DEV ? '@yii/assets' : '@app/assetsMin',
                    'js' => ['yii.activeForm.js']
                ],
                'yii\validators\ValidationAsset' => [
                    'sourcePath' => YII_ENV_DEV ? '@yii/assets' : '@app/assetsMin',
                    'js' => ['yii.validation.js']
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => CSFR_VALIDATION_KEY,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\ar\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/login']
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'transport' => MAIL_TRANSPORT,
            // send all mails to a file by default.
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => DB_CONFIG,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => $routes
        ],
    ],
    'params' => $params,
    'container' => $container
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'panels' => [
            'httpclient' => [
                'class' => 'yii\httpclient\debug\HttpClientPanel',
            ],
        ],
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    // $config['modules']['gii'] = [
    //     'class' => 'yii\gii\Module',
    //     // uncomment the following to add your IP if you are not connecting from localhost.
    //     //'allowedIPs' => ['127.0.0.1', '::1'],
    // ];
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [ //here
            'crud' => [ // generator name
                'class' => 'yii\gii\generators\crud\Generator', // generator class
                'templates' => [ //setting for out templates
                    'myCrud' => '@app/giiTemplates/crud/default', // template name => path to template
                ]
            ]
        ],
    ];
}

return $config;
