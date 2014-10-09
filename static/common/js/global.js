
// JavaScript Document
$(function(){
	//$('#reply_content').bind("blur focus keydown keypress keyup", function(){
	//	recount();
	//});
    $("#myform").submit(function(){
		//var submitData = $(this).serialize();
		var comment = $('#reply_content').val();
		var topic_id = $("#topic_id").val();
		var is_top = $("#is_top").val();
		if(comment==""){
			$("#msg").show().html("你总得说点什么吧.").fadeOut(2000);
			return false;
		}
		$('.counter').html('<img style="padding:8px 12px" src="Images/load.gif" alt="正在处理..." />');
		$.ajax({
		   type: "POST",
		   url: siteurl+"/comment/add_comment",
		   //data: submitData
		   data:"comment="+comment+"&topic_id="+topic_id+"&is_top="+is_top,
		   dataType: "html",
		   success: function(msg){
			  if(parseInt(msg)!=0){
				 $('#saywrap').prepend(msg);
				 $('#reply_content').val('');
				 recount();
				 window.location.reload(true);
			 }else{
				$("#msg").show().html("系统错误.").fadeOut(2000);
				return false;
			 }
		  }
	    });
		return false;
	});
});
                
function recount(){
	var maxlen=140;
	var current = maxlen-$('#reply_content').val().length;
	$('.counter').html(current);

	if(current<1 || current>maxlen){
		$('.counter').css('color','#D40D12');
		$('input.btn btn-small').attr('disabled','disabled');
	}
	else
		$('input.btn btn-small').removeAttr('disabled');

	if(current<10)
		$('.counter').css('color','#D40D12');

	else if(current<20)
		$('.counter').css('color','#5C0002');

	else
		$('.counter').css('color','#cccccc');

}

//	/*添加回复*/
//	$(".clickable").live('click',function(){
//		/*var name=$('a:first',$(this).parent()).text();*/
//		/*var data = $('.clickable').attr("data-mention");*/
//		var name =$('.clickable').attr('data-mention');
//		$('#reply_content').val('@'+name+' ').focus();
//		return false;
//	});
// reply a reply
function replyOne(username){
    replyContent = $("#reply_content");
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