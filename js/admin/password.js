$(document).ready(function(){
    var base_url = $("#base_url").data('base_url');
    var user_name = $("#username_log").data('user_name');
    var old_password = $("#old_password");
    var new_password = $("#new_password");
    var new_password_2 = $("#new_password_2");
    var btn = $("#confirm_btn");
    var password_message = $("#password_message");
   
    password_message.bind('click', function(){
          $(this).collapse('hide'); 
    });
   
    btn.click(function(){
    	console.log(user_name);
        if('' == old_password.val() || '' == new_password.val()){
            password_message.collapse('show').children('p').text('用户名密码不能为空').addClass('bg-danger');
        }else if(new_password_2.val() != new_password.val()){
        	password_message.collapse('show').children('p').text('两次输入的密码不一致').addClass('bg-danger');
        }else{
            $.ajax({
                type:"post",
          	    url:base_url + "index.php/admin/admin_manage/ajax_password",
          	    dataType:"json",
          	    data:{
          	        "user_name":user_name,
          	        "old_password":$.md5(old_password.val()),
          	        "new_password":$.md5(new_password.val()),
          	    },
          	    success:function(data){
          	        if(true == data){
          	            password_message.collapse('show').children('p').text('修改成功').addClass('bg-success');
          	        }else{
          	            password_message.collapse('show').children('p').text('密码错误').addClass('bg-warning');
          	        }
          	    },
          	    error:function(XMLHttpRequest){
          	        password_message.collapse('show').children('p').text(XMLHttpRequest.statusText).addClass('bg-warning');
          	    },
            });
        }
    });
});