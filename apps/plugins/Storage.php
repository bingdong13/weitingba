<?php

class Storage extends \Phalcon\Mvc\User\Plugin
{
    const STORAGE_LOCAL = 'local';
    const STORAGE_QINIU = 'qiniu';

    /**
     * 本地上传
     */
    public function storage2local($targetFile, $newFile){

        $uploads = $this->config->application->uploadDir; //存储文件夹
        $fullname = $uploads . '/' . $newFile;

        if ( move_uploaded_file( $targetFile, $fullname ) ) {
            
            return array('code' => 200, 'msg' => $newFile);
        }

        return array('code' => 201, 'msg' => '');
    }

    /**
     * 七牛云服务上传
     * $type string: 字符串; file: 文件;
     */
    public function storage2qiniu($targetFile, $newFile, $type='file'){

        require_once(APP_PATH . '/sdk/qiniu/io.php');
        require_once(APP_PATH . '/sdk/qiniu/rs.php');

        // 存储空间名称
        $bucket = 'img-wtb';

        // 上传凭证
        $putPolicy = new Qiniu_RS_PutPolicy($bucket);
        $upToken = $putPolicy->Token(null);

        if($type=='file'){
            $putExtra = new Qiniu_PutExtra();
            $putExtra->Crc32 = 1;
            list($ret, $err) = Qiniu_PutFile($upToken, $newFile, $targetFile, $putExtra);
        }else{
            list($ret, $err) = Qiniu_Put($upToken, $newFile, $targetFile, null);
        }

        if ($err !== null) {

            return array('code' => $err['code'], 'msg' => $err['error']);
        }

        return array('code' => 200, 'msg' => $ret['key']);
    }

    public function storageImage($targetFile, $newFile, $type='file'){

        switch( STORAGE ){
            case self::STORAGE_QINIU :
                $res = $this->storage2qiniu($targetFile, $newFile, $type);
                break;
            default :
                $res = $this->storage2local($targetFile, $newFile);
                break;
        }

        return $res;
    }

}
