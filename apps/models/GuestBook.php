<?php

use \Phalcon\Mvc\Model as PhModel,
    \Phalcon\Exception as PhException;

/**
 * 留言板model
 */
class GuestBook extends PhModel
{
    const CACHE_GBOOK_LIST_KEY = 'CGbook:list:';
    const CACHE_GBOOK_REPLY_KEY = 'CGbook:reply:';
    
    /**
     * 记录ID
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * 内容
     * @Column(type="string", length=450, nullable=false)
     */
    public $content;

    /**
     * 发布时间
     * @Column(type="string", nullable=true)
     */
    public $create_time;

    /**
     * 来源
     * @Column(type="string", length=15, nullable=true)
     */
    public $clinet_ip = '';

    /**
     * 用户Uin
     * @Column(type="integer", nullable=false)
     */
    public $uin = 0;

    /**
     * 父级id
     * @Column(type="integer", nullable=false)
     */
    public $parent_id = 0;

    /**
     * 回复次数
     * @Column(type="integer", nullable=false)
     */
    public $reply_times = 0;
    
    protected function afterCreate(){
        
        if( $this->parent_id ){

            $gbook = self::findFirst( $this->parent_id );
            $gbook->reply_times += 1;
            $gbook->update();
        }
        
        $this->deleteListCache( $this->parent_id );

        return true;
    }

    public function beforeDelete() {

        if ( !$this->parent_id ) {

            $records = self::find(array(
                'parent_id=:id:',
                'bind' => array('id' => $this->id)
            ));

            return $records->delete();
        }

        return true;
    }

    public function afterDelete() {

        $this->deleteListCache( $this->parent_id );

        return true;
    }

    // 删除cache
    protected function deleteListCache( $pid ){
        $cache = $this->getDI()->getModelsCache();
        
        $listCache = $cache->queryKeys(self::CACHE_GBOOK_LIST_KEY);
        foreach($listCache as $val){
            $cache->delete( $val );
        }
        
        if( $pid ){
            $cache->delete( self::CACHE_GBOOK_REPLY_KEY . $pid );
        }
    }

    public function initialize() {
        $this->useDynamicUpdate(true);
    }

    
    /**
     * 获取留言列表
     *
     * @param integer $number 记录数
     * @param integer $offset 步长
     * @return object
     */
    static public function getList($number, $offset){
        $date = new Date();
        
        $param = array(
            'parent_id=0',
            'order' => 'id DESC',
            'limit' => array('number' => $number, 'offset' => $offset),
            'cache' => array('key' => self::CACHE_GBOOK_LIST_KEY . "{$number}:{$offset}")
        );
        $records = self::find($param)->toArray();

        foreach($records as &$record){
            
            $user = UserAccount::getUserAccount( $record['uin'] );
            
            $user->face || $user->face = 'face_default.jpeg';
            
            $record['create_time'] = $date->timeDiff( $record['create_time'] );
            $record['nickname'] = $user->nickname;
            $record['face'] = $user->face;
        }
        
        return $records;
    }
    
    /**
     * 获取留言回复列表
     *
     * @param integer $parent_id 记录数
     * @return array
     */
    static public function getReplyList($parent_id){
        $date = new Date();
        
        $param = array(
            'parent_id=:pid:',
            'bind' => array('pid' => $parent_id),
            'order' => 'id DESC',
            'cache' => array('key' => self::CACHE_GBOOK_REPLY_KEY . $parent_id)
        );
        $records = self::find($param)->toArray();

        foreach($records as &$record){
            
            $user = UserAccount::getUserAccount( $record['uin'] );
            
            $user->face || $user->face = 'face_default.jpeg';
            
            $record['create_time'] = $date->timeDiff( $record['create_time'] );
            $record['nickname'] = $user->nickname;
            $record['face'] = $user->face;
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

        if( $record->parent_id){
            $parent = self::findFirst( $record->parent_id );
            if($parent->reply_times > 0){
                $parent->reply_times -= 1;
                $parent->update();
            }
        }

        return TRUE;
    }
}