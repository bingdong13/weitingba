// 定时器
var focusInterval = null;

// 是否跳转或刷新
var refresh = false;

/**
 * Cookie设置
 * @param name  cookie名称
 * @param value cookie值
 * @param expires 过期时间
 * @return void
 */
function setCookie(name, value, expires) {
    var cookieStr = name + "=" + escape (value);
    
    if(expires > 0) { 
        var LargeExpDate = new Date ();
        LargeExpDate.setTime(LargeExpDate.getTime() + (expires * 60 * 1000) );
        cookieStr += "; expires=" + LargeExpDate.toGMTString();
    }
    
    document.cookie = cookieStr;
}

/**
 * 获取Cookie
 * @param name  cookie名称
 * @return cookie值
 */
function getCookie(name) {
    var search = name + "=";
    if(document.cookie.length > 0) {
        var offset = document.cookie.indexOf(search);
        if(offset != -1) {
            offset += search.length;
            var end = document.cookie.indexOf(";", offset);
            end = (end == -1) ? document.cookie.length : end;

            return unescape(document.cookie.substring(offset, end));
        }
    }
    
    return "";
}

//回顶部
function setTopbar(){
    var ele = $('#topbar'),
        isIE6 = /MSIE 6.0/ig.test(navigator.appVersion);

    $(window).bind('scroll', function() {
        var winHeight, pTop;
        var sTop = document.body.scrollTop ? document.body.scrollTop : document.documentElement.scrollTop;
            sTop = parseInt(sTop);
            
        if (sTop > 0) {
            ele.fadeIn();
            if (isIE6) {
                winHeight = document.documentElement.clientHeight;
                pTop = (winHeight - 70 + sTop) + 'px';
                ele.stop().animate({'top': pTop}, 'slow');
            }
        } else {
            ele.fadeOut();
        }
    });
} 

/**
 * 收藏本站到收藏夹
 * @param url   网站网址
 * @param title 网站名称
 * @return void
 */
function favSite(url, title) {
    if (window.sidebar) {
        window.sidebar.addPanel(title,url,""); 
    } else if(document.all) {
        window.external.AddFavorite(url,title); 
    }
}

//输入字符长度处理
function setInputLen() {
    var ele = $('#id_content'),
        maxs = $('#max_words'),
        max_words = $.trim(maxs.html()),
        lave = 0;

    var setLen = function() {
        var ival = ele.val();
        if (ival.length >= max_words) {
            ele.val(ival.substr(0, max_words));
            lave = 0;
        } else {
            lave = max_words - ival.length;
        }
        maxs.html(lave);
    };
    
    ele.bind("keyup keydown blur focus", function() {
        setLen();
    });
    
    if(ele.val()){
        setLen();
    }
}

/**
 * 导入分享条
 * @param tool    显示分享条内容的区域
 * @param showArea  分享内容区域
 * @return void
 */
function loadShareTool(showArea, tool){
    var getShareStr = function(url, title){
        var txtStr = '分享到：';
            txtStr += '<a href="javascript:void(0)" class="share_icon s_sina" title="分享到新浪微博" onclick="openShareTool(\''+ url +'\', \''+ title +'\', \'sina\');"></a>';
            txtStr += '<a href="javascript:void(0)" class="share_icon s_douban" title="分享到豆瓣" onclick="openShareTool(\''+ url +'\', \''+ title +'\', \'douban\');"></a>';
            txtStr += '<a href="javascript:void(0)" class="share_icon s_qzone" title="分享到QQ空间" onclick="openShareTool(\''+ url +'\', \''+ title +'\', \'qzone\');"></a>';
            txtStr += '<a href="javascript:void(0)" class="share_icon s_tqq" title="分享到腾讯微博" onclick="openShareTool(\''+ url +'\', \''+ title +'\', \'tqq\');"></a>';
            txtStr += '<a href="javascript:void(0)" class="share_icon s_renren" title="分享到人人网" onclick="openShareTool(\''+ url +'\', \''+ title +'\', \'renren\');"></a>';
            
        return txtStr;
    };

    var url = window.location.href;
    $(showArea).delegate(tool, 'mouseover', function() {
        $me = $(this);

        var shareTool = $me.find(".tool_area");
        if(shareTool.children().size() == 0){

            if(typeof $me.attr("ref") !== 'undefined'){
                url = $me.attr("ref");
            }

            var title = $me.find(".desc").html();
            shareTool.html( getShareStr(url, title) );
        }
    });
}

