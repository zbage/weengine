/* common funcations*/
jQuery.extend({   
    /**  
     * 清除当前选择内容  
     */  
    unselectContents: function(){   
        if(window.getSelection)   
            window.getSelection().removeAllRanges();   
        else if(document.selection)   
            document.selection.empty();   
    }   
});   
jQuery.fn.extend({   
    /**  
     * 选中内容  
     */  
    selectContents: function(){   
        $(this).each(function(i){   
            var node = this;   
            var selection, range, doc, win;   
            if ((doc = node.ownerDocument) &&   
                (win = doc.defaultView) &&   
                typeof win.getSelection != 'undefined' &&   
                typeof doc.createRange != 'undefined' &&   
                (selection = window.getSelection()) &&   
                typeof selection.removeAllRanges != 'undefined')   
            {   
                range = doc.createRange();   
                range.selectNode(node);   
                if(i == 0){   
                    selection.removeAllRanges();   
                }   
                selection.addRange(range);   
            }   
            else if (document.body &&   
                     typeof document.body.createTextRange != 'undefined' &&   
                     (range = document.body.createTextRange()))   
            {   
                range.moveToElementText(node);   
                range.select();   
            }   
        });   
    },   
    /**  
     * 初始化对象以支持光标处插入内容  
     */  
    setCaret: function(){   
        if(!$.browser.msie) return;   
        var initSetCaret = function(){   
            var textObj = $(this).get(0);   
            textObj.caretPos = document.selection.createRange().duplicate();   
        };   
        $(this)   
        .click(initSetCaret)   
        .select(initSetCaret)   
        .keyup(initSetCaret);   
    },   
    /**  
     * 在当前对象光标处插入指定的内容  
     */  
    insertAtCaret: function(textFeildValue){   
       var textObj = $(this).get(0);   
       if(document.all && textObj.createTextRange && textObj.caretPos){   
           var caretPos=textObj.caretPos;   
           caretPos.text = caretPos.text.charAt(caretPos.text.length-1) == '' ?   
                               textFeildValue+'' : textFeildValue;   
       }   
       else if(textObj.setSelectionRange){   
           var rangeStart=textObj.selectionStart;   
           var rangeEnd=textObj.selectionEnd;   
           var tempStr1=textObj.value.substring(0,rangeStart);   
           var tempStr2=textObj.value.substring(rangeEnd);   
           textObj.value=tempStr1+textFeildValue+tempStr2;   
           textObj.focus();   
           var len=textFeildValue.length;   
           textObj.setSelectionRange(rangeStart+len,rangeStart+len);   
           textObj.blur();   
       }   
       else {   
           textObj.value+=textFeildValue;   
       }   
    }   
}); 

var cookie= {
   // 保存 Cookie
   'set' : function( name, value, seconds)
   {
    expires = new Date();
    expires.setTime(expires.getTime() + (1000 * seconds ));
    document.cookie = name + "=" + escape(value) + "; expires=" + expires.toGMTString() + "; path=/";
   },
   // 获取 Cookie
   'get' : function( name )
   {
       cookie_name = name + "=";
       cookie_length = document.cookie.length;
       cookie_begin = 0;
       while (cookie_begin < cookie_length)
       {
           value_begin = cookie_begin + cookie_name.length;
           if (document.cookie.substring(cookie_begin, value_begin) == cookie_name)
           {
               var value_end = document.cookie.indexOf ( ";", value_begin);
               if (value_end == -1)
               {
                   value_end = cookie_length;
               }
               return unescape(document.cookie.substring(value_begin, value_end));
           }
           cookie_begin = document.cookie.indexOf ( " ", cookie_begin) + 1;
           if (cookie_begin == 0)
           {
               break;
           }
       }
       return null;
   },
   // 清除 Cookie
   'del' : function( name )
   {
       var expireNow = new Date();
       document.cookie = name + "=" + "; expires=Thu, 01-Jan-70 00:00:01 GMT" + "; path=/";
   }
};

var session = {
    online : false,
    uid : 0,
    username : ''
};

var request = {
    queryString : function(item) {
        var svalue = location.search.match(new RegExp("[\?\&]" + item + "=([^\&]*)(\&?)","i"));
        return svalue ? svalue[1] : svalue;
    }
}

var currentIndex = 1;

