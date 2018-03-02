<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language'=>'th_TH',
    'timeZone'=>'UTC', // ต้อง set timezone DB เป็น Asia/Bangkok
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'formatter'=>[
            'class'=>'yii\i18n\Formatter',
            'dateFormat'=>'php:d/m/Y',
            'datetimeFormat'=>'php:d/m/Y H:i:s',
            'timeFormat'=>'php:H:i:s',
            'currencyCode'=>'฿',
            'decimalSeparator'=>'.',
            'thousandSeparator'=>',',
        ],
        'thaiFormatter'=>[
            'class'=>'dixonsatit\thaiYearFormatter\ThaiYearFormatter',
            //'nullDisplay'=>'-'
            'dateFormat'=>'php:d/m/Y',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => require(__DIR__ . '/cookie_validation_key.php'),
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession'=>true,
            'identityCookie' => [
                'name'=>'_identity',
                'httpOnly'=>true,
                //The timestamp defaults to 0, meaning "until the browser is closed"
                //'expire'=> 5
            ],
            'loginUrl'=>['/site/login'],
            'on afterLogin'=>function($event){
                Yii::$app->userlog->info("Login");
            }
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => require(__DIR__.'/log.php'),
        'db' => $db,
        'userlog'=>[
            'class'=>'app\components\UserLogComponent',
            'db'=>  $db,
        ],
       'urlManager' => [
            'enablePrettyUrl' => true,
            //'enableStrictParsing'=>true,
            'showScriptName' => false,
            
        ],
    ],
    'params' => $params,
                // TODO: มีปัญหาเมื่อ login ไม่ผ่าน php force close
    'as access' => [
        'class' => \yii\filters\AccessControl::className(),
        'rules' => [
            // allow guest users
            [
                'allow' => true,
                'actions' => ['login','reset-password','error'],
            ],
            // allow authenticated users
            [
                'allow' => true,
                'roles' => ['@'],
            ],
            // everything else is denied
        ],
//        'denyCallback' => function () {
//            return Yii::$app->response->redirect(['site/login']);
//        },
    ],
    'on afterRequest'=>function($event){
        $time_config = 60*60*3; //log user online at 3 hour
        $session = Yii::$app->session;
        if(!$session->has('_last_checkin')){
            $session['_last_checkin'] = time();
        }
        $last_checkin = $session['_last_checkin'];
        $current_checkin = time();
        $diff_time = $current_checkin - $last_checkin;
        //Yii::info('diff time (sec) '.$diff_time);
        if($diff_time>$time_config && !Yii::$app->user->isGuest){
            Yii::$app->userlog->info("Online");
            $session['_last_checkin'] = $current_checkin;
        }
    },
    'modules' => [
        'resource'=>[
            'class' => 'app\modules\resource\Resource'
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'admin'=>[
            'class'=>'app\modules\admin\AdminModule'
        ],
    ]
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    $config['components']['assetManager']['forceCopy'] = true;
}

return $config;
