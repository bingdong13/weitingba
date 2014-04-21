<?php

/**
 * Bootstraps the application
 */
use \Phalcon\Exception as PhException;

class Bootstrap {

    static private $_di = null;

    static public function init( $config ) {
        
        self::$_di = new \Phalcon\DI\FactoryDefault();
        
        // Initializes the config
        $config = new \Phalcon\Config($config);
        self::$_di->setShared('config', $config);
        
        // Initializes the autoloader
        $loader = new \Phalcon\Loader();
        $loader->registerDirs(array(
            $config->application->modelsDir,
            $config->application->controllersDir,
            $config->application->pluginsDir,
            $config->application->libraryDir
        ))->register();
        
        // Initializes the view
        self::$_di->setShared('view', function () use ($config) {

            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir($config->application->viewsDir);
            
            return $view;
        });

        // Initializes the user class
        foreach ($config->uclass as $cname){

            $cObj = new $cname();

            self::$_di->set(lcfirst($cname), $cObj);
        }
    }

    // Runs the application performing all initializations
    static public function run() {
        try {
            
            // auto loader service component
            $services = array('session', 'cookie', 'url', 'router', 'mysqlDb', 'viewCache', 'modelCache','metadata', 'dispatcher');
            
            $config = self::$_di->getShared('config');
            foreach ($services as $service) {
                $function = 'init' . ucfirst($service);

                self::$function( $config );
            }
            
            $application = new \Phalcon\Mvc\Application(self::$_di);
            
            echo $application->handle()->getContent();

        } catch (PhException $e) {

            header("Location: /error/show503");
            exit;
        }
    }
    
    // Initializes the session
    static protected function initSession($config = '') {
        self::$_di->setShared('session', function () {

            $session = new \Phalcon\Session\Adapter\Files();
            $session->start();

            return $session;
        });
    }

    // Initializes the cookie
    static protected function initCookie($config = '') {
        self::$_di->setShared('cookies', function () {

            $cookies = new \Phalcon\Http\Response\Cookies();
            $cookies->useEncryption(false);

            return $cookies;
        });
    }

    // Initializes the database
    static protected function initMysqlDb($config) {
        $di = self::$_di;

        $di->setShared('db', function() use ($di, $config) {

            $connection = new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                'host'     => $config->database->host,
                'username' => $config->database->username,
                'password' => $config->database->password,
                'dbname'   => $config->database->dbname,
                'charset'  => $config->database->charset
            ));

            if($di->has('dbListener')){
                $dbListener    = $di->getShared('dbListener');
                $eventsManager = $di->getShared('eventsManager');
                $eventsManager->attach('db', $dbListener);

                //Assign the eventsManager to the db adapter instance
                $connection->setEventsManager($eventsManager);
            }
            
            return $connection;
        });
    }

    // Initializes the baseUrl
    static protected function initUrl($config) {

        if( !isset($config->application->baseUri) )
            return false;

        // The URL component is used to generate all kind of urls in the application
        self::$_di->set('url', function () use ($config) {

            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri($config->application->baseUri);
            
            return $url;
        });
    }

    // Initializes the router
    static protected function initRouter($config = '') {

        self::$_di->set('router', function () {

            // Create the router without default routes
            $oRouter = new \Phalcon\Mvc\Router(false);
            
            //Remove trailing slashes automatically
            $oRouter->removeExtraSlashes(true);

            //Set 404 paths
            $oRouter->notFound(array( 'controller' => 'error', 'action' => 'show404'));

            $aRoutes = require( APP_PATH . '/config/routes.php' );
            
            foreach ($aRoutes as $route => $items) {
                $oRouter->add($route, $items['params'])->setName($items['name']);
            }
            
            unset($aRoutes);

            return $oRouter;
        });
    }

    // Initializes the cache
    static protected function initViewCache($config) {

        if( !isset($config->cache) )
            return false;

        self::$_di->set('viewCache', function () use ($config) {

            $frontEndOptions = array('lifetime' => $config->cache->lifetime);
            $frontCache = new \Phalcon\Cache\Frontend\Output($frontEndOptions);

            $backEndOptions = array('cacheDir' => $config->cache->cacheDir);
            $cache = new \Phalcon\Cache\Backend\File($frontCache, $backEndOptions);

            return $cache;
        });
    }

    // Initializes the models cache
    static protected function initModelCache($config){

        if( !isset($config->cache) )
            return false;
        
        //Set the models cache service
        self::$_di->set('modelsCache', function() use ($config) {

            //Cache data for one day by default
            $frontCache = new \Phalcon\Cache\Frontend\Data(array(
                'lifetime' => $config->cache->lifetime
            ));

            switch($config->cache->type){
                case 'memcache':
                    //Memcached connection settings
                    $options = array('host' => 'localhost', 'port' => '11211');
                    $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, $options);
                    break;
                default:
                    $backEndOptions = array('cacheDir' => $config->cache->cacheDir);
                    $cache = new \Phalcon\Cache\Backend\File($frontCache, $backEndOptions);
                    break;
            }

            return $cache;
        });
    }
    
    // Initializes the modelsMetadata
    static protected function initMetadata($config = '') {
        
        self::$_di->set('modelsMetadata', function () {

            $metaData = new \Phalcon\Mvc\Model\Metadata\Memory();

            $metaData->setStrategy(new \Phalcon\Mvc\Model\MetaData\Strategy\Annotations());

            return $metaData;
        });
    }
    
    // Initializes the Dispatcher
    static protected function initDispatcher($config = '') {

        $eventsManager = self::$_di->getShared('eventsManager');
        $eventsManager->attach('dispatch', new Security());

        $dispatcher = new \Phalcon\Mvc\Dispatcher();
        $dispatcher->setEventsManager($eventsManager);

        self::$_di->set('dispatcher', $dispatcher);
    }
}