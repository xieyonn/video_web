<?php $this->load->view('head');?>
<?php $this->load->view('top');?>
<body>

		<div id="wrapper">
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
                            <a href="<?php echo base_url('index.php/articles')?>" class="text-right">更多</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif;?>
            
            <?php foreach ($series as $item):?>
            <?php if($item['status'] == 1):?>
            <div class="sep20">></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading"><a href="<?php echo base_url('index.php/video/videos_list/'.$item['id'])?>"><?php echo $item['title']?></a></div>
                            <div class="panel-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                        <a href="<?php echo base_url('index.php/video/videos_list/'.$item['id'])?>"><img src="<?php echo base_url($this->config->item('video_dir_name').'/'.$item['series_name'].'/'.$item['cover_name'])?>" class="img-responsive" alt="" /></a>
                                    </div>
                                    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                        <table class="table">
                                            <tr>
                                                <td>发布时间 :<?php echo $item['update_time']?></td>
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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                        <nav>
  							<ul class="pagination">
                            	<?php                            	
                            	$paging_param = get_paging_indexs_array($page_index, $page_num);
                            	if(! isset($search))
                            	{
                            		$search = '';
                            	}
                            	else 
                            	{
                            		$search .= '/';
                            	}
                            	?>
                                <li>
                                    <a href="<?php echo base_url('index.php/home/'.$option.'/'.$search.$paging_param['pre'])?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for($i = $paging_param['min']; $i <= $paging_param['max']; $i++):?>
                                <li <?php if($i == $page_index) echo 'class="active"';?>><a href="<?php echo base_url('index.php/home/'.$option.'/'.$search.$i)?>"><?php echo $i;?></a></li>
                                <?php endfor;?>
                                <li>
      								<a href="<?php echo base_url('index.php/home/'.$option.'/'.$search.$paging_param['next'])?>" aria-label="Next">
        								<span aria-hidden="true">&raquo;</span>
      								</a>
    							</li>
    						</ul>
						</nav>
                    </div>
                </div>
            </div>
            
            <div class="sep20"></div>
        </div>
        <?php $this->load->view('footer')?>
	</body>
</body>