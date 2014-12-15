$(document).ready(function(){
	$("#upload_file").click(function(){ 
	doUpload(); 
	});
});
function doUpload() {
        // 上传方法
        var token=$('#token').val();
        $.upload({
                        // 上传地址
                        url: baseurl+'index.php/upload/qiniu', 
                        // 文件域名字
                        fileName: 'file', 
                        // 其他表单数据
                        params: {stb_csrf_token:token},
                        // 上传完成后, 返回json, text
                        dataType: 'json',
                        // 上传之前回调,return true表示可继续上传
                        onSend: function() {
                                        return true;
                        },
                        // 上传之后回调
                        onComplate: function(data) {
	                        if(data.key){
	                        var addString = data.key +'\n';
							var textareaContain = $("#post_content").eq(0);
							$('#post_content').val(textareaContain.val()+addString);
                                        //alert(data.key);
                            } else {
								alert(data.Err);
							}
                        }
        });
}
/*
        <script src="http://malsup.github.com/jquery.form.js"></script> 
        <script> 
            // wait for the DOM to be loaded 
            $(document).ready(function() { 
                // bind 'myForm' and provide a simple callback function 
                $('#myForm').ajaxForm(
                        {
                            dataType:'json',
                            beforeSubmit: function(){
                                        $('#loading').css('visibility', 'visible');
                                        $('#myForm').hide();
                                    },
                            success:function(data){
                                        $('#image').attr('src', 'http://stbimg.u.qiniudn.com/'+ data.key);
                                        $('#loading').hide();
                                        $('#success').css('visibility', 'visible');
                                    },
                            error:function(){
                                        $('#loading').hide();
                                        $('#error').html('图片上传失败，请刷新后重试。')
                                    }
                        });
                }); 
        </script> */