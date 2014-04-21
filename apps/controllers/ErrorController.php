<?php

use Phalcon\Mvc\View;

class ErrorController extends Phalcon\Mvc\Controller
{
    public function initialize(){

        header('Content-Type:text/html;charset=UTF-8');
        $this->view->disableLevel(View::LEVEL_MAIN_LAYOUT);
    }

    public function accessAction(){}
    
    public function showAction(){}

    public function show404Action(){}

    public function show503Action(){}

    public function upgradeAction(){}
 
}