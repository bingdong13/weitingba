<?php

class Lang
{
    static private $_lang = array();
    
    static private function _loadLang(){
        if (!self::$_lang) {
            self::$_lang = require(APP_PATH . '/config/lang.php');
        }
        
        return self::$_lang;
    }
    
    /**
     * 提示语
     * 
     * @param string $kstr
     * @return string
     */
    static public function tip( $kstr ){
        self::_loadLang();

        return isset(self::$_lang[$kstr]) ? self::$_lang[$kstr] : '';
    }

    /**
     * 错误信息
     * 
     * @param string $kstr
     * @param string $ref 跳转URL
     * @return array
     */
    static public function error($kstr, $ref='') {
        
        self::_loadLang();
        
        $result = array('code' => 101, 'ref' => $ref);

        $result['msg'] = isset(self::$_lang[$kstr]) ? self::$_lang[$kstr] : 'system error';

        return $result;
    }
    
    /**
     * 成功信息
     * 
     * @param string $kstr
     * @param string $ref 跳转URL
     * @return array
     */
    static public function success($kstr, $ref='') {
        
        self::_loadLang();
        
        $result = array('code' => 100, 'ref' => $ref);
        
        $result['msg'] = isset(self::$_lang[$kstr]) ? self::$_lang[$kstr] : '';

        return $result;
    }
    
    static public function jsonError($kstr, $ref=''){
        
        return json_encode( self::error($kstr, $ref) );
    }

    static public function jsonSuccess($kstr, $ref=''){

        return json_encode( self::success($kstr, $ref) );
    }

}