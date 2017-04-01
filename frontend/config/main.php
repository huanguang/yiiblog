<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'homeUrl' => '/',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language' =>'zh-CN',//配置语言
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => '@webroot/path/to/uploadfolder',
            'uploadUrl' => '@web/path/to/uploadfolder',
            'imageAllowExtensions'=>['jpg','png','gif']
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
             'layout' => 'left-menu',//yii2-admin的导航菜单
        ],
    ],

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',//新加
        ],
        //第三方登陆
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    #这里以faceBook为例（Yii2本身已实现）
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => 'facebook_client_id', #你的第三方平台申请的AppId
                    'clientSecret' => 'facebook_client_secret',#你的第三方平台申请的AppKey
                ],
                'qq' => [
                    'class'=>'yii\authclient\clients\QqOAuth',
                    'clientId'=>'',
                    'clientSecret'=>'',
                ],
            ],
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        //语言包配置
        'i18n'=>[
            'translations'=> [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'baseBpath' => '/messages',
                    'fileMap' => [
                        'common' => 'common.php',
                    ],
                ]
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
            //'defaultRoles' => ['未登录用户'],//添加此行代码，指定默认规则为 '未登录用户'
        ]
        
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',//允许访问的节点，可自行添加
            'admin/*',//允许所有人访问admin节点及其子节点
            '*',//允许所有人访问所有节点及其子节点
        ]
    ],
    // 'aliases' => [
    //     '@mdm/admin' => '@vendor/mdmsoft/yii2-admin',
    // ],
    // 'as access' => [
    //     'class' => 'mdm\admin\components\AccessControl',
    //     'allowActions' => [
    //         'admin/*',            //配置允许权限
    //     ]
    // ],
    'params' => $params,
];
