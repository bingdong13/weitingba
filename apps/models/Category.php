<?php

use \Phalcon\Mvc\Model as PhModel,
    \Phalcon\Exception as PhException;

/**
 * 类别model
 */
class Category extends PhModel
{
    const CHANNEL_SHARED = 1; // 语录
    const CHANNEL_NOTEBOOK = 2; // 笔记
    const CHANNEL_MAGAZINE = 3; //杂志
    const CHANNEL_FM = 4; //FM

    const CACHE_CATEGORY_LIST_KEY = 'CCategory:list:';
    
    /**
     * 分类ID
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * 标题
     * @Column(type="string", length=60, nullable=false)
     */
    public $title;

    /**
     * 关键字
     * @Column(type="string", length=150, nullable=true)
     */
    public $keywords;

    /**
     * 简介
     * @Column(type="string", length=255, nullable=true)
     */
    public $description;

    /**
     * 缩略图
     * @Column(type="string", length=255, nullable=true)
     */
    public $face_url;

    /**
     * 排序
     * @Column(type="integer", nullable=false)
     */
    public $sort = 0;

    /**
     * 条目数
     * @Column(type="integer", nullable=false)
     */
    public $numbers = 0;

    /**
     * 创建时间
     * @Column(type="string", nullable=true)
     */
    public $create_time;

    /**
     * 所属频道
     * @Column(type="integer", nullable=false)
     */
    public $channel_id = 0;

    static public $channel = array(
        self::CHANNEL_SHARED => '语录',
        self::CHANNEL_NOTEBOOK => '笔记',
        self::CHANNEL_MAGAZINE => '杂志',
        self::CHANNEL_FM => 'FM'
    );

    protected function afterSave(){
        $cache = $this->getDI()->getModelsCache();
        $cache->delete( self::CACHE_CATEGORY_LIST_KEY . $this->channel_id );
    }

    public function initialize() {
        $this->useDynamicUpdate(true);
    }

    /**
     * 获取分类列表
     *
     * @param integer $channel 所属频道
     * @return object
     */
    static public function getList($channel){
        $result = array();

        if( empty($channel) ){
            return $result;
        }

        $param = array(
            'channel_id=:cid:',
            'bind' => array('cid' => $channel),
            'order' => 'sort',
            'cache' => array('key' => self::CACHE_CATEGORY_LIST_KEY . $channel)
        );
        
        $categorys = self::find($param)->toArray();

        foreach($categorys as $category){
            $result[$category['id']] = $category;
        }
        
        return $result;
    }

    /**
     * 获取二维数组列表
     *
     * @param integer $channel 所属频道
     * @param integer $size 每维的大小
     * @return array
     */
    static public function getMultiList($channel, $size){

        $result = array();
        $categorys = self::getList( $channel );

        if(count($categorys) > $size){
            foreach($categorys as $key => $row){
                $page = $key / $size;
                $result[$page][] = $row;
            }
        }else{
            $result[] = $categorys;
        }

        unset($categorys);

        return $result;
    }
}