$(document).ready(function() {
  $("#post_content").cleditor({
    controls:     // controls to add to the toolbar
      "bold italic underline strikethrough | font size " +
      "style | color highlight removeformat | bullets numbering | outdent " +
      "indent | alignleft center alignright justify | undo redo | " +
      "rule image link unlink | source"
  });
	var editor = $("#post_content").cleditor()[0];
	editor.updateFrame().focus()
	$("#comment-submit").click(function(){
		//editor.refresh().focus();
		editor.updateFrame().focus();
		
		//editor.clear();
		//editor.focus();
	});
    //@回复
    //$(".clickable").click(function(){
    //    var append_str = "@" + $(this).attr("data-mention") + " ";
    //    $("#post_content").cleditor().insertAtCaret(append_str);
    //});
	$(".clickable").click(function(){
	//$("#mention_button").live('click',function(){
	var uname ="@"+$(this).attr('data-mention')+" ";
	//var currentval = $("#post_content").val();
	//$("#post_content").val(currentval+' @test ');
	//editor.updateFrame();
   editor.execCommand('inserthtml',uname).focus();
	});
});