$(document).ready(function(){
    var base_url = $("#base_url").data('base_url');
   
    //删除视频
    $("#delete_series_modal").on('show.bs.modal', function(event){
        var modal = $(this);
        var btn = $(event.relatedTarget);
        var message = modal.find('.collapse');
        
        message.bind('click', function(){
            $(this).collapse('hide');
        })
        
        modal.find('#series_to_delete').text(btn.data('title'));
        
        modal.find('#delete_series_confirm_btn').click(function(){
           $.ajax({
            type:"post",
            url:base_url + "index.php/admin/video_manage/delete_series",
            dataType: "json",
            data:{
                "id":btn.data('id'),
            },
            success:function(data){
                message.text(data).collapse('show');
            },
            error:function(XMLHttpRequest){
                message.text(XMLHttpRequest.statusText).removeClass('bg-info').addClass('bg-danger').collapse('show');
            }
           });
        });
    });
    
    $("#delete_series_modal").on('hidden.bs.modal', function(){
        location.reload();
    });
    
    //添加视频
    $("#add_series_modal").on('show.bs.modal', function(){
        var modal = $(this);
        var btn = modal.find('#add_modal_confirm_btn');
        var cover = modal.find("#cover");
        var message = modal.find('#status');
        var progress = modal.find('.progress');
        var progress_bar = progress.find(".progress-bar");
        var progress_data = progress.find('#progress_data');
        var title = modal.find("#title");
        var brief = modal.find("#brief");
        var is_open = modal.find("#is_open");
        var status = 0;
        var file_type = '';
        
        message.bind('click', function(){
            $(this).collapse('hide');
        })
        
        progress.bind('click', function(){
           $(this).collapse('hide'); 
        });
        
        is_open.click(function(){
            if($(this).is(':checked')){
                status = 1;
            }else{
                status = 0;
            }
        });
        
        cover.change(function(){
            file_type = (cover.val().split('.').reverse())[0];
            
            modal.find('#input_info').collapse('show').text(cover.val()).click(function(){
               $(this).collapse('hide');
            });         
        });
        
        btn.click(function(){
            if('' == title.val() || '' == cover.val()){
                info('输入信息不完整');
                return;
            }
            
            progress.collapse('show');
            var xhr = new XMLHttpRequest();
            var form_data = new FormData(document.getElementById('add_series_form'));
            form_data.append('title', title.val());
            form_data.append('brief', brief.val());
            form_data.append('file_type', file_type);
            form_data.append('status', status);
            
            xhr.upload.addEventListener('progress', upload_progress, false);    
            xhr.responseType = 'json';
            xhr.open("POST", base_url + 'index.php/admin/video_manage/add_series');
            xhr.onload = function(){
                if(xhr.status == 200){
                    info(xhr.response);
                    progress_bar.removeClass('active');
                }else{
                    info('error');
                }
            }
            xhr.send(form_data);
        });
        
        function upload_progress(evt){
            if (evt.lengthComputable) {
                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                progress_bar.width(percentComplete + '%');
                progress_data.text(percentComplete + '%');
            } else {
                info('不能读取文件长度');
            }
        }
        
        function info(text){
            message.text(text).collapse('show');
        }
    });
    
    $("#add_series_modal").on('hidden.bs.modal', function(){
        location.reload();
    });
    
    //修改信息
    $("#modify_series_modal").on('show.bs.modal', function(event){
        var btn_click = $(event.relatedTarget);
        var modal = $(this);
        var btn = modal.find('#confirm_btn');
        var cover = modal.find("#cover");
        var message = modal.find('#status');
        var progress = modal.find('.progress');
        var progress_bar = progress.find(".progress-bar");
        var progress_data = progress.find('#progress_data');
        var title = modal.find("#title");
        var brief = modal.find("#brief");
        var amount = modal.find("#amount");
        var is_open = modal.find("#is_open");
        var status = 0;
        var file_type = '';
        
        title.val(btn_click.data('title'));
        brief.val(btn_click.data('brief'));
        amount.val(btn_click.data('amount'));
        
        message.bind('click', function(){
            $(this).collapse('hide');
        })
        
        progress.bind('click', function(){
           $(this).collapse('hide'); 
        });
        
        cover.change(function(){
            file_type = (cover.val().split('.').reverse())[0];
            
            modal.find('#input_info').collapse('show').text(cover.val()).click(function(){
               $(this).collapse('hide');
            });         
        });
        
        is_open.click(function(){
            if($(this).is(':checked')){
                status = 1;
            }else{
                status = 0;
            }
        });
        
        if(1 == btn_click.data('status')){
            is_open.attr('checked', 'checked');
        }
        
        btn.click(function(){
            if('' == title.val() || '' == amount.val()){
                info('输入信息不完整');
                return;
            }
            
            if(is_open.is(':checked')){
                status = 1;
            }else{
                status = 0;
            }
            
            progress.collapse('show');
            var xhr = new XMLHttpRequest();
            var form_data = new FormData(document.getElementById('modify_series_form'));
            form_data.append('title', title.val());
            form_data.append('brief', brief.val());
            form_data.append('file_type', file_type);
            form_data.append('amount', amount.val());
            form_data.append('id', btn_click.data('id'));
            form_data.append('status', status);
            
            xhr.upload.addEventListener('progress', upload_progress, false);  
            xhr.responseType = 'json';
            xhr.open("POST", base_url + 'index.php/admin/video_manage/edit_series');
            xhr.onload = function(){
                if(xhr.status == 200){
                    info(xhr.response);
                    progress_bar.removeClass('active');
                }else{
                    info('error');
                }
            }
            xhr.send(form_data);
        });
        
        function upload_progress(evt){
            if (evt.lengthComputable) {
                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                progress_bar.width(percentComplete + '%');
                progress_data.text(percentComplete + '%');
            } else {
                info('不能读取文件长度');
            }
        }
        
        function info(text){
            message.text(text).collapse('show');
        }
    });
    
    $("#modify_series_modal").on('hidden.bs.modal', function(){
        location.reload();
    });
    
    $("#search_video_title_button").click(function(){
        var search_str = $("#search_video_title").val();
        if('' == search_str){
            return;
        }
        location.href = base_url + 'index.php/admin/video_manage/search/' + search_str;
    });
});
