<?php

use \Phalcon\Mvc\Model as PhModel,
    \Phalcon\Exception as PhException;

/**
 * 语录model
 */
class Shared extends PhModel
{
    const CACHE_SHARE_LIST_KEY = 'CShared:list:';
    const CACHE_SHARE_TOP_KEY = 'CShared:top:';
    
    /**
     * 记录ID
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * 内容
     * @Column(type="string", length=450, nullable=true)
     */
    public $content;

    /**
     * 发布时间
     * @Column(type="string", nullable=true)
     */
    public $create_time;

    /**
     * 所属类别
     * @Column(type="integer", nullable=false)
     */
    public $category_id;

    /**
     * 是否推荐
     * @Column(type="integer", nullable=true)
     */
    public $is_top=0;
    
    protected function afterCreate(){

        // 更新分类的条目数
        $category = Category::findFirst( $this->category_id );
        $category->numbers += 1;
        $category->update();

        $this->deleteListCache();

        return true;
    }

    protected function afterDelete() {
        
        // 更新分类的条目数
        $category = Category::findFirst( $this->category_id );
        if($category->numbers > 0){
            $category->numbers -= 1;
            $category->update();
        }

        $this->deleteListCache();

        return true;
    }

    // 删除cache
    protected function deleteListCache(){
        $cache = $this->getDI()->getModelsCache();
        
        $listCache = $cache->queryKeys(self::CACHE_SHARE_LIST_KEY);
        foreach($listCache as $val){
            $cache->delete( $val );
        }

        if( $this->is_top ){
            $cache->delete( self::CACHE_SHARE_TOP_KEY );
        }
    }

    public function initialize() {
        $this->useDynamicUpdate(true);
    }

    /**
     * 获取推荐语录列表
     * @param integer $number 记录数
     * @return array
     */
    static public function getTops($number=1){
        $param = array(
            'is_top=:istop:',
            'bind' => array('istop' => 1),
            'order' => 'id DESC',
            'cache' => array('key' => self::CACHE_SHARE_TOP_KEY . "$number")
        );

        if($number>1){
            $param['limit'] = array('number' => $number, 'offset' => 0);
            $shareds = self::find($param);
        }else{
            $shareds = self::findFirst($param);
        }
        
        return $shareds;
    }
    
    /**
     * 获取分享列表
     * @param integer $number 记录数
     * @param integer $offset 步长
     * @param integer $category 类别Id
     * @return array
     */
    static public function getList($number, $offset, $category){
        $param = array(
            'order' => 'id DESC',
            'limit' => array('number' => $number, 'offset' => $offset),
            'cache' => array('key' => self::CACHE_SHARE_LIST_KEY . "{$category}:{$number}:{$offset}")
        );

        if($category){
            $param[] = 'category_id=:cid:';
            $param['bind'] = array('cid' => $category );
        }
        
        $records = self::find($param)->toArray();

        $categorys = Category::getList(Category::CHANNEL_SHARED);

        $date = new Date();
        foreach($records as &$record){
            $record['create_time'] = $date->timeDiff($record['create_time']);
            $record['category_face'] = $categorys[$record['category_id']]['face_url'];
            $record['category_name'] = $categorys[$record['category_id']]['title'];
        }
        
        return $records;
    }
    
    /**
     * 删除记录
     * 
     * @param integer $sid 记录ID
     * @return boolean
     * @throws PhException
     */
    static public function del($sid){
        
        $record = self::findFirst($sid);

        if( !$record ){
            throw new PhException('EShareNotExist');
        }

        if( $record->delete() === false ){
            throw new PhException('ESystemError');
        }

        return TRUE;
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
        
        $this->deleteListCache();

        return TRUE;
    }
}