<?php $this->load->view('admin/head');?>
<body>
<script src="<?php echo base_url('lib/md5.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/admin/login.js');?>" type="text/javascript"></script>

<div id="base_url" data-base_url="<?php echo base_url();?>"></div>
	<div class="container-fluid">
		<div class="row">
	        <div class="col-lg-12">
	            <img src="<?php echo base_url('images/top_logo.png')?>" class="img-responsive" />
	        </div>
	    </div>
	</div>
		<div id="wrapper">
			<div class="container-fluid">
	        <div class="sep20"></div>    
	            <div class="row">
                    <div class="box col-lg-6 col-lg-offset-3">
                        <div id=login_form class="border_box">
                            <form>
                                <p class="text-center">后台登录</p>
                                <div class="form-group">
                                    <label for="user_name"></label>
                                    <input type="text" id="user_name" class="form-control" placeholder="用户名"/>
                                </div>
                                <div class="form-group">
                                    <label for="password"></label>
                                    <input type="password" id="password" class="form-control" placeholder="密码" />
                                </div>
                                <button id="login_btn" type="button" class="btn btn-primary btn-block">登录</button>
                            	<div id="login_message" class="collapse">
                            		<p class="message"></p>
                            	</div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="sep20"></div>    
	        </div>
	    </div>
</body>
</html>