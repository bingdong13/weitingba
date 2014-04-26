<?php

use \Phalcon\Mvc\Controller as PhController,
    \Phalcon\Exception as PhException;

class ApiController extends PhController
{
    // ajax请求、带token表单验证，返回json格式数据。
    protected function checkAjaxForm(){
        header('Content-Type:application/json;charset=UTF-8');

        if( !$this->request->isAjax() ){
            throw new PhException('EFormSubmit');
        }

        if( !$this->security->checkToken() ){
            throw new PhException('ETokenError');
        }
    }
    
    protected function checkAjax(){
        header('Content-Type:application/json;charset=UTF-8');
        
        if( !$this->request->isAjax() ){
            throw new PhException('EAjaxSubmit');
        }
    }

    protected function uploader($fileField){

        $maxSize = 1000;                   //允许的文件最大尺寸，单位KB
        $allowFiles = array(".gif", ".png", ".jpg", ".jpeg", ".bmp"); //允许的文件格式

        //上传状态映射表
        $stateMap = array(    
            "未知错误" ,
            "文件大小超出 upload_max_filesize 限制" ,
            "文件大小超出 MAX_FILE_SIZE 限制" ,
            "文件未被完整上传" ,
            "没有文件被上传" ,
            "上传文件为空" ,
            "POST" => "文件大小超出 post_max_size 限制",
            "SIZE" => "文件大小超出网站限制",
            "TYPE" => "不允许的文件类型",
            "UNKNOWN" => "未知错误" ,
            "MOVE" => "文件保存时出错"
        );

        $file = $_FILES[$fileField];
            
        if (empty($file)) {
            throw new PhException( $stateMap['POST'] );
        }

        if($file['error']){
            $error = $stateMap[$file['error']];
            $error = $error ? $error : $stateMap['UNKNOWN'];

            throw new PhException($error);
        }

        if ( !is_uploaded_file( $file[ 'tmp_name' ] ) ) {

            throw new PhException($stateMap['UNKNOWN']);
        }

        if( $file['size'] > $maxSize * 1024){
            throw new PhException( $stateMap['SIZE'] );
        }

        $filetype = strtolower( strrchr($file['name'], '.') );
        if( !in_array( $filetype, $allowFiles )){
            throw new PhException( $stateMap['TYPE'] );
        }

        $filename = date('YmdHis') . rand( 1 , 10000 ) . $filetype;

        $storage = new Storage();
        $res = $storage->storageImage($file['tmp_name'], $filename);

        if ( $res['code'] !== 200 ) {
            $error = empty($res['msg']) ? $stateMap['MOVE'] : $res['msg'];
            throw new PhException( $error );
        }

        $filename = $res['msg'];

        return array(
            "originalName" => $file['name'], //原始文件名
            "name" => $filename, //新文件名
            "url" => $this->config->url->img . $filename,
            "size" => $file['size'], //文件大小
            "type" => $filetype , //文件类型
        );
    }

    public function initialize() {
        header('Content-Type:text/html;charset=UTF-8');

        $this->view->disable();
    }

    // 获取验证码
    public function verifyAction(){

        Image::setSession($this->session);
        Image::buildImageVerify(5, 1, 60, 28, $this->config->globalVal->VerifyKey);

        return false;
    }
    
    // 加载裁剪图片组件
    public function loadJcropAction(){
        
        $filename = $this->dispatcher->getParam('file');
        $width = (int)$this->dispatcher->getParam('width');
        $height = (int)$this->dispatcher->getParam('height');

        $param = array(
            'filename' => $filename,
            'cwidth' => $width ? $width : 100,  // 裁剪的宽度
            'cheight' => $height ? $height : 100  // 裁剪的高度
        );
        
        $this->view->partial('common/jcrop', $param);
    }
    
    // 裁剪图片
    public function crupImageAction(){
        try {
            $this->checkAjax();

            $filename = $this->request->getPost('filename');
            if(!$filename){
                throw new PhException('EUploadImageIsEmpty');
            }

            $uploads = $this->config->application->uploadDir;
            $targetFile = $uploads . '/' . $filename;
            $newFile = date('YmdHis') . rand( 1 , 10000 );

            $img = new Image();
            $img->srcX      = intval($this->request->getPost('x'));
            $img->srcY      = intval($this->request->getPost('y'));
            $img->cutWidth  = intval($this->request->getPost('w'));
            $img->cutHeight = intval($this->request->getPost('h'));
            $img->dstWidth  = intval($this->request->getPost('cw'));
            $img->dstHeight = intval($this->request->getPost('ch'));
            $newFile = $img->thumb($targetFile, $newFile, $uploads, false);

            $res = array(
                "originalName" => $filename, //原始文件名
                "name" => $newFile, //新文件名
                "url" => $this->config->url->img . $newFile,
                'code' => 100
            );
            
        } catch (PhException $e) {

            $res = array(
                "originalName" => $filename, //原始文件名
                'code' => 101,
                'msg' => $e->getMessage()
            );
        }

        echo json_encode($res);
    }

    // 上传文件
    public function uploadFileAction(){
        
        try {
            
            $info = $this->uploader('Filedata');
            $info['code'] = 100;
            
        } catch (PhException $e) {

            $info['code'] = 101;
            $info['msg'] = $e->getMessage();
        }

        echo json_encode($info);

        return false;
    }

    //--------------有权限限制---------------
    // 富编辑器上传文件
    public function editorImgUpAction(){

        try {
            
            $info = $this->uploader('upfile');
            $info['state'] = 'SUCCESS';
            
        } catch (PhException $e) {

            $info['state'] = $e->getMessage();
        }

        $callback = isset($_GET['callback']) ? $_GET['callback'] : '';
        if($callback) {
            echo '<script>'.$callback.'('.json_encode($info).')</script>';
        } else {
            echo json_encode($info);
        }

        return false;
    }

    // 更新首页背景图片
    public function changeHomeBgAction(){
        try {

            $this->checkAjax();

            $imgurl = $this->request->getPost('imgurl');
            
            if ( !$imgurl ) {
                throw new PhException('EParamError');
            }

            $backdrop = new Backdrop();
            $backdrop->site = Backdrop::SITE_HOME;
            $backdrop->url = $imgurl;
            $backdrop->create();

            echo Lang::jsonSuccess('SUpdate');

        } catch(PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }
    
    // 更新FM背景图片
    public function changeFmBgAction(){
        try {

            $this->checkAjax();

            $imgurl = $this->request->getPost('imgurl');
            $fid = $this->request->getPost('fid');
            
            if ( !$imgurl ) {
                throw new PhException('EParamError');
            }

            $fm = Fm::findFirst($fid);
            $fm->bg_url = $imgurl;
            if( $fm->update() === false ){
                throw new PhException('ESystemError');
            }
            
            echo Lang::jsonSuccess('SUpdate');

        } catch(PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    // 更新旅游背景图片
    public function changeTourBgAction(){
        try {

            $this->checkAjax();

            $imgurl = $this->request->getPost('imgurl');
            $tid = $this->request->getPost('tid');
            
            if ( !$imgurl ) {
                throw new PhException('EParamError');
            }

            $tour = Tour::findFirst($tid);
            $tour->bg_url = $imgurl;
            if( $tour->update() === false ){
                throw new PhException('ESystemError');
            }
            
            echo Lang::jsonSuccess('SUpdate');

        } catch(PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }
}