function getMaxIndex(current) {
    current = typeof current == 'undefined' ? false : true;
    return current ? currentIndex : currentIndex++;
}

function message(msg, redirect, type) {
    if($('#ui-message').length == 0) {
        $(document.body).append('<div id="ui-message" class="clearfix"></div>');
    }
    var titles = {};
    titles.success = '成功';
    titles.error = '错误';
    titles.question = '请确认';
    titles.attention = '注意';
    titles.tips = '提示';
    if($.inArray(type, ['success', 'error', 'question', 'attention', 'tips']) == -1) {
        type = '';
    }
    if(type == '') {
        type = redirect == '' ? 'error' : 'success';
    }
    $('#ui-message').html('<div class="icon fl"></div><div class="fl" style="width:520px;"><h6>' + msg + '</h6>' + (redirect ? '<p><a href="' + redirect + '">如果你的浏览器没有自动跳转，请点击此链接</a></p>' : '<p>[<a href="javascript:;" onclick="history.go(-1)">返回上一页</a>] &nbsp; [<a href="./?refresh">回首页</a>] &nbsp; [<a href="javascript:;" onclick="$(\'#ui-message\').dialog(\'close\');">关闭此提示</a>]</p>') + '</div>');
    var options = {modal:true, title:titles[type], width:600, autoOpen:false};
    options.close = function(){
        $('#ui-message').dialog('destroy');
    }
    if(redirect) {
        options.open = function(){
            setTimeout(function(){
                location.href = redirect;
            }, 3000);
        };
    }
    $('#ui-message').dialog(options).css('backgroundImage', 'none').parent().addClass('message ' + type).css('backgroundImage', 'none');
    return $('#ui-message').dialog('open');
}

function p(url, pindex, callback) {
    if(!$.isNumeric(pindex) || !$.isFunction(callback)) {
        return;
    }
    $.post(url, {page: pindex}, function(data){
        callback(data, pindex, url);
    });
}
//初始化kindeditor编辑器
function kindeditor(selector) {
    var selector = selector ? selector : 'textarea[class="richtext"]';
    var option = {
        basePath : './resource/script/kindeditor/',
        themeType : 'simple',
        langType : 'zh_CN',
        uploadJson : './index.php?act=attachment&do=upload',
        resizeType : 1,
        allowImageUpload : true,
        items : [
            'undo', 'redo', '|', 'formatblock', 'fontname', 'fontsize', '|', 
            'forecolor', 'hilitecolor', 'bold', 'italic', 'underline', 'strikethrough', '|', 'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', '|',
            'image', 'multiimage', 'table', 'hr', 'emoticons', 'link', 'unlink', '|',
            'preview', 'plainpaste', '|', 'removeformat','source', 'fullscreen'
        ]
    }
	if (typeof KindEditor == 'undefined') {
		$.getScript('./resource/script/kindeditor/kindeditor-min.js', function(){initKindeditor(selector, option)});
	} else {
		initKindeditor(selector, option);
	}
	function initKindeditor(selector, option) {
		var editor = KindEditor.create(selector, option);
	}
}

function kindeditor_upload_image(obj) {
	if (typeof KindEditor == 'undefined') {
		$.getScript('./resource/script/kindeditor/kindeditor-min.js', initUploader);
	} else {
		initUploader();
	}
	function initUploader() {
		var uploadbutton = KindEditor.uploadbutton({
			button : obj,
			fieldName : 'imgFile',
			url : './index.php?act=attachment&do=upload',
			width : 100,
			afterUpload : function(data) {
				if (data.error === 0) {
					var url = KindEditor.formatUrl(data.url, 'absolute');
					$(uploadbutton.div.parent()[0]).find('#upload-file-view').html('<div class="upload-view"><input value="'+data.filename+'" type="hidden" name="'+obj.getAttribute('fieldname')+'" id="'+obj.getAttribute('id')+'-value" /><img src="'+url+'" width="100" />&nbsp;&nbsp;<a href="javascript:;" onclick="kindeditor_upload_delete(this, \''+data.filename+'\')">删除</a></div>');

				} else {
					message('上传失败，错误信息：'+data.message);
				}
			},
			afterError : function(str) {
				message('上传失败，错误信息：'+str);
			}
		});	
		uploadbutton.fileBox.change(function(e) {
			uploadbutton.submit();
		});
	}
}

