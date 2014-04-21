;
(function($) {
    $.fn.watermark = function() {
        var val = $.trim($(this).val());
        if (val == '') {
            $(this).val($(this).attr('tip'));
            $(this).addClass('fgrey');
        }
        $(this).focus(function() {
            var tip = $(this).attr('tip');
            var val = $.trim($(this).val());
            if (val == tip) {
                $(this).val('');
            }
            $(this).removeClass('fgrey');
        }).blur(function() {
            var tip = $(this).attr('tip');
            var val = $.trim($(this).val());
            if (val == '') {
                $(this).val(tip);
                $(this).addClass('fgrey');
            }
        });
        return this;
    }

    $.fn.disable = function() {
        $(this).attr('disabled', true);
    }
    $.fn.enable = function() {
        $(this).attr('disabled', false);
    }
    
    $.fn.locked = function(){
        var $obj = $(this);
        var lockedMsg = $obj.attr('locked-msg');
        var oldVal = $obj.html();
        
        $obj.attr('locked-msg', oldVal);
        $obj.html( lockedMsg ).disable();
    };
    $.fn.unlock = function(){
        var $obj = $(this);
        var unlockMsg = $obj.attr('locked-msg');
        var oldVal = $obj.html();
        
        $obj.attr('locked-msg', oldVal);
        $obj.html( unlockMsg ).enable();
    };

    $.fn.checkInput = function() {
        var el = $(this);
        var tip = el.attr('tip');
        var nullmsg = el.attr('nullmsg');
        var errormsg = el.attr('errormsg');
        var datatype = el.attr('datatype');
        var val = $.trim(el.val());

        if (typeof nullmsg != 'undefined') {
            if (val == '' || val == tip) {
                el.setInputMsg(nullmsg);
                return false;
            } else {
                el.removeInputMsg();
            }
        }

        if (!errormsg) {
            return true;
        }

        if (!el.validLength(val)) {
            el.setInputMsg(errormsg);
            return false;
        } else {
            el.removeInputMsg();
        }

        if (typeof datatype != 'undefined') {
            var result = false;
            switch (datatype) {
                case 'email':
                    result = el.validEmail(val);
                    break;
                case 'regex':
                    result = el.validRegex(val);
                    break;
                case 'recheck':
                    result = el.validRecheck(val);
                    break;
                case 'image':
                    result = el.validImage(val);
                    break;
                case 'alphabet':
                    result = el.validAlphabet(val);
                    break;
                case 'numeric':
                    result = el.validNumeric(val);
                    break;
                case 'mobile':
                    result = el.validMobile(val);
                    break;
                default:
                    break;
            }

            if (!result) {
                el.setInputMsg(errormsg);
                return false;
            } else {
                el.removeInputMsg();
            }
        }

        return true;
    }

    $.fn.showInputTip = function(msg) {
        var el = $(this);
        var id = el.attr('id');
        var $msg = $('#' + id + '_msg');

        if (typeof msg == 'undefined') {
            msg = el.attr('tip');
            if (typeof msg == 'undefined') {
                msg = el.attr('errormsg');
            }
        }

        if ($msg.length > 0) {
            $msg.html(msg).show();
        } else {
            el.attr('title', msg);
        }
    }

    $.fn.setInputMsg = function(msg) {
        var el = $(this);
        var id = el.attr('id');
        var $msg = $('#' + id + '_msg');

        if ($msg.length > 0) {
            $msg.html(msg).show();
        } else {
            el.attr('title', msg);
        }

        el.removeClass('rightIns').addClass('wrongIns');
    }

    $.fn.removeInputMsg = function() {
        var el = $(this);
        var id = el.attr('id');
        var $msg = $('#' + id + '_msg');

        if ($msg.length > 0) {
            $msg.html('').hide();
        } else {
            el.attr('title', '');
        }

        el.removeClass('wrongIns').addClass("rightIns");
    }

    $.fn.validLength = function(val) {
        var el = $(this);
        var max = el.attr('max');
        var min = el.attr('min');
        var len = val.length;

        if (typeof max == 'undefined' || typeof min == 'undefined') {
            return true;
        }

        max = parseInt(max);
        min = parseInt(min);

        if (max <= min) {
            return true;
        }

        if (len < min || len > max) {
            return false;
        }

        return true;
    }

    $.fn.validRegex = function(val) {
        var regex = eval($(this).attr('regex'));

        return regex.test(val);
    }

    $.fn.validRecheck = function(val) {
        var recheck = $(this).attr('recheck');
        var reVal = $.trim($(recheck).val());

        if (val != reVal) {
            return false;
        }

        return true;
    }

    //检测邮箱格式
    $.fn.validEmail = function(val) {

        var emailReg = /[\w-]+@[\w\.]+/;
        return emailReg.test(val);
    };

    $.fn.validImage = function(val) {
        var index = val.lastIndexOf('.');
        var ext = val.slice(index + 1).toLowerCase();
        var allowExt = 'jpg,png,jpeg,gif';

        if (!ext || allowExt.indexOf(ext) < 0) {
            return false;
        }

        return true;
    }

    //检测是否为数字
    $.fn.validNumeric = function(val, flag) {
        if (typeof flag == 'undefined') {
            flag = $(this).attr('flag');
        }

        var regular = "";
        switch (flag) {
            case "i"://整数
                regular = /(^-?|^\+?|\d)\d+$/;
                break;
            case "+i"://正整数
                regular = /(^\d+$)|(^\+?\d+$)/;
                break;
            case "-i"://负整数
                regular = /^[-]\d+$/;
                break;
            case "f"://浮点数
                regular = /(^-?|^\+?|^\d?)\d*\.\d+$/;
                break;
            case "+f"://正浮点数
                regular = /(^\+?|^\d?)\d*\.\d+$/;
                break;
            case "-f"://负浮点数
                regular = /^[-]\d*\.\d$/;
                break;
            case "-"://负数
                regular = /^-\d*\.?\d+$/;
                break;
            case "+"://正数
            default:
                regular = /(^\+?|^\d?)\d*\.?\d+$/;
        }

        return regular.test(val);
    };

    $.fn.validAlphabet = function(val, flag) {

        if (typeof flag == 'undefined') {
            flag = $(this).attr('flag');
        }

        var regular = "";
        str = val.replace(/\s+/g, "");
        switch (flag) {
            case "e"://英文
                regular = /^[a-zA-Z]*$/;
                break;
            case "c"://中文
                regular = /^[\u4e00-\u9fa5]*$/;
                break;
            case "ne": //字母数字
                regular = /^[a-zA-Z0-9]*$/;
                break;
            default://中英文
                regular = /^[a-zA-Z\u4e00-\u9fa5]*$/;
        }
        return regular.test(val);
    };

    //检测手机号码
    $.fn.validMobile = function(val) {
        if (!val.match(/^\+?[1-9][0-9]*$/) || val.length != 11) {
            return false;
        } else {
            return true;
        }
    };

    $.fn.incrhtml = function(num) {
        if (typeof num == 'undefined') {
            num = 1;
        }

        var oldVal = parseInt($(this).html());

        $(this).html(oldVal + num);
    };

    $.fn.decrhtml = function(num) {
        if (typeof num == 'undefined') {
            num = 1;
        }

        var oldVal = parseInt($(this).html());

        if (oldVal > 0) {
            $(this).html(oldVal - num);
        }
    };

    //滚动加载
    $.fn.scroollPagination = function(options) {

        var defaults = {
            'url': null, // the url you are fetching the results
            'param': {}, // these are the variables you can pass to the request
            'beforeLoad': null, // before load function, you can display a preloader div
            'afterLoad': null, // after loading content, you can use this function to animate your new elements
            'heightOffset': 50, // it gonna request when scroll is 50 pixels before the page ends
            'lazyload': 2       // lazy load, default:2s
        };

        var opts = $.extend(defaults, options);
        var ele = $(this);

        var openScrollPagination = function() {
            ele.attr('scrollPagination', 'enabled');
        };

        var stopScrollPagination = function() {
            ele.attr('scrollPagination', 'disabled');
        };
        
        var loadContent = function() {
            
            stopScrollPagination();

            if (opts.beforeLoad != null) {
                opts.beforeLoad();
            }

            opts.param.offset = ele.children().size();

            $.ajax({
                type: 'POST',
                url: opts.url,
                data: opts.param,
                dataType: 'html',
                async: false,
                success: function(rdata) {
                    if (rdata == '') {
                        stopScrollPagination();
                    } else {
                        ele.append(rdata);
                        setTimeout(openScrollPagination, opts.lazyload * 1000);
                    }

                    if (opts.afterLoad != null) {
                        opts.afterLoad(rdata);
                    }
                }
            });
        };

        // 初次导入数据
        $(this).load(opts.url, opts.param, function(resp) {
            if (!resp) {
                stopScrollPagination();
            } else {
                openScrollPagination();
            }
        });

        $(window).bind("scroll", function() {
            var height = $(document).height() - $(this).height();
            var mayLoadContent = $(this).scrollTop() + opts.heightOffset >= height;
            if (mayLoadContent && (ele.attr('scrollPagination') == 'enabled')) {
                loadContent();
            }
        });
    };
    
    $.fn.maskWin = function(){
        var ele = $(this);
        var ref = ele.attr('data-ref');
        var url = ele.attr('data-url');
        var title = ele.attr('title');
        
        var maskOpen = function(title, content){
            var html  = '<div id="id_mask" class="mask"><div class="mask-skin">';
            html += '<div class="mask-box">'+ content +'</div>';

            if(typeof title !== 'undefined'){
                html += '<div class="mask-title"><span class="child">'+ title +'</span></div>';
            }

            html += '<a class="mask-close" href="javascript:;" title="关闭"></a></div></div>';
                
            $("body").append(html);
            
            $(".mask-bg").show();
            $("#id_mask").show();

            return false;
        };
        
        if(typeof url !== 'undefined'){
            $.get(url, function(content) { 

                maskOpen(title, content);
            });
            
        }else{
            
            maskOpen(title, $(ref).html());
        }
        
        $("body").delegate(".mask-close", "click", function(){
            $.fn.delMaskWin();
        });
    };
    $.fn.delMaskWin = function(){
        $("#id_mask").remove();
        $(".mask-bg").hide();
    };

})(jQuery);