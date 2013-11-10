			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('#reply_content', {
					width : '100%',
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : true,
					newlineTag : 'br',
					afterBlur:function(){editor.sync();},
					items : [
						'source', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image','multiimage', 'link', '|','clearhtml','code'],

					afterCreate: function() { 
						var self = this;
						K.ctrl(document, 13, function() { 
						self.sync();
						$("input[type=submit]").click(); 
						});
						K.ctrl(self.edit.doc, 13, function() { 
						self.sync();
						$("input[type=submit]").click();
						});
					}

				});
				$(".clickable").click(function(){
				//$("#mention_button").live('click',function(){
				var uname =$(this).attr('data-mention');
                editor.insertHtml('@'+uname+' ');
        		});
        		//Çå³ýÄÚÈÝ
        		$("#comment-submit").click(function(){
        		editor.html('');
        		});
        		
			});
