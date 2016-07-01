$(document).ready(function(){
    var base_url = $("#base_url").data('base_url');
    
    //添加文章
    $("#add_article_modal").on('show.bs.modal', function(){
        var modal = $(this);
        var btn = modal.find('#confirm_btn');
        var message = modal.find('#response');
        var progress = modal.find('#upload_progress');
        var progress_bar = progress.find(".progress-bar");
        var progress_data = progress.find('#progress_data');
        var title = modal.find('#title');
        var indexing = modal.find('#indexing');
        var content = modal.find('#content');
        var is_open = modal.find("#is_open");
        var status = 0;
        
        message.bind('click', function(){
            $(this).collapse('hide').text('');
        })
        
        progress.bind('click', function(){
           $(this).collapse('hide');
           progress_bar.width('0%');
           progress_data.text('0%');
        });
        
        is_open.click(function(){
           if($(this).is(':checked')){
               status = 1;
           }else{
               status = 0;
           }
        });
         
        btn.click(function(){
            
            if('' == title.val()){
                info('标题不能为空');
                return;
            }else if('' == indexing.val()){
                info('显示顺序不能为空');
                return;
            }else if(editor.isEmpty()){
                info('内容不能为空');
                return;
            }
            
            progress.collapse('show');
            clear();
            
            var xhr = new XMLHttpRequest();
            var form_data = new FormData(document.getElementById('add_article_form'));
            form_data.append('title', title.val());
            form_data.append('indexing', indexing.val());
            form_data.append('content', editor.html());
            form_data.append('status', status);
            
            xhr.upload.addEventListener('progress', upload_progress, false);   
            xhr.responseType = 'json';
            xhr.open("POST", base_url + 'index.php/admin/article_manage/add');
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
        
        function clear()
        {
            progress_bar.width('0%');
            progress_data.text('0%');
            message.text('');
        }
        
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
    
    $("#add_article_modal").on('hidden.bs.modal', function(){
        location.reload(); 
     });
    
    //生成编辑器
    KindEditor.ready(function(K) {
        var options = {
                width: '100%',
                minHeight: '300px',
                items: [
                    'preview', '|', 'undo', 'redo', '|','justifyleft', 'justifycenter', 'justifyright',
                    'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent','subscript',
                    'superscript', '|', 'fullscreen', '/','formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                    'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'insertfile',
                    'table', 'hr', 'emoticons', 'anchor', 'link', 'unlink',
                ],
                resizeType: 1,
                uploadJson: base_url + 'index.php/admin/article_manage/upload_file',
        };
        window.editor = K.create('#content', options);
    });
    
    //删除文章
    $("#delete_article_modal").on('show.bs.modal', function(event){
        var modal = $(this);
        var btn = $(event.relatedTarget);
        var message = modal.find('.collapse');
        var title = modal.find('#article_to_delete');
        
        title.text(btn.data('title'));
        
        message.bind('click', function(){
            $(this).collapse('hide').text('');
        });
        
        modal.find('#confirm_btn').click(function(){
            $.ajax({
            type:"post",
            url:base_url + "index.php/admin/article_manage/delete",
            dataType: "json",
            data:{
                'id': btn.data('id'),
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
    
    $("#delete_article_modal").on('hidden.bs.modal', function(){
        location.reload();
    });
    
    //修改文章
    $("#modify_article_modal").on('show.bs.modal', function(event){
        var modal = $(this);
        var btn = $(event.relatedTarget);
        var confirm_btn = modal.find('#confirm_btn');
        var message = modal.find('#response');
        var progress = modal.find('#upload_progress');
        var progress_bar = progress.find(".progress-bar");
        var progress_data = progress.find('#progress_data');
        var download_progress = modal.find('#download_progress');
        var download_progress_bar = download_progress.find(".progress-bar");
        var download_progress_data = download_progress.find('#progress_data');
        var title = modal.find('#title');
        var indexing = modal.find('#indexing');
        var content = modal.find('#content');
        var is_open = modal.find("#is_open");
        var status = 0;
        
        message.bind('click', function(){
            $(this).collapse('hide').text('');
        })
        
        progress.bind('click', function(){
           $(this).collapse('hide');
           progress_bar.width('0%');
           progress_data.text('0%');
        });
        
        download_progress.bind('click', function(){
            $(this).collapse('hide');
            download_progress_bar.width('0%');
            download_progress_data.text('0%');
        });
        
        download_progress.collapse('show');
        var xhr = new XMLHttpRequest();
        var form_data = new FormData();  
        form_data.append('id', btn.data('id'));
        
        xhr.addEventListener('progress', download, false);   
        xhr.responseType = 'json';
        xhr.open("POST", base_url + 'index.php/admin/article_manage/get_article');
        xhr.onload = function(){
            if(xhr.status == 200){
                var data = xhr.response;
                title.val(data.title);
                indexing.val(data.indexing);
                modify_editor.html(data.content);
                if(data.status == 1){
                    is_open.attr('checked', 'checked');
                }
            }else{
                info('获取内容失败');
            }
        }
        xhr.send(form_data); 
        
        function download(evt){        
            if (evt.lengthComputable) {
                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                download_progress_bar.width(percentComplete + '%');
                download_progress_data.text(percentComplete + '%');
            } else {
                info('不能读取文件长度');
            }
        }
         
        confirm_btn.click(function(){
            if('' == title.val()){
                info('标题不能为空');
                return;
            }else if('' == indexing.val()){
                info('显示顺序不能为空');
                return;
            }else if(modify_editor.isEmpty()){
                info('内容不能为空');
                return;
            }     
            
            if(is_open.is(':checked')){
                status = 1;
            }else{
                status = 0;
            }

            progress.collapse('show');
            clear();
            
            var xhr = new XMLHttpRequest();
            var form_data = new FormData(document.getElementById('modify_article_modal'));
            form_data.append('id', btn.data('id'));
            form_data.append('title', title.val());
            form_data.append('indexing', indexing.val());
            form_data.append('content', modify_editor.html());
            form_data.append('status', status);
            
            xhr.upload.addEventListener('progress', upload_progress, false);   
            xhr.responseType = 'json';
            xhr.open("POST", base_url + 'index.php/admin/article_manage/update');
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
        
        function clear()
        {
            progress_bar.width('0%');
            progress_data.text('0%');
            message.text('');
        }
        
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
    
    $("#modify_article_modal").on('hidden.bs.modal', function(){
        location.reload();
    });
    
    //生成修改文章的编辑器
    KindEditor.ready(function(K) {
        var options = {
                width: '100%',
                minHeight: '300px',
                items: [
                    'preview', '|', 'undo', 'redo', '|','justifyleft', 'justifycenter', 'justifyright',
                    'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent','subscript',
                    'superscript', '|', 'fullscreen', '/','formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                    'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'insertfile',
                    'table', 'hr', 'emoticons', 'anchor', 'link', 'unlink',
                ],
                resizeType: 1,
                uploadJson: base_url + 'index.php/admin/article_manage/upload_file',
        };
        window.modify_editor = K.create('#modify_content', options);
    });
    
    //搜索
    $("#search_btn").click(function(){
        var search_str = $("#search").val();
        if('' == search_str){
            return false;
        }else{
            location.href = base_url + 'index.php/admin/article_manage/search/' + search_str;
        }
    });
});
