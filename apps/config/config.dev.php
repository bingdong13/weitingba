<?php
/**
 *  common config file
 */

/**
 *  当前使用的存储服务：
 *  local 本地；qiniu 七牛
 */
define('STORAGE', 'local');

$config['url'] = array(
    'www' => 'http://www.lvmaohai.cn',
    'assets' => 'http://static-dev.lvmaohai.cn',
    'img' => 'http://img-dev.lvmaohai.cn/',
);

// 自定义类
$config['uclass'] = array('UserIdentity', 'DbListener');

// db 配置信息
$config['database'] = array(
    'adapter' => 'Mysql',
    'host' => 'localhost',
    'username' => 'root',
    'password' => 'csmysql',
    'dbname' => 'weitingba_dev',
    'charset' => 'utf8'
);

// cache 配置信息
$config['cache'] = array(
    'type' => 'file', // File; Memcache;
    'lifetime' => 86400,
    'cacheDir' => APP_PATH . '/cache/',
);

//logger 配置信息
$date = date('Ymd');
$config['log'] = array(
    'app' => APP_PATH . "/logs/app_{$date}.log",
    'db'  => APP_PATH . "/logs/db_{$date}.log"
);

// 应用配置信息
$config['application'] = array(
    'title' => '微听吧',
    'baseUri' => '/',
    
    'controllersDir' => APP_PATH . '/controllers/',
    'viewsDir'       => APP_PATH . '/views/',
    'modelsDir'      => APP_PATH . '/models/',
    'pluginsDir'     => APP_PATH . '/plugins/',
    'libraryDir'     => APP_PATH . '/library/',
    'uploadDir'      => realpath(APP_PATH . '/../uploads/')
);

// 频道配置信息
$config['channel'] = array(
    'home' => array(
        'title' => '首页',
        'src' => '/',
        'target' => '_self'
    ),
    'shared' => array(
        'title' => '语录', 
        'keywords' => '名言,励志,爱情,影视,唯美,健康,职场,搞笑,语录', 
        'description' => '听君一席话，胜读十年书。', 
        'src' => '/shared',
        'face_url' =>'shared.jpeg',
        'target' => '_self'
    ),
    'notebook' => array(
        'title' => '笔记', 
        'keywords' => 'php,mysql,linux,编程,杂谈,杂症', 
        'description' => '好记性不如烂笔头。', 
        'src' => '/notebook',
        'face_url' =>'notebook.jpeg',
        'target' => '_self'
    ),
    'magazine' => array(
        'title' => '杂志', 
        'keywords' => '杂乱无章，胸无大志。', 
        'description' => '杂乱无章，胸无大志。', 
        'src' => '/magazine',
        'face_url' =>'magazine.jpeg',
        'target' => '_self'
    ),
    'fm' => array(
        'title' => 'FM', 
        'src' => '/fm',
        'target' => '_self'
    ),
    'tour' => array(
        'title' => '旅游', 
        'src' => '/tour',
        'target' => '_self'
    ),
    'guestbook' => array(
        'title' => '留言', 
        'src' => '/guestbook', 
        'tip' => '给我留言',
        'target' => '_blank' 
    )
);

return $config;