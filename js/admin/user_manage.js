$(document).ready(function(){
    var base_url = $("#base_url").data('base_url');
    
    //添加用户
    var add_user_modal = $("#add_user_modal");    
    
//    add_user_modal.on('hidden.bs.modal', function(){
//    	location.reload();
//    });
    
    add_user_modal.on('show.bs.modal', function(){
        var this_modal = $(this);
        var user_name = this_modal.find('#user_name');
        var password = this_modal.find('#password');
        var use_default_password = this_modal.find("#use_default_password");
        var message = this_modal.find(".message");
        
        message.bind('click', function(){
            $(this).collapse('hide');
        })
        
        this_modal.find("#add_user_confirm_btn").bind('click', function(){
            if('' == user_name.val() || '' == password.val()){
            	message.collapse('show').text('用户名和密码不能为空');
            	return;
            }
        	
            $.ajax({
                type:"post",
                url:base_url + "index.php/admin/user_manage/add_user",
                dataType:"json",
                data:{
                    "user_name":user_name.val(),
                    "password":$.md5(password.val()),
                },
                success:function(data){
                    message.text(data).collapse('show');
                },
                error:function(XMLHttpRequest){
                    message.text(XMLHttpRequest.statusText).removeClass('bg-info').addClass('bg-danger').collapse('show');
                }
            });
        });
        
        use_default_password.bind('click', function(){
            if($(this).is(':checked')){
            	password.val('888888').attr('readonly', 'readonly');
            }else{
            	password.val('').removeAttr('readonly');
            }
        });
    });
    
    //删除用户
    var delete_user_modal = $("#delete_user_modal");
    
//    delete_user_modal.on('hidden.bs.modal', function(){
//    	location.reload();
//    });
    
    delete_user_modal.on('show.bs.modal', function(event){
        var btn = $(event.relatedTarget);
        var user_name = btn.data('user_name');
        var message = $(this).find(".ajax_message");
        
        message.bind('click', function(){
            $(this).collapse('hide'); 
        });
        
        $("#user_name_to_delete").text(user_name);
        
        $(this).find("#delete_user_confirm_btn").bind('click', function(){
           $.ajax({
           	type:"post",
           	url:base_url + "index.php/admin/user_manage/delete_user",
           	dataType:'json',
           	data:{
           	    "user_name":user_name,
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
    
    //修改用户密码
    var modify_password = $("#modify_password");
    modify_password.on('show.bs.modal', function(event){
        var btn = $(event.relatedTarget);
        var user_name = btn.data('user_name');
        var message = $(this).find(".ajax_message");
        
        message.bind('click', function(){
           $(this).collapse('hide'); 
        });
        
        $(this).find("#user_name").val(user_name).attr('readonly', 'readonly');
        var password = $(this).find("#password");
        
        $(this).find("#password_confirm_btn").bind('click', function(){
            if('' == password.val()){
            	message.collapse('show').text('密码不能为空');
            	return;
            }
        	
            $.ajax({
               type:"post",
               url:base_url + 'index.php/admin/user_manage/edit_password',
               dataType:"json",
               data:{
                   "user_name":user_name,
                   "password":$.md5(password.val()),
               },
               success:function(data){
                   message.text(data).collapse('show');
               },
               error:function(XMLHttpRequest){
                    message.text(XMLHttpRequest.statusText).removeClass('bg-info').addClass('bg-danger').collapse('show');
                }
            });
        });
        
        $(this).find("#use_default_password").bind('click', function(){
            if($(this).is(':checked')){
                password.val('888888').attr('readonly', 'readonly');
            }else{
                password.val('').removeAttr('readonly');
            }
        });
    })
    
    //搜索
    var search_user_name = $("#search_user_name");
    var search_user_name_button = $("#search_user_name_button");
    
    search_user_name.keydown(function(event){
        if(event.which == '13'){
            search_user_name_button.trigger('click');
        }
     });
    
    search_user_name_button.click(function(){
       if('' == search_user_name.val()){
           return;
       }
       
       location.href = base_url + 'index.php/admin/user_manage/search/' + search_user_name.val();
    });
    
    //观看记录
    $("#user_records").on('show.bs.modal', function(event){
        var modal = $(this);
        var btn = $(event.relatedTarget);
        var user_name = btn.data('user_name');
        var download_progress = modal.find('#download_progress');
        var download_progress_bar = download_progress.find(".progress-bar");
        var download_progress_data = download_progress.find('#progress_data');
        var message = modal.find('#response');
        var content = modal.find("#content");
        
        download_progress.click(function(){
           $(this).collapse('hide');
           download_progress_bar.width('0%');
           download_progress_data.text('0%');
        });
        
        message.bind('click', function(){
            $(this).collapse('hide').text('');
        })
        
        download_progress.collapse('show');
        var xhr = new XMLHttpRequest();
        var form_data = new FormData();
        form_data.append('user_name', user_name);
           
        xhr.addEventListener('progress', download, false);    
        xhr.responseType = 'json';
        xhr.open("POST", base_url + 'index.php/admin/user_manage/show_records');
        xhr.onload = function(){
            if(xhr.status == 200){
                content.replaceWith(xhr.response);
                download_progress_bar.removeClass('active');
            }else{
                info('error');
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
        
        function info(text){
            message.text(text).collapse('show');
        }
    });
});
