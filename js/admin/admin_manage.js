$(document).ready(function(){
   var base_url = document.getElementById("base_url").dataset.base_url;
   var delete_admin_model = $("#delete_admin_modal");
   
   $("#delete_admin_message").bind('click', function(){
	  $(this).collapse('hide');
   });
   
   delete_admin_model.on('hidden.bs.modal', function(){
	   location.reload();
   });
   
   //删除管理员用户
   delete_admin_model.on('show.bs.modal', function(event){
       var btn = $(event.relatedTarget);
       var user_name = btn.data('user_name');
       
       $(this).find("#user_name_to_delete").text(user_name);
       
       $(this).find("#delete_admin_confirm_btn").bind('click', function(){
          $.ajax({
        	  type:"post",
        	  url:base_url + 'index.php/admin/admin_manage/delete_admin',
        	  dataType:"json",
        	  data:{
        		  "user_name":user_name,
        	  },
        	  success:function(data){
        		  if(true == data){
        			  delete_admin_model.modal('hide');
        			  btn.parent().parent().remove();
        		  }else if(false == data){
        			  delete_admin_model.find("#delete_admin_message").collapse('show').children("p").text('删除失败').addClass('bg-warning');
        		  }else{
        			  delete_admin_model.find("#delete_admin_message").collapse('show').children("p").text(data).addClass('bg-warning');
        		  }
        	  },
        	  error:function(XMLHttpRequest){
        		  delete_admin_model.find("#delete_admin_message").collapse('show').children("p").text(data).addClass('bg-warning');
        	  }        	  
          });
       });
   });
   
   //添加管理员
   var add_admin_modal = $("#add_admin_modal");
   var add_admin_confirm_btn = $("#add_admin_confirm_btn");
   var add_admin_message = $("#add_admin_message");
   
   add_admin_message.bind('click', function(){
	  $(this).collapse('hide');
   });
   
   add_admin_modal.on('hidden.bs.modal', function(){
	   location.reload();
   });
   
   add_admin_confirm_btn.click(function(){
       var user_name = add_admin_modal.find("#user_name");
       var password = add_admin_modal.find("#password");
       
       if('' == user_name.val() || '' == password.val()){
    	   add_admin_message.collapse('show').children("p").text("用户名和密码不能为空!").addClass("bg-warning");
    	   return false;
       }
       
       $.ajax({
       	type:"post",
       	url:base_url + "index.php/admin/admin_manage/add_admin",
       	dataType: "json",
       	data:{
       	  "user_name":user_name.val(),
       	  "password":($.md5(password.val())),
       	},
       	success:function(data){
       		add_admin_message.collapse('show').children("p").text(data);
       	},
       	error: function(XMLHttpRequest){
       		add_admin_message.collapse('show').children("p").text(XMLHttpRequest.statusText).addClass("bg-danger");
		}
       });
   });
});
