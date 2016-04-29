$(document).ready(function(){
    var base_url = $("#base_url").data('base_url');
    var user_name = $("#user_name");
    var password = $("#password");
    var code = $("#code");
    var login_btn = $("#confirm_btn");
    var message = $("#response");
    
    code.keydown(function(event){
        if(event.which == '13'){
            login_btn.trigger('click');
        }
    });
    
    password.keydown(function(event){
        if(event.which == '13'){
            login_btn.trigger('click');
        }
    });
    
    message.click(function(){
        $(this).collapse('hide').text('');
    })
    
    login_btn.click(function(){
    	console.log('a');
        if('' == user_name.val() || '' == password.val())
        {
			clear();
            message.collapse('show').text('用户名或密码不能为空');
            return;
        }
        
        if('' == code.val())
        {
			clear();
            message.collapse('show').text('验证码不能为空');
            return;
        }
        
        $.ajax({
            type:"post",
            url:base_url + "index.php/login/ajax_login",
            dataType: 'json',
            data:{
                "user_name":user_name.val(),
                "password":$.md5(password.val()),
                "code":code.val(),
            },
            success:function(data){
                if('yes' == data){
                    location.href = base_url + 'index.php/home';
                }else{
                    message.collapse('show').text(data);
                    change_code();
					clear();
                }
            },
            error:function(XMLHttpRequest){
                message.collapse('show').text(XMLHttpRequest.statusText).removeClass('bg-info').addClass('bg-danger');
            }
        });
    });
    
    function change_code(){
        $.ajax({
            type:"post",
            url:base_url + "index.php/login/get_code",
            success:function(data){
                //此处传回的字符串多了两个双引号。
                $("#show_code").text(data.substr(1, 4));
            },
            error:function(XMLHttpRequest){
                message.text(XMLHttpRequest.statusText).removeClass('bg-info').addClass('bg-danger').collapse('show');
            }
        });
    }
	
	function clear()
	{
		user_name.val('');
		password.val('');
	}
});
