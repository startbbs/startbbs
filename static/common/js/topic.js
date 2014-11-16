$(document).ready(function(){        //DOM的onload事件处理函数
  $("#comment-submit").click(function(){          //当按钮button被点击时的处理函数
	if(check_content()){
	postdata(); 
    //button被点击时执行postdata函数
   $("#post_content").val('').focus();//提交清空内容
	}    
  });
    //@回复
    $(".clickable").click(function(){
        var append_str = "@" + $(this).attr("data-mention") + " ";
         $("#post_content").insertAtCaret(append_str);
    });
    //@回复定位
    $(".reply").click(function(){
         $("#post_content").insertAtCaret('');
    });
});
function postdata(){                             //提交数据函数
var comment=$("#post_content").val();
  $.ajax({                                                 //调用jquery的ajax方法   
    type: "POST",                                     //设置ajax方法提交数据的形式    
    url: baseurl+"index.php/comment/add_comment",     //把数据提交到ok.php 
    data: "comment="+comment+"&topic_id="+$("#topic_id").val()+"&is_top="+$("#is_top").val()+"&username="+$("#username").val()+"&avatar="+$("#avatar").val()+"&layer="+$("#layer").val(),    //输入框writer中的值作为提交的数据  
    dataType: 'json',  
    success: function(msg){                 //提交成功后的回调，msg变量是ok.php输出的内容。
    var html="<article><div class='cell hoverable reply' id='comment_988'><table border='0' cellpadding='0' cellspacing='0' width='100%'><tr><td valign='top' width='48'><a href='"+siteurl+"user/profile/"+msg.uid+"' class='profile_link' title='"+msg.username+"'><img alt='"+msg.username+" medium avatar' class='medium_avatar' src='"+msg.avatar+"' /></a></td><td width='10'></td><td valign='top' width='auto'><div class='pull-right'><small class='snow'>#<span id='add'>"+msg.layer+"</span> -"+msg.replytime+"<a href='#reply' onclick='replyOne('"+msg.username+"');'><img align='absmiddle' alt='Reply_button' border='0' id='mention_button' class='clickable mention_button' data-mention='"+msg.username+"' src='"+baseurl+"static/common/images/reply_button.png' /></a></small></div><a href='"+siteurl+"user/profile/"+msg.uid+"' class='dark startbbs profile_link' title='"+msg.username+"'>"+msg.username+"</a><span class='snow'>&nbsp;&nbsp;</span><div class='sep5'></div><div class='content reply_content'>"+msg.content+"</div></div></td></tr></table></div></article>";
    $('#clist').append(html);
    $('#comments').html(msg.layer);//改变回复数
      //alert("数据提交成功");                     //如果有必要，可以把msg变量的值显示到某个DIV元素中    
}
  });
}

//快速回复ctrl+enter
    $(document).keypress(function(e){
        var active_id = document.activeElement.id;
        var currKey = e.keyCode || e.which || e.charCode;
        if((e.ctrlKey && currKey == 13 || currKey == 10) && (active_id == "topic_content" || active_id == "post_content")) {
            e.preventDefault();
          //  $("#new_topic").submit();
            $("input[type=submit]").click();
        }
    });

function replyOne(username){
    replyContent = $("#post_content");
	oldContent = replyContent.val();
	prefix = "@" + username + " ";
	newContent = ''
	if(oldContent.length > 0){
	    if (oldContent != prefix) {
	        newContent = oldContent + "\n" + prefix;
	    }
	} else {
	    newContent = prefix
	}
	replyContent.focus();
	replyContent.val(newContent);
	//moveEnd(replyContent);
}
function check_content(){
if($("#post_content").val().length < 4){
alert("对不起，回复内容不能少于4个字符！")
$("#post_content").focus();
return false;
} else{
	return true;
}
}
