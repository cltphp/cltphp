$("#style_color").spectrum({
    showPaletteOnly: true,
    showPalette:true,
    hideAfterPaletteSelect:true,
    palette: [
        ['#FF5722','#5FB878','#1E9FFF','#F7B824'],
        ['#666666','#000000','#999933','#CCFF00'],
        ['#FF9900','#333399','#009966','#FF33CC']
    ]
});
/**
 * 取消缩略图
 */
$('#clearThumb').click(function(){
   $(this).parent('.layui-upload').prev('input').val('');
   $(this).next('.layui-upload-list').children('.layui-upload-img').attr('src','/static/admin/images/tong.png');
});
