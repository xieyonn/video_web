$(document).ready(function(){
    var dataset = $("#dataset");
    var base_url = dataset.data('base_url');
    var video_id = dataset.data('video_id');
    var video_length = 0;
    var percent = 0;
    var player;
    
    var video = videojs("playing", {}, function(){
        player = video.player();
        
        player.on('loadedmetadata', function(){
           video_length = player.duration(); 
        });
        
        player.on('ended', function(){
            log_percent(100);
        })
    });
    
    //每10s更新一次当前播放记录
    setInterval(function(){
        if(player.paused()){
            return;
        }
        
        played_length = player.currentTime();
        if(0 == played_length || 0 == video_length){
            return;
        }
        percent = Math.ceil((played_length / video_length) * 100);
        log_percent(percent);
    }, 10000);
    
    function log_percent(data_to_send){
        $.ajax({
            type:"post",
            url: base_url + "index.php/video/log_record",
            data:{
                'video_id':video_id,
                'played_percent': data_to_send,
            }
        });
    }
});
