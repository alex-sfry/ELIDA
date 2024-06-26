<?php

$params = require __DIR__ . '/params.php';

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
                    'js' => [ 'yii.js']
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
            'rules' => [
               'contact' => 'site/contact',
                'engineers' => 'engineers/index',
                'engineer/<id:\w+>' => 'engineers/details',
                'station/ships/<id:\w+>' => 'stations/ships',
                'station/ship-modules-<cat:\w+>/<id:\w+>' => 'stations/ship-modules',
                'station/ship-modules-hardpoint/<id:\w+>' => 'stations/ship-modules',
                'station/market/<id:\w+>' => 'stations/market',
                'station/<id:\w+>' => 'stations/details',
                'stations' => 'stations/index',
                'system-station/<sys_st:[\w\s\']+>' => 'stations/system-station',
                'system/get/<sys:[\w\s\']+>' => 'systems/system',
                'system/<id:\w+>' => 'systems/details',
                'systems' => 'systems/index',
                'shipyard-ships' => 'shipyard-ships/index',
                'ship-modules' => 'ship-modules/index',
                'commodities' => 'commodities/index',
                'trade-routes' => 'trade-routes/index',
                'materials' => 'materials/index',
                'material-traders' => 'material-traders/index',
                'rings' => 'rings/index',
                'user/login' => 'user/login',
                'user/logout' => 'user/logout',
                'user/signup' => 'user/signup',
                '<action:(captcha)>'  => 'site/<action>',
                // '<controller>/<action>' =>  '<controller>/<action>',
                '' => 'site/index'
            ],
        ],
    ],
    'params' => $params,
    'container' => [
        'definitions' => [
            'app\models\StationMarket' => [
                'class' => 'app\models\StationMarket',
            ],
            'app\models\ShipMods' => [
                'class' => 'app\models\ShipMods',
            ],
            'app\models\ShipyardShips' => [
                'class' => 'app\models\ShipyardShips',
            ],
            'app\models\search\EngineersSearch' => [
                'class' => 'app\models\search\EngineersSearch',
            ],
            'app\models\TradeRoutes' => [
                'class' => 'app\models\TradeRoutes',
            ],
            'app\models\forms\TradeRoutesForm' => [
                'class' => 'app\models\forms\TradeRoutesForm',
            ],
            'app\models\forms\CommoditiesForm' => [
                'class' => 'app\models\forms\CommoditiesForm',
            ],
            'app\models\Commdts' => [
                'class' => 'app\models\Commdts',
            ],
            'app\models\forms\ShipModulesForm' => [
                'class' => 'app\models\forms\ShipModulesForm',
            ],
            'app\models\ShipMods' => [
                'class' => 'app\models\ShipMods',
            ],
            'app\models\forms\ShipyardShipsForm' => [
                'class' => 'app\models\forms\ShipyardShipsForm',
            ],
            'app\models\ShipyardShips' => [
                'class' => 'app\models\ShipyardShips',
            ],
            'app\models\search\EngineersSearch' => [
                'class' => 'app\models\search\EngineersSearch',
            ],
            'app\models\search\MaterialsSearchh' => [
                'class' => 'app\models\search\MaterialsSearch',
            ],
            'app\models\search\MaterialTradersSearch' => [
                'class' => 'app\models\search\MaterialTradersSearch',
            ],
            'app\models\search\StationsInfoSearch' => [
                'class' => 'app\models\search\StationsInfoSearch',
            ],
            'app\models\search\SystemsInfoSearch' => [
                'class' => 'app\models\search\SystemsInfoSearch',
            ],
            'app\models\forms\ContactForm' => [
                'class' => 'app\models\forms\ContactForm',
            ],
            'app\models\search\RingsSearch' => [
                'class' => 'app\models\search\RingsSearch',
            ],
        ],
    ],
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
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
