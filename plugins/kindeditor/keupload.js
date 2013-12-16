			KindEditor.ready(function(K) {
				var uploadbutton = K.uploadbutton({
					button : K('#upload-tip')[0],
					fieldName : 'imgFile',
					url :baseurl+'/plugins/kindeditor/php/upload_json.php?dir=mix',
					afterUpload : function(data) {
						if (data.error === 0) {
							var url = K.formatUrl(data.url, 'absolute');
							url=url.replace('/upload','upload'); 
							var addString = baseurl+url +'\n';
							var textareaContain = $("#textContain textarea").eq(0);
							K('#textContain textarea').val(textareaContain.val()+addString);
							//$("#test").append(addString);


						} else {
							alert(data.message);
						}
					},
					afterError : function(str) {
						alert('自定义错误信息: ' + str);
					}
				});
				uploadbutton.fileBox.change(function(e) {
					uploadbutton.submit();
				});
			});