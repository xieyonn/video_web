<?php $this->load->view('head')?>
<?php $this->load->view('top')?>
        <div class="sep20"></div>
        <div class="container-fluid">
        	<div class="row">
                <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url()?>">主页</a></li>
                        <li><a href="<?php echo base_url('index.php/articles')?>">新闻</a></li>
                        <li><a href="<?php echo base_url('index.php/articles/detail/'.$article['id'])?>"><?php echo $article['title']?></a></li>
                    </ol>
                </div>
            </div>
            <div class="row">          
                <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                    <div class="border_box">
                        <h2 class="text-center"><?php echo $article['title']?></h2>
                        <p class="text-center">发布时间<?php echo $article['update_time']?>
                        	<span>点击数<?php echo $article['clicks']?></span>
                        </p>
                        <div>
                        	<?php echo $article['content']?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sep20"></div>
	<?php $this->load->view('footer')?>
	</body>
</html>