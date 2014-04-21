<?php

use \Phalcon\Mvc\Model as PhModel,
    \Phalcon\Exception as PhException;

/**
 * 布告板 model
 */
class TourPhoto extends PhModel
{
    const CACHE_TOUR_PHOTO_LIST_KEY = 'CTourphoto:list:tour:';
    
    /**
     * 记录ID
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * 所属旅游主题
     * @Column(type="integer", nullable=false)
     */
    public $tour_id;
    
    /**
     * 图片URL
     * @Column(type="string", length=255, nullable=true)
     */
    public $url;

    /**
     * 简介
     * @Column(type="string", nullable=true)
     */
    public $description;

    /**
     * 排序
     * @Column(type="integer", nullable=true)
     */
    public $sort=1;

    protected function afterSave() {

        $cache = $this->getDI()->getModelsCache();
  
        $cache->delete( self::CACHE_TOUR_PHOTO_LIST_KEY . $this->tour_id );

        return true;
    }

    protected function afterDelete() {

        $cache = $this->getDI()->getModelsCache();
  
        $cache->delete( self::CACHE_TOUR_PHOTO_LIST_KEY . $this->tour_id );

        return true;
    }

    public function initialize() {}

    /**
     * 获取单条记录
     *
     * @param integer $nid 记录ID
     * @return object
     */
    static public function getList($tid){

        if( !intval($tid) ){
            return null;
        }

        return self::find(array(
            'tour_id=:tid:',
            'bind' => array('tid' => $tid ),
            'order' => 'sort, id DESC',
            'cache' => array('key' => self::CACHE_TOUR_PHOTO_LIST_KEY . $tid)
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

    /**
     * 删除记录，按主题
     * 
     * @param integer $nid 记录ID
     * @return boolean
     */
    public function deleteByTour($tid){

        $modelsManager = $this->getDI()->getModelsManager();
        $phql = "DELETE FROM TourPhoto WHERE TourPhoto.tour_id = {$tid}";
        $modelsManager->executeQuery($phql);

        return TRUE;
    }
}