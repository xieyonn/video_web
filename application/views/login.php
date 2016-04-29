<?php $this->load->view('head');?>
<body>
<script src="<?php echo base_url('lib/md5.js')?>"></script>
<script src="<?php echo base_url('js/front/login.js')?>" type="text/javascript"></script>
	<div id="base_url" data-base_url=<?php echo base_url();?>></div>
	<div id="top" class="container-fluid">
        <p id="site_title" class="text-center"><?php echo $configs['site_title']?><p>
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
				<div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 col-lg-4 col-lg-offset-4">
				<div class="border_box">
					<form class="form-horizontal">
						<p class="text-center">登录</p>
                        <div class="form-group">
                            <label for="user_name" class="control-label"></label>
                            <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                                <input type="text" id="user_name" class="form-control input-lg" placeholder="账号" />
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
                            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 bg-danger">
                                <span id="show_code" class="text-center" style="font-size: 20px;line-height: 42px;"><?php echo $code?></span>
                            </div>
                        </div>
						<div class="form-group">
							<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                                <button type="button" class="btn btn-primary form-control" id="confirm_btn">确定</button>
							</div>
						</div>
						<p id="response" class="message bg-info collapse"></p>
                    </form>
				</div>
				</div>
			</div>
		</div>
		<div class="sep20"></div>
	</div>
    <?php $this->load->view('footer')?>
</body>
</html>