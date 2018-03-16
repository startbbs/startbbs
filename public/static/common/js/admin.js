/**
 * 后台侧边菜单选中状态
 */
$('.layui-nav-item').find('a').removeClass('layui-this');
$('.layui-nav-tree').find('a[href*="' + GV.current_controller + '"]').parent().addClass('layui-this').parents('.layui-nav-item').addClass('layui-nav-itemed');

//监听指定开关
    form.on('switch', function(data){
	    $(data.othis).siblings('input').remove();
	    $(data.othis).after('<input type="hidden" name='+ $(data.elem).attr('name') +' value='+ (data.elem.checked ? '1' : '0') +'>');
    });

/**
 * 清除缓存
 */
$('#clear-cache').click(function(){
    var _url = $(this).data('url');
    if (_url !== 'undefined') {
        $.ajax({
            url: _url,
        	type: "get",//支持php6
            success: function (data) {
                if (data.code === 1) {
                    setTimeout(function () {
                        location.href = location.pathname;
                    }, 1000);
                }
                layer.msg(data.msg);
            }
        });
    }
    return false;
});
