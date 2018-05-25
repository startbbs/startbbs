
/**
 * JS主入口
 */
var $ = layui.jquery,
	layer = layui.layer,
    laydate = layui.laydate,
    form = layui.form;
    upload = layui.upload;
/**
 * AJAX全局设置
 */
$.ajaxSetup({
    type: "post",
    dataType: "json"
});

/**
 * 通用单图上传
 */

upload.render({
    elem: '#test1',
    url: '/api.php/upload/upload',
    size:100,
    done: function(res){
        //如果上传失败
        if(res.code > 0){
            return layer.msg('上传失败');
        }
        //上传成功
        layer.msg("上传成功");
        $("#thumb").val(res.data);
    }
});

/*layui.upload({
    url: "/index.php/api/upload/upload",
    type: 'image',
    ext: 'jpg|png|gif|bmp',
    success: function (data) {
        if (data.error === 0) {
            document.getElementById('thumb').value = data.url;
        } else {
            layer.msg(data.message);
        }
    }
});*/

/**
 * 通用日期时间选择
 */
$('.datetime').on('click', function () {
    laydate({
        elem: this,
        istime: true,
        format: 'YYYY-MM-DD hh:mm:ss'
    })
});

/**
 * 通用表单提交(AJAX方式)
 */
form.on('submit(*)', function (data) {
    $.ajax({
        url: data.form.action,
        type: data.form.method,
        data: $(data.form).serialize(),
        success: function (info) {
            if (info.code === 1) {
                setTimeout(function () {
                    location.href = info.url;
                }, 1000);
            }
            layer.msg(info.msg);
        }
    });

    return false;
});

/**
 * 通用批量处理（审核、取消审核、删除）
 */
$('.ajax-action').on('click', function () {
    var _action = $(this).data('action');
    layer.open({
        shade: false,
        content: '确定执行此操作？',
        btn: ['确定', '取消'],
        yes: function (index) {
            $.ajax({
                url: _action,
                data: $('.ajax-form').serialize(),
                success: function (info) {
                    if (info.code === 1) {
                        setTimeout(function () {
                            location.href = info.url;
                        }, 1000);
                    }
                    layer.msg(info.msg);
                }
            });
            layer.close(index);
        }
    });

    return false;
});

/**
 * 通用全选
 */
$('.check-all').on('click', function () {
    $(this).parents('table').find('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
});

/**
 * 通用删除
 */
$('.ajax-delete').on('click', function () {
    var _href = $(this).attr('href');
    layer.open({
        shade: false,
        content: '确定删除？',
        btn: ['确定', '取消'],
        yes: function (index) {
            $.ajax({
                url: _href,
                type: "get",
                success: function (info) {
                    if (info.code === 1) {
                        setTimeout(function () {
                            location.href = info.url;
                        }, 1000);
                    }
                    layer.msg(info.msg);
                }
            });
            layer.close(index);
        }
    });

    return false;
});
/**
 * 通用弹出消息并跳转
 */
 $('.action').on('click', function () {
	var _href = $(this).data("url");
    $.ajax({
	    url: _href,
        type: "get",
		success: function (info) {
            if (info.code === 1) {
                setTimeout(function () {
                    location.href = info.url;
                }, 1000);
            }
			layer.msg(info.msg);
		}
    });
});

  //搜索
  $('.fly-search').on('click', function(){
	var url = $(this).data("url");
    layer.open({
      type: 1
      ,title: false
      ,closeBtn: false
      //,shade: [0.1, '#fff']
      ,shadeClose: true
      ,maxWidth: 10000
      ,skin: 'fly-layer-search'
      ,content: ['<form action="' + url + '">'
        ,'<input autocomplete="off" placeholder="搜索内容，回车跳转" type="text" name="k">'
      ,'</form>'].join('')
      ,success: function(layero){
        var input = layero.find('input');
        input.focus();

        layero.find('form').submit(function(){
          var val = input.val();
          if(val.replace(/\s/g, '') === ''){
            return false;
          }
          input.val(input.val());
      });
      }
    })
  });
/**
 * ajax-get请求操作
 */
$('.ajax-confirm').on('click', function () {
	var _text=$(this).text();
    var _href = $(this).data("url");
    layer.open({
        shade: false,
        content: '你确定'+_text+'？',
        btn: ['确定', '取消'],
        yes: function (index) {
            $.ajax({
                url: _href,
                type: "get",
                success: function (info) {
                    if (info.code === 1) {
                        setTimeout(function () {
                            location.href = info.url;
                        }, 1000);
                    }
                    layer.msg(info.msg,{icon: 1});
                }
            });
            layer.close(index);
        }
    });
	return false;
});

/**
 * 通知弹出消息
 */
 $('.ajax-notice').on('click', function () {
	var _href = $(this).data("url");
    $.ajax({
	    url: _href,
        type: "get",
		success: function (info) {
            if (info.code === 1) {
                setTimeout(function () {
                    location.href = info.url;
                }, 1000);
            }
			layer.msg(info.msg);
		}
    });
});