<?php

use \Phalcon\Mvc\Controller as PhController,
    \Phalcon\Exception as PhException;

class ControllerBase extends PhController
{
    protected $script = null;
    
    protected $style  = null;
    
    protected function initialize() {

        header('Content-Type:text/html;charset=UTF-8');
        
        $this->tag->setTitle($this->config->application->title);
        $this->tag->setTitleSeparator(' - ');
        
        $this->style = $this->assets->collection('asset-css')
                ->setPrefix($this->config->url->assets)
                ->setLocal(false)
                ->addCss('/css/common.css');
        
        $this->script = $this->assets->collection('asset-js')
            ->setPrefix($this->config->url->assets)
            ->setLocal(false)
            ->addJs('/js/jquery.min.js')
            ->addJs('/js/jquery.plugin.js')
            ->addJs('/js/jquery.lazyload.min.js')
            ->addJs('/js/common.js');
    }

    // 检测系统是否升级维护
    protected function checkUpgrade(){

        $allowIp = array('180.168.48.131', '114.92.138.208');
        $ip = $this->request->getClientAddress();

        if( !in_array($ip, $allowIp) ){
            $this->forward('error/upgrade');
            return false;
        }
    }

    /**
     * ip转换相应地址
     * 
     * @param string $ip
     * @return array country 表示城市地区，area 表示区域;
     */
    protected function ip2Address($ip = ''){
        
        if( !$ip ){
            $ip = $this->request->getClientAddress();
        }

        $dataPath = realpath(APP_PATH.'/../data/qqwry.dat');
        $iplocation = new IpLocation($dataPath);
        $location = $iplocation->getlocation($ip);
        
        if($location['area']){
            $location['area'] = mb_convert_encoding($location['area'], "utf8", "gbk");
        }
        
        $location['country'] = mb_convert_encoding($location['country'], "utf8", "gbk");

        return $location;
    }

    /**
     * URL转向
     * 
     * @param string $uri 目标路径
     * @return boolean
     */
    protected function forward($uri) {
        $uriParts = explode('/', $uri);

        return $this->dispatcher->forward(
            array('controller' => $uriParts[0], 'action' => $uriParts[1])
        );
    }

    // ajax请求、带token表单验证，返回json格式数据。
    protected function checkAjaxForm(){
        $this->view->disable();

        header('Content-Type:application/json;charset=UTF-8');

        if( !$this->request->isAjax() ){
            throw new PhException('EFormSubmit');
        }

        if( !$this->security->checkToken() ){
            throw new PhException('ETokenError');
        }
    }
    
    // ajax请求验证，返回json格式数据。
    protected function checkAjax(){
        $this->view->disable();

        header('Content-Type:application/json;charset=UTF-8');
        
        if( !$this->request->isAjax() ){
            throw new PhException('EAjaxSubmit');
        }
    }
    
    /**
     * 生成日志信息
     * 
     * @param string $msg 日志内容
     * @param string $filename 日志文件名
     * @return void
     */
    protected function log($msg, $filename='app'){
        $logsDir = $this->config->application->logsDir;
        $logfile = $logsDir . $filename .'_'. date('Y_m_d') .'.log';
        $logger = new \Phalcon\Logger\Adapter\File($logfile);

        $logger->log($msg);
    }

}