/**
 * 打开分享页面
 * @param url    分享内容URL
 * @param title  分享标题
 * @param type   分享条类型
 * @return void
 */
function openShareTool(url, title, type){
    var shareUrl = '';
    
    switch(type){
        case 'sina' :
            shareUrl = 'http://v.t.sina.com.cn/share/share.php?appkey=3318394053&url='+ encodeURIComponent(url) +'&title='+ encodeURIComponent(title)+'&content=utf8&pic=';
            break;
        case 'douban' :
            shareUrl = 'http://www.douban.com/recommend/?url='+ encodeURIComponent(url) +'&title='+ encodeURIComponent(title) +'&sel=&v=1';
            break;
        case 'qzone' :
            shareUrl = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+ encodeURIComponent(url)+ '&title='+encodeURIComponent(title);
            break;
        case 'tqq' :
            shareUrl = 'http://v.t.qq.com/share/share.php?url='+encodeURIComponent(url)+'&title='+encodeURIComponent(title)+'&jumpback=2&noui=1';
            break;
        case 'renren' :
            shareUrl = 'http://share.renren.com/share/buttonshare.do?link='+ encodeURIComponent(url) +'&title='+ encodeURIComponent(title);
            break;
        default :
            break;
    }

    if(shareUrl){
        window.open(shareUrl);
    }
}

var winfrom = {
    close: function(){
        $('.mask').hide();
        $('.mask-bg').hide();

        return false;
    },

    open: function(mid){
        $('.mask-bg').show();
        
        if(typeof mid == 'undefined'){
            $('.mask').show();
        }else{
            $(mid).show();
        }
        
        return false;
    }
};

// 显示错误信息
function showError(msg, title) {
    if(typeof title == 'undefined'){
        title = '出错啦...';
    }

    showMessage(msg, "error-msg", title);
}

// 显示成功信息
function showSuccess(msg, title, ref) {
    if(typeof title == 'undefined'){
        title = '恭喜您...';
    }

    if(typeof ref !== 'undefined'){
        refresh = ref;
    }

    showMessage(msg, "success-msg", title);
}

// 显示通知信息
function showNotice(msg, title) {
    if(typeof title == 'undefined'){
        title = '温馨提醒...';
    }

    showMessage(msg, "notice-msg", title);
}

// 显示警告信息
function showWarning(msg, title) {
    if(typeof title == 'undefined'){
        title = '温馨提醒...';
    }

    showMessage(msg, "warning-msg", title);
}

function showMessage(msg, msgtype, title, time) {
    if(typeof msg == 'undefined'){
        msg = '您目前的操作出现了异常，您可以尝试以下的操作： <br />';
        msg += '1、登录超时，重新 <a href="/passport/login">登录</a><br />';
        msg += '2、系统错误，请联系管理员，谢谢！';
    }
    
    var alertMsg = $("#alert-msg");
    var leftsize = ($(window).width() - alertMsg.outerWidth(true))/2;
    var htmlStr  = '<div class="' + msgtype + '"><h5>' + title;
        htmlStr += '<a class="close" href="javascript:;">&times;</a></h5>' + msg + '</div>';

    $(".alert-bg").show();

    alertMsg.html(htmlStr).stop(true, true).show().animate({ opacity: 1, left: leftsize }, 500);
    
    if(typeof time == 'undefined'){
        time = 3000;
    }

    focusInterval = setInterval(hideNotice, time);
    alertMsg.mouseover(function(){
        clearInterval(focusInterval);
    }).mouseout(function(){ 
        focusInterval = setInterval(hideNotice, time);
    });

    $("#alert-msg .close").click(function(){ hideNotice(); });
}

