$(document).ready(function(){
    var base_url = $("#base_url").data('base_url');
    
    var field = $("#field");
    var modify_btn = $("#modify");
    var submit_btn = $("#submit");
    var site_title = $("#site_title");
    var site_name = $("#site_name");
    var message = $("#response");
    
    message.click(function(){
       $(this).collapse('hide').text(''); 
    });
    
    var mutex = true;
    modify_btn.click(function(){
        if(mutex){
            field.removeAttr('disabled');
            submit_btn.removeAttr('disabled');
            mutex = false;
        }else{
            field.attr('disabled', 'disabled');
            submit_btn.attr('disabled', 'disabled');
            mutex = true;
        }
    });
        
    field.attr('disabled', 'disabled');
    submit_btn.attr('disabled', 'disabled');
    
    submit_btn.click(function(){
        var xhr = new XMLHttpRequest();
        var form_data = new FormData(document.getElementById('settings_form'));
        form_data.append('site_title', site_title.val());
        form_data.append('site_name', site_name.val());
          
        xhr.responseType = 'json';
        xhr.open("POST", base_url + 'index.php/admin/configs/update');
        xhr.onload = function(){
            if(xhr.status == 200){
                info(xhr.response);
            }else{
                info('error');
            }
        }
        xhr.send(form_data);
    });
    
    function info(text){
        message.text(text).collapse('show');
    }
});
