<?php

use Phalcon\Mvc\User\Plugin as PhPlugin,
    Phalcon\Mvc\Dispatcher as PhDispatcher,
    Phalcon\Events\Event as PhEvent,
    Phalcon\Acl as PhAcl,
    Phalcon\Acl\Role as PhAclRole,
    Phalcon\Acl\Resource as PhAclResource;

/**
 * This is the security plugin which controls 
 * that users only have access to the modules 
 * they're assigned to
 */
class Security extends PhPlugin {

    /**
     * This action is executed 
     * before execute any action in the application
     */
    public function beforeDispatch(PhEvent $event, PhDispatcher $dispatcher) {
        
        $role = $this->userIdentity->authenticate();
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        $acl = $this->_getAcl();
        $allowed = $acl->isAllowed($role, $controller, $action);
        
        if ($allowed != PhAcl::ALLOW) {
            $dispatcher->forward( array('controller' => 'error', 'action' => 'access') );
            return false;
        }
    }
    
    private function _getAcl() {
        if (!isset($this->persistent->acl)) {
        
            $acl = new \Phalcon\Acl\Adapter\Memory();
            $acl->setDefaultAction(PhAcl::DENY);
            
            $aRoles = require( APP_PATH . '/config/roles.php' );
            foreach ($aRoles as $role => $val) {
                $acl->addRole(new PhAclRole($role));
                
                if(isset($val['inherit'])){
                    $acl->addInherit($role, $val['inherit']);
                }

                if( !isset($val['resources']) ){
                    continue;
                }
                
                if ($val['resources'] == '*') {
                    //The role allow access to any resource
                    $acl->allow($role, '*', '*');
                } else {
                    foreach ($val['resources'] as $resource => $actions) {
                        $acl->addResource(new PhAclResource($resource), $actions);
                        $acl->allow($role, $resource, $actions);
                    }
                }
            }

            //The acl is stored in session
            $this->persistent->acl = $acl;
        }

        return $this->persistent->acl;
    }
}