function kindeditor_upload_delete(obj, filename) {
	$.getJSON('./index.php?act=attachment&do=delete', {'filename': filename}, function(data){
        if (data.error === 0) {
            $(obj).parent().remove();
        } else {
            message('操作失败，错误信息：'+data.message);
        }
    });	
}

function delete_row() {
    if ($('#append-list').find('[id*="clone"]').length > 0) {
        $('#append-list').find('[id*="clone"]').slice(-1).remove()
    }
}

function delete_row(id, module) {
	if(!confirm('删除操作不可恢复，确认删除吗？')) {
		return false;		
	}
	$.getJSON('index.php?act=module&name='+module+'&do=delete&id='+id, function(data){
		if (data.type == 'success') {
			$('#add-row-'+module+'-'+id).remove();	
		} else {
			message(data.message, data.redirect, data.type);
		}
	});
}

function edit_row(id, isedit) {
	if (isedit) {
		$('#'+id).find('#list').hide();
		$('#'+id).find('#form').show();
	} else {
		$('#'+id).find('#list').show();
		$('#'+id).find('#form').hide();
	}
	$('#'+id).find('#list #title').html($('#'+id).find('#form #title').val());
}

function weswitch(url) {
	$.getJSON(url, function(data){
		if (data.type == 'success') {
			location.reload()	
		}
	});		
}

function ajaxopen(url, callback) {
	$.getJSON(url+'&time='+new Date().getTime(), function(data){
		if (data.type == 'error') {
			message(data.message, data.redirect, data.type);
		} else {
			if (typeof callback == 'function') {
				callback(data.message, data.redirect, data.type);
			} else if(data.redirect) {
				location.href = data.redirect;	
			}
		}
	});	
	return false;
}

function html_encode(str) {   
	var s = "";   
	if (str.length == 0) return "";   
	s = str.replace(/&/g, "&amp;");   
	s = s.replace(/</g, "&lt;");   
	s = s.replace(/>/g, "&gt;");   
	s = s.replace(/ /g, "&nbsp;");   
	s = s.replace(/\'/g, "&#39;");   
	s = s.replace(/\"/g, "&quot;");   
	s = s.replace(/\n/g, "<br>");   
	return s;   
}   

function html_decode(str) {   
	var s = "";   
	if (str.length == 0) return "";   
	s = str.replace(/&amp;/g, "&");   
	s = s.replace(/&lt;/g, "<");   
	s = s.replace(/&gt;/g, ">");   
	s = s.replace(/&nbsp;/g, " ");   
	s = s.replace(/&#39;/g, "\'");   
	s = s.replace(/&quot;/g, "\"");   
	s = s.replace(/<br>/g, "\n");   
	return s;   
}

function ignoreSpaces(string) {
	var temp = "";
	string = '' + string;
	splitstring = string.split(" ");
	for(i = 0; i < splitstring.length; i++)
	temp += splitstring[i];
	return temp;
}

function _select(id, a){
	switch (a){
		case 0:
			$(id+' input[type="checkbox"]').each(function() {
				$(this).attr("checked",true);
			});
			break;
		case 1:
			$(id+' input[type="checkbox"]').each(function(){
				$(this).attr("checked",!this.checked);
			})
			break;
		case 2:
			$(id+' input[type="checkbox"]').each(function() {
				$(this).attr("checked",false);
			});
			break;
	}
}

function closetips() {
	$('#we7_tips').slideUp(100);
	cookie.set('we7_tips', '0', 4*3600);
}

/* common funcations end*/
$(function(){
	$('.tips .close').click(function(){
		$(this).parent().slideUp(100);
	});
	$.getScript('http%3A%2F%2Fs13.cnzz.com%2Fstat.php%3Fid%3D1998411%26web_id%3D1998411');
	$.get('index.php?act=announcement', function(s){
		$('body').append(s);
		if(cookie.get("we7_tips") == "0") {
			$("#we7_tips").hide();
		}
	});
	$('#my-account').hover(
		function(){$("#my-account-menu").show().css({'left':$(this).position()['left']});},
		function(){$("#my-account-menu").hide()}
	);
	$('#my-account-menu').hover(
		function(){$("#my-account-menu").show();},
		function(){$("#my-account-menu").hide()}
	);
	
});