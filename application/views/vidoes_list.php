<?php $this->load->view('head')?>
<?php $this->load->view('top')?>

	    <div class="sep20"></div>
	    <div class="container-fluid">
	        <div class="row">
                <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>">主页</a></li>
                        <li><a href="<?php echo base_url('index.php/video')?>">视频列表</a></li>
                        <li><a href="<?php echo base_url('index.php/video/videos_list/'.$series['id'])?>"><?php echo $series['title']?></a></li>
                    </ol>
                </div>
            </div>
	    </div>
	    <div class="container-fluid">
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php echo $series['title']?></div>
                        <div class="panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                	<?php foreach ($videos as $item):?>
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
    </body>
</html>