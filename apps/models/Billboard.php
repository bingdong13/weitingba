<?php

use \Phalcon\Mvc\Model as PhModel,
    \Phalcon\Exception as PhException;

/**
 * 布告板 model
 */
class Billboard extends PhModel
{
    const CACHE_BOARD_LAST_KEY = 'CBoard:last';
    
    /**
     * 记录ID
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;
    
    /**
     * 缩略图
     * @Column(type="string", length=255, nullable=true)
     */
    public $face_url;

    /**
     * 外链
     * @Column(type="string", length=155, nullable=true)
     */
    public $link_url;

    /**
     * 签名
     * @Column(type="string", length=100, nullable=true)
     */
    public $sign;

    /**
     * 内容
     * @Column(type="string", nullable=true)
     */
    public $content;

    /**
     * 发布时间
     * @Column(type="string", nullable=true)
     */
    public $create_time;

    protected function afterSave(){
        $this->deleteListCache();

        return true;
    }

    protected function afterDelete() {
        $this->deleteListCache();

        return true;
    }

    // 删除cache
    protected function deleteListCache(){
        $cache = $this->getDI()->getModelsCache();
  
        $cache->delete( self::CACHE_BOARD_LAST_KEY );
    }

    public function initialize() {
        $this->useDynamicUpdate(true);
    }

    /**
     * 获取最新一条记录
     * 
     * @return object
     */
    static public function getLast(){

        return self::findFirst(array(
            'order' => 'id DESC',
            'cache' => array('key' => self::CACHE_BOARD_LAST_KEY)
        ));
    }
    
    /**
     * 删除记录
     * 
     * @param integer $nid 记录ID
     * @return boolean
     */
    static public function del($nid){
        
        $record = self::findFirst($nid);

        if( !$record ){
            throw new PhException('EShareNotExist');
        }

        if( $record->delete() === false ){
            throw new PhException('ESystemError');
        }

        return TRUE;
    }
}