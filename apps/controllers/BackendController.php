<?php

use \Phalcon\Exception as PhException;

class BackendController extends ControllerBase
{
    private function _initUmeditor(){
        $this->style->addCss('/umeditor/themes/default/css/umeditor.css');
        $this->script->addJs('/umeditor/umeditor.config.js')
                ->addJs('/umeditor/umeditor.min.js');
    }

    private function _initUploadify(){
        $this->style->addCss('/uploadify/uploadify.css');
        $this->script->addJs('/uploadify/jquery.uploadify.min.js')
                ->addJs('/uploadify/jquery.Jcrop.min.js');   
    }

    public function initialize() {
        parent::initialize();

        $this->style->addCss('/css/backend.css');
        $this->script->addJs('/js/backend.js');

        $this->tag->prependTitle('栏目管理');
    }

    public function indexAction(){
        $this->view->disable();
        echo '后台管理';
    }
    
    public function boardAction(){

        $param = $this->dispatcher->getParams();
        $cpage = intval($param[0]) ? $param[0] : 1;

        $total_items = Billboard::count();
        if( $total_items ){
            
            $listRows = 30;
            $offset   = ($cpage -1) * $listRows;

            $records = Billboard::find(array(
                'order' => 'id DESC',
                'limit' => array('number' => $listRows, 'offset' => $offset)
            ));

            $page = new Page ($total_items, $cpage, $listRows);
            $pnav = $page->showByUrl($this->url->get('backend/board'));
        }else{
            $records = array();
            $pnav = '';
        }

        $this->view->setVar('records', $records);
        $this->view->setVar('pagenav', $pnav);
        $this->view->setVar('ptitle', Lang::tip('TBoard') );
    }

    public function addBoardAction(){

        $this->_initUploadify();

        $this->view->setVar('ptitle',  Lang::tip('TAddBoard') );
    }

    public function editBoardAction(){
        
        $param = $this->dispatcher->getParams();
        if( !intval($param[0]) ){
            $this->forward('error/show404');
            return false;
        }

        $record = Billboard::findFirst($param[0]);
        if( empty($record) ){
            $this->forward('error/show404');
            return false;
        }

        $this->_initUploadify();
        
        $this->view->setVar('ptitle',  Lang::tip('TEditBoard') );
        $this->view->setVar('record', $record);
    }

    public function saveBoardAction(){
        try {

            $this->checkAjax();

            $info = $this->request->getPost('info');
            
            if ( !$info ) {
                throw new PhException('EParamError');
            }

            $board = new Billboard();
            if($board->save($info) === false){
                throw new PhException('ESystemError');
            }

            echo Lang::jsonSuccess('SPublish');
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }
    }

    public function categoryAction(){

        $this->view->setVar('ptitle',  Lang::tip('TCategory') );

        $param = $this->dispatcher->getParams();
        $cid = intval($param[0]) ? $param[0] : 1;

        $this->view->setVar('curr_cid', $cid);
        $this->view->setVar('channels', Category::$channel);
        $this->view->setVar('categorys', Category::getList($cid));
    }

    public function addCategoryAction(){

        $this->_initUploadify();

        $this->view->setVar('ptitle',  Lang::tip('TAddCategory') );
        $this->view->setVar('channel', Category::$channel );
    }

    public function editCategoryAction(){
        
        $param = $this->dispatcher->getParams();
        if( !intval($param[0]) ){
            $this->forward('error/show404');
            return false;
        }

        $category = Category::findFirst($param[0]);
        if( empty($category) ){
            $this->forward('error/show404');
            return false;
        }

        $this->_initUploadify();
        
        $this->view->setVar('ptitle',  Lang::tip('TEditCategory') );
        $this->view->setVar('category', $category);
    }

    public function saveCategoryAction(){
        try {

            $this->checkAjax();

            $info = $this->request->getPost('info');
            
            if ( !$info ) {
                throw new PhException('EParamError');
            }

            
            if(isset($info['id']) && $info['id'] > 0){
                $category = Category::findFirst($info['id']);
                $res = $category->update($info);
            }else{
                $category = new Category();
                $res = $category->create($info);
            }
            
            if( $res === false){
                throw new PhException('ESystemError');
            }
            
            echo Lang::jsonSuccess('SPublish');
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }
    }

    public function notebookAction(){

        $param = $this->dispatcher->getParams();
        $cpage = intval($param[0]) ? $param[0] : 1;

        $total_items = NoteBook::count();
        if( $total_items ){
            
            $listRows = 30;
            $offset   = ($cpage -1) * $listRows;

            $records = NoteBook::find(array(
                'order' => 'id DESC',
                'limit' => array('number' => $listRows, 'offset' => $offset)
            ));

            $page = new Page ($total_items, $cpage, $listRows);
            $pnav = $page->showByUrl($this->url->get('backend/notebook'));
        }else{
            $records = array();
            $pnav = '';
        }

        $this->view->setVar('ptitle', Lang::tip('TNotebook') );
        $this->view->setVar('records', $records);
        $this->view->setVar('pagenav', $pnav);
    }

