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

    $("#id_messageForm").submit( addGuestbook );
}

function getGbookList(){
    
    var opts = { "url": "/guestbook/loadList"};
    $("#id_msglist").scroollPagination(opts);
}

function cptGbookList(){
    if( $("#user_status").attr("login") == 1 ){
        setShareIns();
    }

    getGbookList();
}

function addGuestbook() {

    $content = $("#id_content");
    if( !$content.val() ) {
        showNotice("请输入留言内容。");
        return false;
    }

    var saveBtn = $('#id_save_btn');
    saveBtn.locked();

    $.post(this.action, $(this).serialize(), function(resp) {
        if(resp.code == 100) {

            $content.val('');

            getGbookList();
            
        } else {
            showError(resp.msg);
        }

        saveBtn.unlock();
    });

    return false;
}

function delGuestbook(gid) {

    if( !confirm("确定要删除吗？") ){
        return false;
    }

    $.post("/guestbook/delete", { "gid": gid }, function(resp) {
        if(resp.code == 100) {
            $("#id_items_" + gid).slideUp();
        }else{
            showError(resp.msg);
        }
    });

    return false;
}

function replyBox(gid){

    getGbookReply(gid);

    $("#id_gbookReply_"+gid).parent().toggle();

    return false;
}

function getGbookReply(gid, isload) {

    var $replylist = $("#id_gbookReply_" + gid);

    if(typeof isload == 'undefined'){
        isload = false;
    }

    if($replylist.html() == '' || isload == true) {
        $replylist.html('<p class="loading"><span>正在载入留言...</span></p>');

        $.get("/guestbook/loadReply", { "pid": gid }, function(resp) {
            $replylist.html(resp);
        });
    }

    return false;
}

function addGbookReply(el) {
    var $me = $(el);
    var $content = $me.children('input[name="content"]');

    if( !$content.val() ) {
        showNotice("请输入回复内容。");
        return false;
    }

    var submit = $me.children('input[type="submit"]');
    submit.locked();

    $.post('/guestbook/add', $me.serialize(), function(resp) {
        if(resp.code == 100) {

            $content.val('');

            var gid = $me.children('input[name="pid"]').val();
            $('#id_replytimes_' + gid).incrhtml();
            getGbookReply(gid, true);

        } else {

            showError(resp.msg);
        }

        submit.unlock();
    });

    return false;
}

function delGbookReply(gid, pid) {

    if( !confirm("确定要删除吗？") ){
        return false;
    }

    $.post("/guestbook/delete", { "gid": gid }, function(resp) {
        if(resp.code == 100) {
            $("#id_reply_" + gid).slideUp();
            $("#id_replytimes_" + pid).decrhtml();
        }else{
            showError(resp.msg);
        }
    });

    return false;
}

function upCommentBox(el){
    $(el).parent().parent().slideUp();
}