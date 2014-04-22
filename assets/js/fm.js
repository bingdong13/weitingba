var $audio = null;

function cptIndexFun() {
    var bgImage = $("#bg").attr("bg-url");
    $.fillmore({src: bgImage, speed: "fast"});

    if (isLogin == 1) {
        changeBackdrop();
        
        $("#saveBg").on("click", function(e) {
            e.preventDefault();
            
            if (!confirm("确定要保存吗？")) {
                return false;
            }

            var imgurl = $("#newBg").val();

            $.post("/api/changeHomeBg", {"imgurl": imgurl}, function(resp) {
                if (resp.code == 100) {
                    showSuccess(resp.msg, '温馨提示', true);
                } else {
                    showError(resp.msg);
                }
            });
        });
    }
}

function cptFmFun() {
    
    // 在loadfm加载之前，便于它的元素能被其它调用。
    loadFmList();

    // 加载播放器
    loadAudio();

    // 打开右侧导航信息
    openNavigate();
    
    // 更换背景图片
    if (isLogin == 1) {
        changeBackdrop();
        
        $("#saveBg").on("click", function(e) {
            e.preventDefault();

            if (!confirm("确定要保存吗？")) {
                return false;
            }

            var imgurl = $("#newBg").val();
            var fid = $("#fmTitle").attr("data-pk");

            $.post("/api/changeFmBg", {"fid": fid, "imgurl": imgurl}, function(resp) {
                if (resp.code == 100) {
                    showSuccess(resp.msg, '温馨提示', true);
                } else {
                    showError(resp.msg);
                }
            });
        });
    }

    // 加载背景
    $.fillmore({src: $("#bg").attr("bg-url"), speed: "fast"});
}

function cptTourFun(){
    var $tourbox = $("#tour-box");
    var bgImage = $tourbox.attr("data-url");
    $tourbox.css("background-image", 'url('+ bgImage +')');

    if (isLogin == 1) {
        changeBackdrop($tourbox);
        
        $("#saveBg").on("click", function(e) {
            e.preventDefault();

            if (!confirm("确定要保存吗？")) {
                return false;
            }

            var imgurl = $("#newBg").val();
            var tid = $tourbox.attr("data-pk");

            $.post("/api/changeTourBg", {"tid": tid, "imgurl": imgurl}, function(resp) {
                if (resp.code == 100) {
                    showSuccess(resp.msg, '温馨提示', true);
                } else {
                    showError(resp.msg);
                }
            });
        });
    }
}

function openNavigate(){

    //点击元素以外的地方隐藏
    $(document).bind("click", function(ev) {
        var e = window.event ? window.event : ev;
        var target = e.srcElement || e.target;

        if (target) {
            while (target.nodeName.toLowerCase() != "html") {
                
                if (target.id == "menuright" || 
                    target.id == "readAll" || 
                    target.id == "readList" ) {
                
                    switch(target.id){
                        case "readAll" :
                            var $detail = $("#detail");
                            $detail.siblings().hide();
                            $detail.show();
                            break;
                        case "readList" :
                            var broad = $("#broadcasts");
                            broad.siblings().hide();
                            broad.show();
                            break;
                        default:
                            break;
                    }
                    
                    break;
                }

                target = target.parentNode;
            }

            if (target.nodeName.toLowerCase() == "html") {
                $("#menuright").removeClass('fm_right_show');
            } else {
                $("#menuright").addClass('fm_right_show');
            }
        }
    });
}

function loadAudio(){
    // 加载播放器 
    audiojs.events.ready(function() {
        $audio = audiojs.createAll({
            css: false,
            createPlayer: {
                markup: '\
                <div class="play-box"> \
                <a href="javascript:;" class="prev"></a> \
                <span class="play-pause"> \
                <a href="javascript:;" class="play"></a> \
                <a href="javascript:;" class="pause"></a> \
                <a href="javascript:;" class="loading"></a> \
                <a href="javascript:;" class="error"></a> \
                </span> \
                <a href="javascript:;" class="next"></a> \
                <div class="scrubber"> \
                <span class="loaded"></span> \
                <span class="progress"></span> \
                <a href="javascript:;" class="pr_btn" id="dragItemX"></a> \
                </div> \
                <div class="time"> \
                <em class="played">00:00</em>/<strong class="duration">00:00</strong> \
                </div> \
                <div class="loadtext">加载中，请稍等...</div> \
                <div class="error-message"></div> \
                </div>',
                playPauseClass: 'play-pause',
                scrubberClass: 'scrubber',
                progressClass: 'progress',
                loaderClass: 'loaded',
                timeClass: 'time',
                durationClass: 'duration',
                playedClass: 'played',
                errorMessageClass: 'error-message',
                playingClass: 'playing',
                loadingClass: 'loading',
                errorClass: 'error'
            },
            trackEnded: function() {
                var $next = $(".cplaying").next();
                console.log($next);
                
                if ($next.length > 0){
                    console.log($next.first());
                    $next.first().click();
                }else{
                    var $prev = $(".cplaying").prev();
                    console.log($prev);
                    console.log($prev.first());
                    if ($prev.length > 0){
                        $prev.first().click();
                    }
                }
            }
        });

        setInterval(function() {
            var progress = $(".progress").css("width");
            $("#dragItemX").css("left", progress);
        }, 1000);
    });

    var $broad = $("#broadcasts");
    var $fmcontent = $(".fm_content");
    
    // 标志正在播放的节目
    var citem = $broad.children("div").first();
    citem.addClass("cplaying");

    $fmcontent.delegate(".prev", "click", function(e){
        e.preventDefault();

        var $prev = $(".cplaying").prev();
        if ($prev.length > 0){
            $prev.first().click();
        }
    });

    $fmcontent.delegate(".next", "click", function(e){
        e.preventDefault();

        var $next = $(".cplaying").next();
        if ($next.length > 0){
            $next.first().click();
        }
    });

    $broad.delegate(".citems", "click", loadfm);
}

function loadfm(e){
    e.preventDefault();

    var $me = $(this);
    var fid = $me.attr("data-pk");

    if( $me.hasClass('cplaying') ){
        return false;
    }
    
    $.post("/index/loadfm", {"fid": fid}, function(resp) {
        
        $("#fmTitle").html( resp['title'] ).attr( "data-pk", fid );
        $("#anchor").html( resp['anchor'] );
        $("#comeform").html( resp['comeform'] );
        $("#desc").html( resp['description'] );
        $("#detail").html( resp['content'] );

        $.fillmore({src: resp['bg_url'], speed: "fast"});

        var adio = $audio[0];
        adio.load( resp['voice'] );
        adio.play();

        // 标志正在播放的节目
        $me.addClass('cplaying').siblings().removeClass('cplaying');
        
        // 增加播放次数
        $("#fm" + fid).incrhtml();
    });
}

function loadFmList(){
    var fmlist = $("#broadcasts");
    var total = fmlist.attr("data-count");
    var offset = fmlist.children("div").size();
    
    if(offset >= total){
        $(".getmore").hide();
        return false;
    }
    
    $.ajax({
        type: 'POST',
        url: "/index/loadfmlist",
        data: {"offset": offset},
        dataType: 'html',
        async: false,
        success: function(resp) {
            fmlist.append(resp);
            
            offset = fmlist.children("div").size();
            if(total > offset){
                $(".getmore").show();
            }else{
                $(".getmore").hide();
            }
        }
    });
}