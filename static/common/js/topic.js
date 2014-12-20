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
var token=$("#token").val();
  $.ajax({                                                 //调用jquery的ajax方法   
    type: "POST",                                     //设置ajax方法提交数据的形式    
    url: baseurl+"index.php/comment/add_comment",     //把数据提交到ok.php 
    data: "comment="+comment+"&topic_id="+$("#topic_id").val()+"&is_top="+$("#is_top").val()+"&username="+$("#username").val()+"&avatar="+$("#avatar").val()+"&lastpost="+$("#lastpost").val()+"&layer="+$("#layer").val()+"&stb_csrf_token="+token,    //输入框writer中的值作为提交的数据  
    dataType: 'json',  
    success: function(msg){                 //提交成功后的回调，msg变量是ok.php输出的内容。
    if(msg.uid){
	    var html="<div class='row' id='r"+msg.layer+"'><div class='col-md-1'><a href='"+siteurl+"user/profile/"+msg.uid+"'><img class='img-rounded' src='"+msg.avatar+"' alt='"+msg.username+"'></a></div><div class='col-md-11 reply-body'><h4 class='topic-list-heading'><span><a href='"+siteurl+"user/profile/"+msg.uid+"'>"+msg.username+"</a>&nbsp;&nbsp;<small>"+msg.replytime+"</small></span><span class='pull-right' id='r"+msg.layer+"'>#"+msg.layer+" -<a href='#reply' class='clickable startbbs'  data-mention='"+msg.username+"'>回复</a></span></h4>"+msg.content+"</div></div><hr class='smallhr'>";
	    $('#comment_list').append(html);
	    $('#comments').html(msg.layer);//改变回复数
	    $('#lastpost').val(msg.lastpost);//更新最后时间
	    $('#error').html('');    //清空错误
    }else{
	    $('#error').html('<div class="alert alert-warning">'+msg.error+'</div>');//提示错误
    }

}
  });
}




//快速回复ctrl+enter
    $(document).keypress(function(e){
        var active_id = document.activeElement.id;  
        if((e.ctrlKey && e.which == 13 || e.which == 10) && (active_id == "topic_content" || active_id == "post_content")) {
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
	moveEnd(replyContent);
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