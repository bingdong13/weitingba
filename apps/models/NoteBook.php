<?php

use \Phalcon\Mvc\Model as PhModel,
    \Phalcon\Exception as PhException;

/**
 * 笔记model
 */
class NoteBook extends PhModel
{
    const CACHE_NOTE_LIST_KEY = 'CNotebook:list:';
    const CACHE_NOTE_KEY = 'CNotebook:note:';
    const CACHE_NOTE_TIMES_KEY = 'CNotebook:read:times:';
    
    /**
     * 记录ID
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * 标题
     * @Column(type="string", length=100, nullable=false)
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
     * 内容
     * @Column(type="string", nullable=true)
     */
    public $content;

    /**
     * 来源
     * @Column(type="string", length=90, nullable=true)
     */
    public $comeform;

    /**
     * 发布时间
     * @Column(type="string", nullable=true)
     */
    public $create_time;

    /**
     * 更新时间
     * @Column(type="string", nullable=true)
     */
    public $update_time;

    /**
     * 阅读次数
     * @Column(type="integer", nullable=false)
     */
    public $access_times = 0;

    /**
     * 状态
     * @Column(type="integer", nullable=false)
     */
    public $status = 0;

    /**
     * 所属类别
     * @Column(type="integer", nullable=false)
     */
    public $category_id;

    protected function beforeSave(){
        $this->update_time = date('Y-m-d H:i:s');
    }
    
    protected function afterCreate(){
        $this->deleteListCache();

        // 更新分类的条目数
        $category = Category::findFirst( $this->category_id );
        $category->numbers += 1;
        $category->update();

        return true;
    }

    protected function afterUpdate(){
        $this->deleteListCache();

        return true;
    }

    protected function afterDelete() {
        $this->deleteListCache();

        // 更新分类的条目数
        $category = Category::findFirst( $this->category_id );
        if($category->numbers > 0){
            $category->numbers -= 1;
            $category->update();
        }

        return true;
    }

    // 删除cache
    protected function deleteListCache(){
        $cache = $this->getDI()->getModelsCache();
        
        $listCache = $cache->queryKeys(self::CACHE_NOTE_LIST_KEY);
        foreach($listCache as $val){
            $cache->delete( $val );
        }

        $singleCache = $cache->queryKeys(self::CACHE_NOTE_KEY . $this->id);
        foreach($singleCache as $val){
            $cache->delete( $val );
        }
    }

    public function initialize() {
        $this->useDynamicUpdate(true);
    }

    /**
     * 获取记录
     *
     * @param integer $nid 记录ID
     * @return object
     */
    static public function get($nid){

        if( !intval($nid) ){
            return null;
        }

        return self::findFirst(array(
            'id=:nid: and status=:status:',
            'bind' => array('nid' => $nid, 'status' => 1 ),
            'cache' => array('key' => self::CACHE_NOTE_KEY . $nid)
        ));
    }

    /**
     * 获取上一条记录
     *
     * @param integer $nid 记录ID
     * @return object
     */
    static public function getPrevious($nid){

        if( !intval($nid) ){
            return null;
        }

        return self::findFirst(array(
            'id=:nid: and status=:status:',
            'bind' => array('nid' => $nid, 'status' => 1 ),
            'order' => 'id DESC',
            'cache' => array('key' => self::CACHE_NOTE_KEY . $nid . ':previous')
        ));
    }
    

    /**
     * 获取下一条记录
     *
     * @param integer $nid 记录ID
     * @return object
     */
    static public function getNext($nid){

        if( !intval($nid) ){
            return null;
        }

        return self::findFirst(array(
            'id=:nid: and status=:status:',
            'bind' => array('nid' => $nid, 'status' => 1 ),
            'cache' => array('key' => self::CACHE_NOTE_KEY . $nid . ':next')
        ));
    }
    
    /**
     * 获取笔记列表
     *
     * @param integer $number 记录数
     * @param integer $offset 步长
     * @param integer $category 类别Id
     * @return array
     */
    public function getList($number, $offset, $category){
        $param = array(
            'order' => 'id DESC',
            'limit' => array('number' => $number, 'offset' => $offset),
            'cache' => array('key' => self::CACHE_NOTE_LIST_KEY . "{$category}:{$number}:{$offset}")
        );

        if($category){
            $param[] = 'category_id=:cid: and status=:status:';
            $param['bind'] = array('cid' => $category, 'status' => 1);
        }else{
            $param[] = 'status=:status:';
            $param['bind'] = array('status' => 1);
        }

        $records = $this->find($param);
        if( !$records ){
            return array();
        }

        $records = $records->toArray();

        $cache = $this->getDI()->getModelsCache();
        $categorys = Category::getList( Category::CHANNEL_NOTEBOOK );
        $date = new Date();

        foreach($records as &$row){
            $cachekey = self::CACHE_NOTE_TIMES_KEY . $row['id'];
            $row['access_times'] += $cache->get( $cachekey );

            $row['create_time'] = $date->timeDiff($row['create_time']);
            $row['category_name'] = $categorys[$row['category_id']]['title'];
        }
        
        return $records;
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
     * 增加阅读次数
     * 
     * @param integer $id 记录ID
     * @param integer $times 阅读次数
     * @return integer 返回最新阅读次数
     */
    public function increment($id, $times=1){
        $maxSize = 5; // cache中累加次数最大值

        $cache = $this->getDI()->getModelsCache();

        $key = self::CACHE_NOTE_TIMES_KEY . $id;

        if( $cache->exists($key) ){
            $times += $cache->get( $key );

            // 当cache中次数达到最大值时，更新db
            // 并重置cache中次数为0。
            if($times > $maxSize){
                $zine = $this->findFirst($id);
                $zine->access_times += $times;
                $zine->update();

                $cache->save($key, 0);
            }else{
                $times = $cache->increment($key);
            }
        }else{
            $cache->save($key, $times);
        }

        return $times;
    }
    
    /**
     * 更新记录所属分类
     * 
     * @param integer $sid 记录ID
     * @param integer $newCategory 新分类ID
     * @return boolean
     * @throws PhException
     */
    public function updateCategory($sid, $newCategory){
        
        $record = $this->findFirst($sid);

        if( !$record ){
            throw new PhException('EShareNotExist');
        }
        
        $oldCategory = $record->category_id;
        
        $record->category_id = $newCategory;
        if( $record->update() === false ){
            throw new PhException('ESystemError');
        }

        // 更新分类的条目数
        $category = Category::findFirst( $oldCategory );
        if($category->numbers > 0){
            $category->numbers -= 1;
            $category->update();
        }
        
        $category = Category::findFirst( $newCategory );
        $category->numbers += 1;
        $category->update();

        return TRUE;
    }
}