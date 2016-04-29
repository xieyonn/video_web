<div id="base_url" data-base_url=<?php echo base_url();?>></div>
<script src="<?php echo base_url('js/front/top.js')?>" type="text/javascript"></script>
<nav class="nav navbar-default">
    <div class="container-fluid">
    	<div class="navbar-header">
        	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
        	</button>
        	<a  class="btn btn-default navbar-btn btn-sm" href="<?php echo base_url('index.php/home')?>">
        		<span class="glyphicon glyphicon-home"></span>主页
        	</a>
     	</div>
                
     	<div class="collapse navbar-collapse" id="navbar-collapse">
			<form class="navbar-form  navbar-left">
            	<div class="form-group">
                 	<label for="search_video"></label>
                 	<input id="search_video" type="text" class="form-control" placeholder="搜索视频" />
            	</div>
            	<button id="search_btn" type="button" class="btn btn-default">搜索</button>
        	</form>
            
        	<ul class="nav navbar-nav navbar-right">
            	<li class="dropdown">
                 	<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                      	<span class="glyphicon glyphicon-user"></span>
                      	<span id="username_log" data-user_name="<?php echo $_SESSION['user_name']?>"><?php echo $_SESSION['user_name']?></span>
                      	<span class="caret"></span>
                 	</a>
                 	<ul class="dropdown-menu">
                 		<li><a href="<?php echo base_url('index.php/home/my_record')?>">学习记录</a></li>
                 		<li><a href="<?php echo base_url('index.php/login/password')?>">修改密码</a></li>
                 		<li role="separator" class="divider"></li>
                	 	<li><a href="<?php echo base_url('index.php/login/logout')?>">退出登录</a></li>
                 	</ul>
             	</li>
         	</ul>
     	</div>   
  	</div>
</nav>