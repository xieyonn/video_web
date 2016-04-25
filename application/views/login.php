<?php $this->load->view('head');?>
<body>
<script src="<?php echo base_url('lib/md5.js')?>"></script>
<script src="<?php echo base_url('js/front/login.js')?>" type="text/javascript"></script>
	<div id="base_url" data-base_url=<?php echo base_url();?>></div>
	<div id="top" class="container-fluid">
        <p id="site_title" class="text-center"><?php echo $configs['site_title']?><p>
        <a href="" style="float: right; color: white;" data-toggle="modal" data-target="#login_modal">登录</a>
    </div>
        
    <div id="wrapper" class="center-block">
        <div class="sep20"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <img src="<?php echo base_url('images/'.$configs['logo'])?>" class="img-responsive" />
                </div>
            </div>
        </div>
        <div class="sep20"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                    <div class="border_box">
                        <p class="text-center">新闻动态</p>                       
                       	<?php foreach ($articles as $item):?>
                        <div class="news_item">
                            <a href="<?php echo base_url('index.php/articles/'.$item['id'])?>">
                            	<span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span><?php echo $item['title']?>
                            	<span><?php echo '('.$item['update_time'].')'?></span>
                            </a>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>   
    
    <div class="modal fade" role="dialog" id="login_modal" aria-labelledby="myModalLabel_login">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_login"><span class="text-center">登录</span></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="user_name" class="control-label"></label>
                            <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                                <input type="text" id="user_name" class="form-control input-lg" placeholder="学号" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label"></label>
                            <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                                <input type="password" id="password" class="form-control input-lg" placeholder="密码" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="control-label"></label>
                            <div class="col-xs-6 col-xs-offset-1 col-sm-6 col-sm-offset-1 col-md-6 col-md-offset-1 col-lg-6 col-lg-offset-1">
                                <input type="text" id="code" class="form-control input-lg" placeholder="验证码" />
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 bg-danger">
                                <span id="show_code" class="text-left" style="font-size: 20px;line-height: 42px;"><?php echo $code?></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="confirm_btn">确定</button>
                </div>
                <p id="response" class="message bg-info collapse"></p>
            </div>
        </div>
    </div>
   	
   
    <?php $this->load->view('footer')?>
</body>
</html>