<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="<?php echo base_url('images/favicon.ico')?>" rel="shortcut icon" />
        
        <link href="<?php echo base_url('lib/bootstrap.min.css')?>" rel="stylesheet" />
        <link href="<?php echo base_url('css/front.css')?>" rel="stylesheet" />
        <link href="<?php echo base_url('lib/video-js/video-js.css')?>" rel="stylesheet" />
        
        <script src="<?php echo base_url('lib/jquery-2.2.3.min.js')?>" type="text/javascript"></script>
        <script src="<?php echo base_url('lib/bootstrap.min.js')?>" type="text/javascript"></script>
        <script src="<?php echo base_url('lib/video-js/video.min.js')?>" type="text/javascript"></script>
        <script src="<?php echo base_url('js/front/video.js')?>"></script>
        
        <title><?php echo $configs['site_name']?></title>
    </head>
	<?php $this->load->view('top')?>
		
		<div id="dataset" data-base_url=<?php echo base_url()?> data-video_id=<?php echo $video['id']?>></div>
        <div id="wrapper">
       	<div class="sep20"></div>
	    <div class="container-fluid">
	        <div class="row">
                <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>">主页</a></li>
                        <li><a href="<?php echo base_url('index.php/video/videos_list/'.$series['id'])?>"><?php echo $series['title']?></a></li>
                        <li><a href="<?php echo base_url('index.php/video/play/'.$video['file_name'])?>"><?php echo $video['title']?></a></li>
                    </ol>
                </div>
            </div>
	    </div>
            <div class="sep20"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="embed-responsive embed-responsive-16by9">
                                    	<video 
                                            class="video-js vjs-default-skin embed-responsive-item vjs-big-play-centered" 
                                            id="playing"  
                                            controls="controls"    
                                            preload="metadata"
                                            controls preload="auto"   
                                            <?php if(1 == $video['has_cover']):?>
                                            poster="<?php echo base_url($this->config->item('video_dir_name')).'/'.$series['series_name'].'/'.$video['cover']?>" 
                                            <?php else:?>
                                            poster="<?php echo base_url($this->config->item('video_dir_name')).'/'.$series['series_name'].'/'.$series['cover_name']?>"
                                            <?php endif;?>
                                            data-setup='{}'>
                                            <source src="<?php echo base_url($this->config->item('video_dir_name').'/'.$series['series_name'].'/'.$video['file_name'])?>"/>
                                        </video>
                                    </div>
                                </div>
                            </div>                              
                            </div>    
                            <div class="panel-footer">
                            <div class="container-fluid">
                                <div class="row">
                                	<?php foreach ($video['all'] as $item):?>
                                    <?php if(1 == $item['status']):?>
                                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                                        <div class="video_item" style="margin-bottom: 10px;">
                                            <a href="<?php echo base_url('index.php/video/play/'.$item['file_name'])?>">
                                                <?php if($item['has_cover']):?>
                                                <img src="<?php echo base_url($this->config->item('video_dir_name').'/'.$series['series_name'].'/'.$item['cover'])?>"  class="img-responsive"  />
                                                <?php else:?>
                                                <img src="<?php echo base_url($this->config->item('video_dir_name').'/'.$series['series_name'].'/'.$series['cover_name'])?>"  class="img-responsive"  />
                                                <?php endif;?>
                                            </a>
                                            <p class="text-center">第<?php echo $item['indexing']?>集-<?php echo $item['title']?></p>
                                        </div>
                                    </div>
                                    <?php endif;?>
                                    <?php endforeach;?>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sep20"></div>
        </div>
        <?php $this->load->view('footer')?>
    </body>
</html>