<?php

class Page {
    
    // 分页栏每页显示的页数
    public $rollPage = 5;
    
    // 分页栏的总页数
    protected $coolPages = 0;
    
    //当前分页栏页数
    protected $nowCoolPage = 1;
    
    // 总行数
    protected $totalRows = 0;
    
    // 默认列表每页显示行数
    protected $listRows = 20;
    
    // 分页总页面数
    protected $totalPages = 0;
    
    // 当前页数
    protected $nowPage = 1;

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param integer $totalRows  总的记录数
     * @param integer $listRows  每页显示记录数
     * @param integer $nowPag  当前页数
     +----------------------------------------------------------
     */
    public function __construct($totalRows, $nowPag = 1, $listRows = 0) {
        $this->totalRows = $totalRows;
        $this->listRows  = $listRows ? intval($listRows) : $this->listRows;
        $this->nowPage   = intval($nowPag) ? $nowPag : 1;

        $this->totalPages = ceil($this->totalRows / $this->listRows); // 分页总页面数
        $this->coolPages  = ceil($this->totalPages / $this->rollPage); // 分页栏的总页数
        
        if ($this->totalPages && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        
        $this->nowCoolPage = ceil($this->nowPage / $this->rollPage);
    }

    public function showByUrl($url) {
        $url = rtrim($url, '/')  . '/';
        
        $href = 'href="'. rtrim($url, '/')  . '/%page%"';
        
        return $this->_show($href);
    }
    
    public function showByAjax($func){
        $href = 'href="javascript:void(0);" onclick="'. $func .'(%page%);"';
        
        return $this->_show($href);
    }
    
    /**
     +----------------------------------------------------------
     * 分页显示输出
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     */
    private function _show($href){
        if (0 == $this->totalRows || $this->totalPages <= 1){
            return '';
        }
        
        $pageStr = '<ul>';
        
        // 第一页、上Num页字符串
        if($this->nowCoolPage > 1){
            $pageStr .= '<li><a title="第1页" '. str_replace('%page%', 1, $href) .'>1</a></li>';
            $pageStr .= '<li><span>...</span></li>';
            
            $prevRow = ($this->nowCoolPage-1) * $this->rollPage; // 上一分页栏最后一页
            if( $this->nowPage > $prevRow+1){
                $pageStr .= '<li><a title="第'. $prevRow .'页" '. str_replace('%page%', $prevRow, $href) .'>&laquo;&laquo;</a></li>';
            }
        }

        // 上翻页字符串
        $upRow = $this->nowPage - 1;
        if($this->nowCoolPage>1 && $upRow > 0){
            $pageStr .= '<li><a title="上一页" '. str_replace('%page%', $upRow, $href) .'>&laquo;</a></li>';
        }
        
        // 链接字符串
        if ($this->coolPages == 1) { //当就只有一栏时
            $this->rollPage = $this->totalPages;
            $startPage = 0;
        } else if ($this->nowCoolPage == $this->coolPages) { //最后一栏时
            $startPage = $this->totalPages - $this->rollPage;
        } else {
            $startPage = ($this->nowCoolPage - 1) * $this->rollPage;
        }

        for ($i = 1; $i <= $this->rollPage; $i++) {
            $page = $startPage + $i;
            
            if ($page == $this->nowPage) {
                $pageStr .= '<li class="active"><span>'. $page .'</span></li>';
            }else{
                $pageStr .= '<li><a title="第'. $page .'页" '. str_replace('%page%', $page, $href) .'>'. $page .'</a></li>';
            }
        }
        
        // 下翻页字符串
        $downRow = $this->nowPage + 1;
        if($this->nowCoolPage < $this->coolPages && $downRow <= $this->totalPages){
            $pageStr .= '<li><a title="下一页" '. str_replace('%page%', $downRow, $href) .'>&raquo;</a></li>';
        }
        
        // 后N页、最后一页字符串
        if($this->nowCoolPage < $this->coolPages){
            $nextRow = $this->nowCoolPage * $this->rollPage + 1; // 下一分页栏第一页
            
            if( $this->nowPage < $nextRow-1){
                $pageStr .= '<li><a title="第'. $nextRow .'页" '. str_replace('%page%', $nextRow, $href) .'>&raquo;&raquo;</a></li>';
            }
            $pageStr .= '<li><span>...</span></li>';

            $pageStr .= '<li><a title="第'. $this->totalPages .'页" '. str_replace('%page%', $this->totalPages, $href) .'>'. $this->totalPages .'</a></li>';
        }
        
        $pageStr .= '</ul>';
        
        return $pageStr;
    }
}
