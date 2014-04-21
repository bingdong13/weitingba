<?php

use \Phalcon\Exception as PhException;

class TestController extends Phalcon\Mvc\Controller
{   
    public function initialize() {
        $this->view->disable();
        header('Content-Type:text/html;charset=UTF-8');
    }

    public function testRsAction(){

        require_once(APP_PATH . '/sdk/qiniu/rs.php');

        $bucket = "img-wtb";

        $key = "shared.jpeg";

        $client = new Qiniu_MacHttpClient(null);

        list($ret, $err) = Qiniu_RS_Stat($client, $bucket, $key);
        echo "Qiniu_RS_Stat result: \n";
        if ($err !== null) {
            var_dump($err);
        } else {
            var_dump($ret);
        }
    }

    public function testUpImgAction(){
        echo $this->config->application->uploadDir;
        exit;

        require_once(APP_PATH . '/sdk/qiniu/io.php');
        require_once(APP_PATH . '/sdk/qiniu/rs.php');

        $bucket = 'img-wtb';
        $key1 = "magazine.jpeg";
        $uploads = realpath($this->config->application->uploadDir);
        $path = $uploads . '/' . $key1;

        // 上传凭证
        $putPolicy = new Qiniu_RS_PutPolicy($bucket);
        $upToken = $putPolicy->Token(null);

        $putExtra = new Qiniu_PutExtra();
        $putExtra->Crc32 = 1;
        list($ret, $err) = Qiniu_PutFile($upToken, $key1, $path, $putExtra);
        echo "====> Qiniu_PutFile result: \n";
        if ($err !== null) {
            var_dump($err);
        } else {
            var_dump($ret);
        }
    }
    
}