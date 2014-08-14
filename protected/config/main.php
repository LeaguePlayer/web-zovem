<?php

// Настройки, специфичные для данной машины (например, БД), рекомендуется поместить в overrides/local.php

return array_replace_recursive(
    array(
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'Зовем',
        'language' => 'ru',
        'theme'=>'zovem',
        // preloading 'log' component
        'preload'=>array(
            'log',
            'config',
        ),
        'aliases'=>array(
            'appext'=>'application.extensions',
        ),
        // autoloading model and component classes
        'import'=>array(
            'application.models.*',
            'application.components.*',
            'application.behaviors.*',
            'appext.imagesgallery.models.*',
            'application.modules.hybridauth.controllers.*',
            'application.modules.user.models.*',
        ),
        'modules'=>array(
            'admin'=>array(),
            'email'=>array(),
            'auth'=>array(),
            'user'=>array(
                'hash' => 'md5',
                'sendActivationMail' => true,
                'loginNotActiv' => false,
                'activeAfterRegister' => false,
                'autoLogin' => true,
                'registrationUrl' => array('/user/registration'),
                'recoveryUrl' => array('/user/recovery'),
                'loginUrl' => array('/user/login'),
                'returnUrl' => array('/user/profile'),
                'returnLogoutUrl' => array('/user/login'),
            ),
            'hybridauth' => array(
                'baseUrl' => 'http://'. $_SERVER['SERVER_NAME'] . '/hybridauth',
                'withYiiUser' => true, // Set to true if using yii-user
                "providers" => array (


                    "vkontakte" => array (
                        "enabled" => true,
                        "keys"    => array ( "id" => "4350377", "secret" => "y0mJYEGQxIkE8gETPJll" ),
                        "scope"   => "",
                        "display" => ""
                    ),

                    "facebook" => array (
                        "enabled" => true,
                        "keys"    => array ( "id" => "501599393296930", "secret" => "a7ca8048f1384a1acd401eaa434f6741" ),
                        "scope"   => "",
                        "display" => ""
                    ),

                    "twitter" => array (
                        "enabled" => true,
                        "keys"    => array ( "key" => "", "secret" => "" )
                    ),

                    "openid" => array (
                        "enabled" => true
                    ),

                    "google" => array (
                        "enabled" => true,
                        "keys"    => array ( "id" => "", "secret" => "" ),
                        "scope"   => ""
                    ),
                )
            ),
        ),
        // application components
        'components'=>array(
            'config' => array(
                'class' => 'DConfig'
            ),
            'db' => array(
                'connectionString' => 'mysql:host=localhost;dbname=zovem',
                'emulatePrepare' => true,
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'tablePrefix' => 'tbl_',
            ),
            'authManager' => array(
                'class' => 'CDbAuthManager',// 'auth.components.CachedDbAuthManager',
                //'cachingDuration' => 0,
                'itemTable' => '{{authitem}}',
                'itemChildTable' => '{{authitemchild}}',
                'assignmentTable' => '{{authassignment}}',
                'behaviors' => array(
                    'auth' => array(
                        'class' => 'auth.components.AuthBehavior',
                    ),
                ),
            ),
            'user'=>array(
                'class' => 'user.components.WebUser',
            ),
            'bootstrap'=>array(
                'class'=>'appext.yiistrap.components.TbApi',
            ),
            'yiiwheels' => array(
                'class' => 'appext.yiiwheels.YiiWheels',
            ),
            'phpThumb'=>array(
                'class'=>'appext.EPhpThumb.EPhpThumb',
                'options'=>array()
            ),
            // uncomment the following to enable URLs in path-format
            'urlManager'=>array(
                'class' => 'EUrlManager',
                'showScriptName'=>false,
                'urlFormat'=>'path',
                'rules'=>array(
                    'gii'=>'gii',
                    '<controller>s' => '<controller>',
                    '/'=>'site/index',
                    '<controller:page>/<url:[\w_-]+>' => '<controller>/view',
                    'admin'=>'admin/structure',
                    'admin/<controller:!config>' => 'admin/<controller>/list',
                ),
            ),
            'clientScript'=>array(
                'class'=>'EClientScript',
                'scriptMap'=>array(
                    'jquery.js'=>'http://code.jquery.com/jquery-1.11.0.js',
                    'jquery.min.js'=>'http://code.jquery.com/jquery-1.11.0.min.js',
                ),
            ),
            'date' => array(
                'class'=>'application.components.Date',
                //And integer that holds the offset of hours from GMT e.g. 4 for GMT +4
                'offset' => 0,
            ),
            'errorHandler'=>array(
                'errorAction'=>'site/error',
            ),
        ),
        'params'=>array(),
    ),
    (file_exists(__DIR__ . '/overrides/environment.php') ? require(__DIR__ . '/overrides/environment.php') : array()),
    (file_exists(__DIR__ . '/overrides/local.php') ? require(__DIR__ . '/overrides/local.php') : array())
);