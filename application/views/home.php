<?php $this->load->view('head');?>
<?php $this->load->view('top');?>
<body>

		<div id="wrapper">
			<div class="sep20"></div>
			<div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                        <img src="<?php echo base_url('images/home_logo.jpg'); ?>"  class="img-responsive" />
                    </div>
                </div>
            </div>
		
			<?php if(isset($show_news)):?>
            <div class="sep20"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                        <div class="border_box">
                            <p class="text-center">新闻动态</p>  
                            <?php foreach ($articles as $item):?>
                            <div class="news_item">
                                <a href="<?php echo base_url('index.php/articles/detail/'.$item['id'])?>"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span><?php echo $item['title']?>
                                	<span><?php echo '('.$item['update_time'].')'?></span>
                                </a>
                            </div>
                            <?php endforeach;?>
                            <p class="text-right"><a href="<?php echo base_url('index.php/articles')?>">更多</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
            
            <?php foreach ($series as $item):?>
            <?php if($item['status'] == 1):?>
            <div class="sep20"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading"><a href="<?php echo base_url('index.php/video/videos_list/'.$item['id'])?>"><h4><?php echo $item['title']?><h4></a></div>
                            <div class="panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                        <a href="<?php echo base_url('index.php/video/videos_list/'.$item['id'])?>"><img src="<?php echo base_url($this->config->item('video_dir_name').'/'.$item['series_name'].'/'.$item['cover_name'])?>" class="img-responsive" alt="" /></a>
                                    </div>
                                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                        <table class="table">
                                            <tr>
                                                <td>上线时间 :<?php echo $item['update_time']?></td>
                                            </tr>
                                            <tr>
                                                <td>简介: <?php echo $item['brief']?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>                              
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <?php endforeach;?>
            
            <div class="sep20"></div>
        </div>
        <?php $this->load->view('footer')?>
	</body>
</body>