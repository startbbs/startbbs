			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('#topic_content', {
					width : '100%',
					resizeType : 1,
					allowPreviewEmoticons : false,
					allowImageUpload : false,
					items : [
						'source', '|', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
						'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
						'insertunorderedlist', '|', 'emoticons', 'image','multiimage', 'link', '|','clearhtml','code'],
				    filterMode :true,
				    htmlTags:{    //以下为不需要过滤过的字符
				        font : ['color', 'size', 'face', '.background-color'],
				        span : ['style'],
				        div : ['class', 'align', 'style'],
				        table: ['class', 'border', 'cellspacing', 'cellpadding', 'width', 'height', 'align', 'style'],
				        'td,th': ['class', 'align', 'valign', 'width', 'height', 'colspan', 'rowspan', 'bgcolor', 'style'],
				        a : ['class', 'href', 'target', 'name', 'style'],
				        embed : ['src', 'width', 'height', 'type', 'loop', 'autostart', 'quality',
				        'style', 'align', 'allowscriptaccess', '/'],
				        img : ['src', 'width', 'height', 'border', 'alt', 'title', 'align', 'style', '/'],
				        hr : ['class', '/'],
				        br : ['/'],
				        'p,ol,ul,li,blockquote,h1,h2,h3,h4,h5,h6' : ['align', 'style'],
				        'tbody,tr,strong,b,sub,sup,em,i,u,strike' : [],
				        pre : ['class']
				        },

				    afterCreate : function() {
					var self = this;
					K.ctrl(document, 13, function() {
						self.sync();
						K('form[name=add_new]')[0].submit();
					});
					K.ctrl(self.edit.doc, 13, function() {
						self.sync();
						K('form[name=add_new]')[0].submit();
					});
					}

				});
			});
