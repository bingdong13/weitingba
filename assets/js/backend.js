function delMember(el){

    if( !confirm("确定要删除吗？") ){
        return false;
    }

    var uid = $(el).attr("data-pk");

    if( !uid ){
        showError("参数错误");
        return false;
    }

    showError("参数错误");

    $.post("/system/delMember", {"uid":uid}, function(resp) {
        if (resp.code == 100) {
            showSuccess(resp.msg);
            $(el).parent().parent().slideUp();
        } else {
            showError(resp.msg);
        }
    });

    return false;
}

function cptCategoryFun() {

    setInputLen();

    loadUploadify();

    $("#id_title").blur(function() {
        $(this).checkInput();
    });

    $('#id_categoryForm').submit(function() {

        if (!$('#id_channel').checkInput()) {
            return false;
        }

        if (!$('#id_title').checkInput()) {
            return false;
        }

        var saveBtn = $('#id_save_btn');
        saveBtn.locked();

        $.post(this.action, $(this).serialize(), function(resp) {
            if (resp.code == 100) {
                showSuccess(resp.msg, '温馨提示', true);
            } else {
                showError(resp.msg);
            }

            saveBtn.unlock();
        });

        return false;
    });
}

function cptNoteFun() {

    setInputLen();

    UM.getEditor("content");

    $("#id_title").blur(function() {
        $(this).checkInput();
    });

    $('#id_noteForm').submit(function() {

        if (!$('#id_category').checkInput()) {
            return false;
        }

        if (!$('#id_title').checkInput()) {
            return false;
        }

        var saveBtn = $('#id_save_btn');
        saveBtn.locked();

        $.post(this.action, $(this).serialize(), function(resp) {
            if (resp.code == 100) {
                showSuccess(resp.msg, '温馨提示', true);
            } else {
                showError(resp.msg);
            }

            saveBtn.unlock();
        });

        return false;
    });
}

function cptMagazineFun() {

    setInputLen();

    loadUploadify();

    UM.getEditor("content");

    $("#id_title").blur(function() {
        $(this).checkInput();
    });

    $('#id_zineForm').submit(function() {

        if (!$('#id_category').checkInput()) {
            return false;
        }

        if (!$('#id_title').checkInput()) {
            return false;
        }

        var saveBtn = $('#id_save_btn');
        saveBtn.locked();

        $.post(this.action, $(this).serialize(), function(resp) {
            if (resp.code == 100) {
                showSuccess(resp.msg, '温馨提示', true);
            } else {
                showError(resp.msg);
            }

            saveBtn.unlock();
        });

        return false;
    });
}

function cptCacheFun() {

    $(".cleanCache").on("click", function() {
        if (!confirm("确定要清除缓存吗？")) {
            return false;
        }

        $parent = $(this).parent();
        $key = $(this).attr('data-pk');

        $.post('/system/cleanCache', {"key": $key}, function(resp) {
            if (resp.code == 100) {
                if($key == 0){
                    window.location.reload();
                }else{
                    $parent.remove();
                }
                
            } else {
                showError(resp.msg);
            }
        });

        return false;
    });
}

function cptBoardFun() {

    setInputLen();

    loadUploadify();

    $("#id_content").blur(function() {
        $(this).checkInput();
    });

    $('#id_boardForm').submit(function() {

        if (!$('#id_content').checkInput()) {
            return false;
        }

        var saveBtn = $('#id_save_btn');
        saveBtn.locked();

        $.post(this.action, $(this).serialize(), function(resp) {
            if (resp.code == 100) {
                showSuccess(resp.msg, '温馨提示', true);
            } else {
                showError(resp.msg);
            }

            saveBtn.unlock();
        });

        return false;
    });
}

function cptFmFun() {

    setInputLen();

    loadUploadify();

    UM.getEditor("content");

    $("#id_title").blur(function() {
        $(this).checkInput();
    });

    $("#id_anchor").blur(function() {
        $(this).checkInput();
    });

    $("#id_voice").blur(function() {
        $(this).checkInput();
    });

    $('#id_fmForm').submit(function() {

        if (!$('#id_category').checkInput()) {
            return false;
        }

        if (!$('#id_title').checkInput()) {
            return false;
        }

        if (!$('#id_anchor').checkInput()) {
            return false;
        }

        if (!$('#id_voice').checkInput()) {
            return false;
        }

        var saveBtn = $('#id_save_btn');
        saveBtn.locked();

        $.post(this.action, $(this).serialize(), function(resp) {
            if (resp.code == 100) {
                showSuccess(resp.msg, '温馨提示', true);
            } else {
                showError(resp.msg);
            }

            saveBtn.unlock();
        });

        return false;
    });
}

