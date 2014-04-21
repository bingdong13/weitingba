function setShareIns(){
    var ins = $("#id_content");
    if (!ins.length)
        return false;
    
    var ele = $("#care_ins_box");

    //输入框事件
    ins.focus(function() {
        ele.addClass("care_ins_focus");
    });
    
    setInputLen();
    
    //点击元素以外的地方隐藏
    $(document).bind("click", function(ev) {
        var e = window.event ? window.event : ev;
        var target = e.srcElement || e.target;

        if (target) {
            while (target.nodeName.toLowerCase() != "html") {
                if (target.id == "care_ins_box")
                    break;
                target = target.parentNode;
            }
            if (target.nodeName.toLowerCase() == "html") {
                ele.removeClass('care_ins_focus');
            } else {
                ele.addClass('care_ins_focus');
            }
        }
    });

    $("#id_sharedForm").submit( addShared );
}

function addShared(){
    var ins = $("#id_content");
    var content = $.trim(ins.val());
    var category = $.trim($("#id_category").val());

    if (content == "") {
        showError("请输入分享内容。");
        return false;
    }

    if (category == "") {
        showError("请选择类别。");
        return false;
    }

    var saveBtn = $('#id_shared_btn');
    saveBtn.locked();

    $.post(this.action, $(this).serialize(), function(resp) {
        if(resp.code == 100){
            showSuccess(resp.msg);
            ins.val("");

            $("#ctotal" + category).incrhtml();

            var gid = $("#id_sharedList").attr("cid");
            $("#cnumber" + gid).incrhtml();

            getSharedList();
        }else{
            showError(resp.msg);
        }

        saveBtn.unlock();
    });

    return false;
}

function delShared(sid, cid){
    if( !confirm("确定要删除吗？") ){
        return false;
    }

    $.post("/shared/delete", { "sid": sid }, function(resp) {
        if(resp.code == 100) {
            $('#id_shared_' + sid).slideUp();

            $("#ctotal" + cid).decrhtml();

            var gid = $("#id_sharedList").attr("cid");
            $("#cnumber" + gid).decrhtml();
            
            showSuccess(resp.msg);
        }else{
            showError(resp.msg);
        }
    });

    return false;
}

function getSharedList(){
    
    var cid = $("#id_sharedList").attr("cid");
    var opts = { "url": "/shared/loadList", "param":{"cid":cid}};
    $("#id_sharedList").scroollPagination(opts);
}

function cptSharedList(){
    if(isLogin == 1 ){
        setShareIns();
        
        $("#id_sharedList").delegate(".change_class", "click", function(e) {
            e.preventDefault();

            $(this).maskWin();
        });
    }

    getSharedList();
}

function delNotebook(nid, cid){
    if( !confirm("确定要删除吗？") ){
        return false;
    }

    $.post("/notebook/delete", { "nid": nid }, function(resp) {
        if(resp.code == 100) {
            $('#id_note_' + nid).slideUp();

            $("#ctotal" + cid).decrhtml();

            var gid = $("#id_notebookList").attr("cid");
            $("#cnumber" + gid).decrhtml();
            
            showSuccess(resp.msg);
        }else{
            showError(resp.msg);
        }
    });

    return false;
}

function getNotebookList(){
    var cid = $("#id_notebookList").attr("cid");
    var opts = { "url": "/notebook/loadList", "param": {"cid":cid} };
    $("#id_notebookList").scroollPagination(opts);
}

function cptNotebookList(){
    
    if(isLogin == 1 ){
        $("#id_notebookList").delegate(".change_class", "click", function(e) {
            e.preventDefault();

            $(this).maskWin();
        });
    }
    
    getNotebookList();
}

function delMagazine(nid, cid){
    if( !confirm("确定要删除吗？") ){
        return false;
    }

    $.post("/magazine/delete", { "nid": nid }, function(resp) {
        if(resp.code == 100) {
            $('#id_zine_' + nid).slideUp();

            $("#ctotal" + cid).decrhtml();

            var gid = $("#id_zineList").attr("cid");
            $("#cnumber" + gid).decrhtml();
            
            showSuccess(resp.msg);
        }else{
            showError(resp.msg);
        }
    });

    return false;
}

function getMagazineList(){
    var cid = $("#id_zineList").attr("cid");
    var opts = { "url": "/magazine/loadList", "param": {"cid":cid} };
    $("#id_zineList").scroollPagination(opts);
}

function cptMagazineList(){
    
    if(isLogin == 1 ){
        $("#id_zineList").delegate(".change_class", "click", function(e) {
            e.preventDefault();

            $(this).maskWin();
        });
    }

    $(".select_category").click(function(e){
        e.preventDefault();
        
        $("#id_zineList").attr("cid", $(this).attr("pk") );
        getMagazineList();
    });
    
    getMagazineList();
}

/**
 * 更改记录所属分类
 * 
 * @param {string} action 操作action
 * @returns {Boolean}
 */
function changeCategory(action){
    var new_cid = $("#new_category").val();
    if( !new_cid ){
        showError('请选择新分类！');
        return false;
    }

    var saveBtn = $('#id_changeClass_btn');
    saveBtn.locked();

    $.post(action, {"cid":new_cid}, function(resp) {
        
        if(resp.code == 100){
            showSuccess(resp.msg, '温馨提示', true);
        }else{
            showError(resp.msg);
        }

        saveBtn.unlock();
    });

    return false;
}