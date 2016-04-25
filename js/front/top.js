$(document).ready(function(){
	var base_url = $("#base_url").data('base_url');
    var search_video = $("#search_video");
    var btn = $("#search_btn");
   
    btn.click(function(){
        if('' == search_video.val()){
            return;
        }
        location.href = base_url + 'index.php/home/search/' + search_video.val();
    })
});