    public function addNoteAction(){
        
        $this->_initUmeditor();
        
        $this->view->setVar('ptitle', Lang::tip('TAddNote') );
        $this->view->setVar('categorys', Category::getList( Category::CHANNEL_NOTEBOOK ) );
    }

    public function editNoteAction(){
        $param = $this->dispatcher->getParams();
        if( !intval($param[0]) ){
            $this->forward('error/show404');
            return false;
        }

        $note = NoteBook::findFirst($param[0]);
        if( empty($note) ){
            $this->forward('error/show404');
            return false;
        }

        $this->_initUmeditor();

        $this->view->setVar('ptitle', Lang::tip('TEditNote') );
        $this->view->setVar('note', $note);
    }

    public function saveNoteAction() {
        
        try {

            $this->checkAjax();

            $info = $this->request->getPost('info');
            $content = $this->request->getPost('umcontent');

            if ( !$info ) {
                throw new PhException('EParamError');
            }

            $info['content'] = $content;
            
            if(isset($info['id']) && $info['id'] > 0){
                $note = NoteBook::findFirst($info['id']);
                $res = $note->update($info);
            }else{
                $note = new NoteBook();
                $res = $note->create($info);
            }
            
            if( $res === false){
                throw new PhException('ESystemError');
            }

            echo Lang::jsonSuccess('SPublish');
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    public function magazineAction(){

        $param = $this->dispatcher->getParams();
        $cpage = intval($param[0]) ? $param[0] : 1;

        $total_items = Magazine::count();
        if( $total_items ){
            
            $listRows = 30;
            $offset   = ($cpage -1) * $listRows;

            $records = Magazine::find(array(
                'order' => 'id DESC',
                'limit' => array('number' => $listRows, 'offset' => $offset)
            ));

            $page = new Page ($total_items, $cpage, $listRows);
            $pnav = $page->showByUrl($this->url->get('backend/magazine'));
        }else{
            $records = array();
            $pnav = '';
        }

        $this->view->setVar('ptitle', Lang::tip('TMagazine') );
        $this->view->setVar('records', $records);
        $this->view->setVar('pagenav', $pnav);
    }

    public function addMagazineAction(){

        $this->_initUmeditor();
        $this->_initUploadify();
        
        $this->view->setVar('ptitle', Lang::tip('TAddMagazine') );
        $this->view->setVar('categorys', Category::getList( Category::CHANNEL_MAGAZINE ) );
    }

    public function editMagazineAction(){
        $param = $this->dispatcher->getParams();
        if( !intval($param[0]) ){
            $this->forward('error/show404');
            return false;
        }

        $zine = Magazine::findFirst($param[0]);
        if( empty($zine) ){
            $this->forward('error/show404');
            return false;
        }

        $this->_initUmeditor();
        $this->_initUploadify();
        
        $this->view->setVar('ptitle', Lang::tip('TEditMagazine') );
        $this->view->setVar('zine', $zine);
    }

    public function saveMagazineAction() {
        
        try {

            $this->checkAjax();

            $info = $this->request->getPost('info');
            $content = $this->request->getPost('umcontent');

            if ( !$info ) {
                throw new PhException('EParamError');
            }

            $info['content'] = $content;

            if(isset($info['id']) && $info['id'] > 0){
                $zine = Magazine::findFirst($info['id']);
                $res = $zine->update($info);
            }else{
                $zine = new Magazine();
                $res = $zine->create($info);
            }
            
            if( $res === false){
                throw new PhException('ESystemError');
            }
            
            echo Lang::jsonSuccess('SPublish');
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    public function fmAction(){

        $param = $this->dispatcher->getParams();
        $cpage = intval($param[0]) ? $param[0] : 1;

        $total_items = Fm::count();
        if( $total_items ){
            
            $listRows = 30;
            $offset   = ($cpage -1) * $listRows;

            $records = Fm::find(array(
                'order' => 'id DESC',
                'limit' => array('number' => $listRows, 'offset' => $offset)
            ));

            $page = new Page ($total_items, $cpage, $listRows);
            $pnav = $page->showByUrl($this->url->get('backend/fm'));
        }else{
            $records = array();
            $pnav = '';
        }

        $this->view->setVar('ptitle', Lang::tip('TFm') );
        $this->view->setVar('records', $records);
        $this->view->setVar('pagenav', $pnav);
    }
    
    public function addFmAction(){

        $this->_initUmeditor();
        $this->_initUploadify();
        
        $this->view->setVar('ptitle', Lang::tip('TAddFM') );
        $this->view->setVar('categorys', Category::getList( Category::CHANNEL_FM ) );
        $this->view->setVar('fmType', Fm::$fmType );
    }

    public function editFmAction(){
        $param = $this->dispatcher->getParams();
        if( !intval($param[0]) ){
            $this->forward('error/show404');
            return false;
        }

        $fm = Fm::findFirst($param[0]);
        if( empty($fm) ){
            $this->forward('error/show404');
            return false;
        }

        $this->_initUmeditor();
        $this->_initUploadify();
        
        $this->view->setVar('ptitle', Lang::tip('TEditFM') );
        $this->view->setVar('fmType', Fm::$fmType );
        $this->view->setVar('fm', $fm);
    }

    public function saveFmAction() {
        
        try {

            $this->checkAjax();

            $info = $this->request->getPost('info');
            $content = $this->request->getPost('umcontent');

            if ( !$info ) {
                throw new PhException('EParamError');
            }

            $info['content'] = $content;

            if(isset($info['id']) && $info['id'] > 0){
                $fm = Fm::findFirst($info['id']);
                $res = $fm->update($info);
            }else{
                $fm = new Fm();
                $res = $fm->create($info);
            }
            
            if( $res === false){
                throw new PhException('ESystemError');
            }

            echo Lang::jsonSuccess('SPublish');
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    public function tourAction(){

        $param = $this->dispatcher->getParams();
        $cpage = intval($param[0]) ? $param[0] : 1;

        $total_items = Tour::count();
        if( $total_items ){
            
            $listRows = 30;
            $offset   = ($cpage -1) * $listRows;

            $records = Tour::find(array(
                'order' => 'sort, id DESC',
                'limit' => array('number' => $listRows, 'offset' => $offset)
            ));

            $page = new Page ($total_items, $cpage, $listRows);
            $pnav = $page->showByUrl($this->url->get('backend/tour'));
        }else{
            $records = array();
            $pnav = '';
        }

        $this->view->setVar('ptitle', Lang::tip('TTour') );
        $this->view->setVar('records', $records);
        $this->view->setVar('pagenav', $pnav);
    }

    public function addTourAction(){

        $this->_initUploadify();
        
        $this->view->setVar('ptitle', Lang::tip('TAddTour') );
    }

    public function editTourAction(){
        $param = $this->dispatcher->getParams();
        if( !intval($param[0]) ){
            $this->forward('error/show404');
            return false;
        }

        $tour = Tour::findFirst($param[0]);
        if( empty($tour) ){
            $this->forward('error/show404');
            return false;
        }

        $this->_initUploadify();
        
        $this->view->setVar('ptitle', Lang::tip('TEditMagazine') );
        $this->view->setVar('tour', $tour);
    }

    public function saveTourAction() {
        
        try {

            $this->checkAjax();

            $info = $this->request->getPost('info');

            if ( !$info ) {
                throw new PhException('EParamError');
            }

            if(isset($info['id']) && $info['id'] > 0){
                $tour = Tour::findFirst($info['id']);
                $res = $tour->update($info);
            }else{
                $tour = new Tour();
                $res = $tour->create($info);
            }
            
            if( $res === false){
                throw new PhException('ESystemError');
            }

            echo Lang::jsonSuccess('SPublish');
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    public function delTourAction() {

        $tid = $this->request->getPost('tid', 'int', 0);

        try {
            
            $this->checkAjax();
            
            if( !$tid ){
                throw new PhException('EParamError');
            }

            Tour::del($tid);

            echo Lang::jsonSuccess('SDelete');
            
        } catch (PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    public function tourphotoAction(){

        $param = $this->dispatcher->getParams();
        if( !intval($param[0]) ){
            $this->forward('error/show404');
            return false;
        }

        $tour = Tour::findFirst($param[0]);
        if( empty($tour) ){
            $this->forward('error/show404');
            return false;
        }

        $this->_initUploadify();
        
        $this->view->setVar('ptitle', $tour->title . ' 详情' );
        $this->view->setVar('records', TourPhoto::getList($param[0]));
        $this->view->setVar('curr_tour', $param[0]);
    }

    public function saveTourPhotoAction() {
        
        try {

            $this->checkAjax();

            $pid = $this->request->getPost('pid', 'int', 0);
            $info['tour_id'] = $this->request->getPost('tour', 'int', 0);
            $info['sort'] = $this->request->getPost('sort', 'int', 0);
            $info['url'] = $this->request->getPost('url');
            $info['description'] = $this->request->getPost('desc');

            if ( $pid ) {
                $info['id'] = $pid;
            }

            if ( !$info ) {
                throw new PhException('EParamError');
            }

            $photo = new TourPhoto();
            if( $photo->save($info) === false){
                throw new PhException('ESystemError');
            }

            echo Lang::jsonSuccess('SPublish', array('pid' => $photo->id));
            
        } catch (PhException $e) {
            
            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }

    public function delTourPhotoAction() {

        $pid = $this->request->getPost('pid', 'int', 0);

        try {
            
            $this->checkAjax();
            
            if( !$pid ){
                throw new PhException('EParamError');
            }

            TourPhoto::del($pid);

            echo Lang::jsonSuccess('SDelete');
            
        } catch (PhException $e) {

            echo Lang::jsonError( $e->getMessage() );
        }

        return false;
    }
}