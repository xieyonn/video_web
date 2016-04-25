$(document).ready(function(){
	var base_url = document.getElementById("base_url").dataset.base_url;
	var user_name = $("#user_name");
	var password = $("#password");
	var btn = $("#login_btn");
	var message = $("#login_message");
	
	user_name.keydown(function(event){
        if(event.which == '13'){
            btn.trigger('click');
        }
     });
	
    password.keydown(function(event){
    	if(event.which == '13'){
            btn.trigger('click');
        }
     });
   
	message.bind('click', function(){
		$(this).collapse('hide');
	})
	btn.click(function(){
		$.ajax({
			type:"post",
			url:base_url + 'index.php/admin/login/ajax_login',
			dataType:"json",
			data:{
				"user_name":user_name.val(),
				"password":$.md5(password.val()),
			},
			success:function(data){
				if(true == data){
					location.href = base_url + 'index.php/admin/admin_manage';
				}else{
					message.collapse('show').children('p').addClass("bg-warning").text('用户名或密码错误');
				}
			},
			error:function(XMLHttpRequest){
				message.collapse('show').children('p').addClass("bg-warning").text(XMLHttpRequest.statusText);
			}
		});
	});
});