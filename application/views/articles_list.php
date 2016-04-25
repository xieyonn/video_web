<?php $this->load->view('head')?>
<?php $this->load->view('top')?>   
        <div class="sep20"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>">主页</a></li>
                        <li><a href="<?php echo base_url('index.php/articles')?>">新闻列表</a></li>
                    </ol>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    <div class="border_box">
                    <?php foreach ($articles as $item):?>
                        <div class="news_item">
                        <a href="<?php echo base_url('index.php/articles/detail/'.$item['id'])?>"><span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span><?php echo $item['title']?>
                        <?php echo '('.$item['update_time'].')'?></a>                    	
                    	</div>
                    <?php endforeach;?>  
                    </div>
                </div>
            </div>    
                  
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    <ul class="pagination">
                                    <?php                            	
                            	$paging_param = get_paging_indexs_array($page_index, $page_num);?>
                                <li>
                                    <a href="<?php echo base_url('index.php/articles/'.$option.'/'.$paging_param['pre'])?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for($i = $paging_param['min']; $i <= $paging_param['max']; $i++):?>
                                <li <?php if($i == $page_index) echo 'class="active"';?>><a href="<?php echo base_url('index.php/articles/'.$option.'/'.$i)?>"><?php echo $i;?></a></li>
                                <?php endfor;?>
                                <li>
      								<a href="<?php echo base_url('index.php/articles/'.$option.'/'.$paging_param['next'])?>" aria-label="Next">
        								<span aria-hidden="true">&raquo;</span>
      								</a>
    							</li>
                    </ul>
                </div>
            </div>
        </div>
	</body>
</html>