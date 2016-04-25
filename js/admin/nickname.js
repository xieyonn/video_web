$(document).ready(function(){
   var base_url = $("#base_url").data('base_url');
   var nick_name = $("#nick_name");
   var confirm_btn = $("#confirm_btn");
   var nick_name_message = $("#nick_name_message");
   
   nick_name_message.bind('click', function(){
       $(this).collapse('hide');
   })
   
   confirm_btn.click(function(){
      if('' == nick_name.val()){
          nick_name_message.collapse('show').children('p').text('不能为空').addClass('bg-warning');
      }else{
          $.ajax({
          	type:"post",
          	url:base_url + "index.php/admin/admin_manage/ajax_nickname",
          	dataType:'json',
          	data:{
          	    "nick_name":nick_name.val(),
          	},
          	success: function(data){
          	    nick_name_message.collapse('show').children('p').text(data).addClass('bg-success');
          	},
          	error:function(XMLHttpRequest){
          	    nick_name_message.collapse('show').children('p').text(XMLHttpRequest.statusText).addClass('bg-danger');
          	}
          });
      }
   });
});