function cptTourFun() {

    setInputLen();

    loadUploadify();

    $("#id_title").blur(function() {
        $(this).checkInput();
    });

    $('#id_tourForm').submit(function() {

        if (!$('#id_title').checkInput()) {
            return false;
        }

        var saveBtn = $('#id_save_btn');
        saveBtn.locked();

        $.post(this.action, $(this).serialize(), function(resp) {
            if (resp.code == 100) {
                showSuccess(resp.msg, '温馨提示', true);
            } else {
                showError(resp.msg);
            }

            saveBtn.unlock();
        });

        return false;
    });
}

function cptTourListFun(){

    $(".delTour").on("click", function(e){
        e.preventDefault();
        
        if( !confirm("确定要删除吗？") ){
            return false;
        }

        var $me = $(this);
        var tid = $me.attr("data-pk");

        if(parseInt(tid) > 0){
            $.post("/backend/delTour", {"tid":tid}, function(resp) {
                if (resp.code == 100) {
                    showSuccess(resp.msg);
                    $me.parent().parent().slideUp();
                } else {
                    showError(resp.msg);
                }
            });

            return true;
        }

        showError("参数错误");
        return false;
    });
}

function cptTourphotoFun(){
    var $photolist = $("#photolist");
    
    $("#file_upload").uploadify({
        "buttonText": "请选择...",
        "swf": "/uploadify.swf",
        "uploader": "/api/uploadFile",
        "onUploadSuccess": function(file, data, response) {

            var resp = eval('(' + data + ')');

            if(resp.code==100){
                var html = '<tr>';
                    html += '<td><a target="_blank" href="'+ resp.url +'" title="查看大图"><img data-url="'+ resp.name +'" src="'+ resp.url +'" width="130" height="87" /></a></td>';
                    html += '<td><textarea class="ins ins230" rows="3"></textarea></td>';
                    html += '<td><input type="text" class="ins ins50" value="1" /></td>';
                    html += '<td data-pk="0"><button class="icons btns savePhoto dpb mt5" locked-msg="提交中...">保存</button><button class="icons btns delPhoto dpb mt10">取消</button></td>';
                    html += '</tr>';

                $photolist.prepend(html);

            }else{
                showError(resp.msg);
            }
        }
    });

    $photolist.delegate(".savePhoto", "click", function(e){
        e.preventDefault();

        var $me = $(this);
        var $parent = $me.parent();
        var $siblin = $parent.siblings();
        var tour = $("#photolist").attr("data-tour");

        var pid = $parent.attr("data-pk");
        var url = $siblin.children().children("img").attr("data-url");
        var desc = $siblin.children("textarea").val();
        var sort = $siblin.children("input").val();

        $me.locked();

        var data = {"pid":pid, "tour":tour, "url":url, "desc":desc, "sort":sort}
        $.post("/backend/saveTourPhoto", data, function(resp) {
            if (resp.code == 100) {
                $parent.attr("data-pk", resp.ref.pid);
                showSuccess(resp.msg);
                $me.siblings(".delPhoto").hide();
            } else {
                showError(resp.msg);
            }

            $me.unlock();
        });
    });

    $photolist.delegate(".delPhoto", "click", function(e){
        e.preventDefault();

        var $me = $(this);
        var pid = $me.parent().attr("data-pk");
        var msg = $me.html();

        if( !confirm("确定要"+ msg +"吗？") ){
            return false;
        }

        if(parseInt(pid) > 0){
            $me.locked();
            $.post("/backend/delTourPhoto", {"pid":pid}, function(resp) {
                if (resp.code == 100) {
                    showSuccess(resp.msg);
                    $me.parent().parent().remove();
                } else {
                    showError(resp.msg);
                    $me.unlock();
                }
            });

            return true;
        }

        $me.parent().parent().remove();
        return false;
    });
}