function hideNotice() {
    $("#alert-msg").animate({opacity: 0, left: -5}, 500, function() {
        $(this).hide();
        $(".alert-bg").hide();
        
        if(typeof refresh == 'boolean' && refresh === true){

            window.location.reload();
        }else if( refresh ){
            window.location.href = refresh;
        }
    });
    clearInterval(focusInterval);
}

// 验证登录信息
function cptLoginFun() {
    var $username = $("#id_username");
    var $password = $("#id_password");
    
    $username.blur(function(){
        $(this).checkInput();
    });

    $password.blur(function(){
        $(this).checkInput();
    });

   $('#id_loginForm').submit(function(){
       if ( !$username.checkInput() || !$password.checkInput() ) {
            return false;
        }

        var saveBtn = $('#id_save_btn');
        saveBtn.locked();

        $.post(this.action, $(this).serialize(), function(resp) {
            if(resp.code == 100){
                window.location = resp.ref;
            }else{
                showError(resp.msg);
            }

            saveBtn.unlock();
        });

        return false;
   });
}

// ajax登录
function ajaxLogin(me){
    $(me).maskWin();
    $("body").delegate("#idLoginForm", "submit", function() {
        var $username = $("#id_username");
        var $password = $("#id_username");

        if ( !$username.checkInput() || !$password.checkInput() ) {
            return false;
        }

        var saveBtn = $('#id_save_btn');
        saveBtn.locked();

        $.post(this.action, $(this).serialize(), function(resp) {
            if(resp.code == 100){
                showSuccess(resp.msg, '温馨提示', true);
            }else{
                showError(resp.msg);
                saveBtn.unlock();
            }
        });

        return false;
    });
}
            
// qq登录
function toQzoneLogin(){
    
    window.open("/passport/qzoneLogin", "TencentLogin", "width=700,height=420,menubar=0,scrollbars=1, resizable=0,status=0,titlebar=0,toolbar=0,location=1");
}

// 退出登录
function logout(){
    $.post('/passport/logout', function(resp) {
        if(resp.code == 100){
            showSuccess(resp.msg, '温馨提示', true);
        }else{
            showError(resp.msg);
        }
    });
}

// 上传组件
function loadUploadify(){
    
    $("#file_upload").uploadify({
        "width":80,
        "height":20,
        "buttonText": "更新",
        "multi":false,
        "swf": "/uploadify.swf",
        "uploader": "/api/uploadFile",
        "onUploadSuccess": function(file, data, response) {

            var resp = eval('(' + data + ')');

            if(resp.code==100){
                var $preview = $("#preview");
                var cwidth = $preview.attr("width");
                var cheight = $preview.attr("height");

                $preview.attr("src", resp.url);
                $("#face_url").val(resp.name);

                //var jcrop_param = '/jcrop_' + resp.name + '_' + cwidth + '_' + cheight;
                //$("#jcropBtn").attr("data-url", jcrop_param).show();
            }else{
                showError(resp.msg);
            }
        }
    });

    // $("#jcropBtn").on("click", function(e) {
    //     e.preventDefault();
        
    //     $(this).maskWin();
    // });
}

// 换背景组件
function changeBackdrop($obj) {

    $("#file_upload").uploadify({
        "buttonText": "更新背景",
        "multi": false,
        "swf": "/uploadify.swf",
        "uploader": "/api/uploadFile",
        "onUploadSuccess": function(file, data, response) {
            var resp = eval('(' + data + ')');

            if(resp.code==100){

                if(typeof $obj == 'undefined'){
                    $.fillmore({src: resp.url, speed: "fast"});
                }else{
                    $obj.css("background-image", 'url('+ resp.url +')');
                }
                
                $("#newBg").val(resp.name);
                $("#saveBg").show();

            }else{
                showError(resp.msg);
            }
        }
    });
}

$(function(){
    setTopbar();
    
    var $lazy = $("img.lazy");
    if($lazy.length > 0){
        $lazy.lazyload({ effect : "fadeIn"});
    }

    if(typeof component == 'object'){
        eval(component + '()');
    }
});