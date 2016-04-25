$(document).ready(function(){
   var base_url = $("#base_url").data('base_url');
   
   //添加视频
   $("#add_video_modal").on('show.bs.modal', function(event){
        var btn_click = $(event.relatedTarget);
        var modal = $(this);
        var btn = modal.find('#confirm_btn');
        var file = modal.find("#video_file");
        var message = modal.find('#status');
        var progress = modal.find('.progress');
        var progress_bar = progress.find(".progress-bar");
        var progress_data = progress.find('#progress_data');
        var series = modal.find("#series");
        var index = modal.find('#index');
        var is_open = modal.find("#is_open");
        var title = modal.find('#title');
        var cover = modal.find('#cover');
        var status = 0;
        var file_type = '';
        
        series.val(btn_click.data('series_title'));
        
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
        
        file.change(function(){
            file_type = (file.val().split('.').reverse())[0];      
        });
        
        btn.click(function(){
            progress.collapse('show');
            var xhr = new XMLHttpRequest();
            var form_data = new FormData(document.getElementById('add_video_form'));
            form_data.append('series_id', btn_click.data('series_id'));
            form_data.append('index', index.val());
            form_data.append('status', status);
            form_data.append('file_type', file_type);
            form_data.append('title', title.val());
            
            xhr.upload.addEventListener('progress', upload_progress, false);   
            xhr.responseType = 'json';
            xhr.open("POST", base_url + 'index.php/admin/video_manage/add_video');
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
   
   $("#add_video_modal").on('hidden.bs.modal', function(){
       location.reload();
   });
   
   //删除视频
   $("#delete_video_modal").on('show.bs.modal', function(event){
       var modal = $(this);
       var btn = $(event.relatedTarget);
       var message = modal.find('.collapse');
       
       message.bind('click', function(){
           $(this).collapse('hide');
       });
       
       modal.find('#index').text(btn.data('index'));
       
       modal.find('#confirm_btn').click(function(){
           $.ajax({
           type:"post",
           url:base_url + "index.php/admin/video_manage/delete_video",
           dataType: "json",
           data:{
               "series_id":btn.data('series_id'),
               "video_id":btn.data('video_id'),
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
   
   $("#delete_video_modal").on('hidden.bs.modal', function(){
       location.reload();
   });
   
   //修改视频
   $("#modify_video_modal").on('show.bs.modal', function(event){
        var btn_click = $(event.relatedTarget);
        var modal = $(this);
        var btn = modal.find('#confirm_btn');
        var file = modal.find("#video_file");
        var message = modal.find('#status');
        var progress = modal.find('.progress');
        var progress_bar = progress.find(".progress-bar");
        var progress_data = progress.find('#progress_data');
        var index = modal.find('#index');
        var is_open = modal.find("#is_open");
        var title = modal.find('#title');
        var status = 0;
        var file_type = '';
        
        index.val(btn_click.data('index'));
        
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
        
        title.val(btn_click.data('title'));
        
        if(1 == btn_click.data('status')){
            is_open.attr('checked', 'checked');
        }
        
        file.change(function(){
            file_type = (file.val().split('.').reverse())[0];
            
            modal.find('#input_info').collapse('show').text(file.val()).click(function(){
               $(this).collapse('hide');
            });     
        });
        
        btn.click(function(){
            if(is_open.is(':checked')){
                status = 1;
            }else{
                status = 0;
            }
            progress.collapse('show');
            var xhr = new XMLHttpRequest();
            var form_data = new FormData(document.getElementById('modify_series_form'));
            form_data.append('series_id', btn_click.data('series_id'));
            form_data.append('video_id', btn_click.data('video_id'));
            form_data.append('index', index.val());
            form_data.append('status', status);
            form_data.append('file_type', file_type);
            
            xhr.upload.addEventListener('progress', upload_progress, false);   
            xhr.responseType = 'json';
            xhr.open("POST", base_url + 'index.php/admin/video_manage/edit_video');
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
   
   $("#modify_video_modal").on('hidden.bs.modal', function(){
       location.reload();
   });
});
