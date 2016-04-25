<div id="base_url" data-base_url=<?php echo base_url();?>></div>
<nav class="nav navbar-default">
    <div class="container-fluid">
        <button id="menu_control_btn" type="button" class="btn btn-default navbar-btn">
            <span class="glyphicon glyphicon-menu-hamburger"  aria-hidden="true"></span>
        </button>
        <a  class="btn btn-default" href="<?php echo base_url('index.php/admin/admin_manage')?>">
        	<span class="glyphicon glyphicon-home"></span>
        	主页
        </a>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                	<span class="glyphicon glyphicon-user"></span>
                    <span id="username_log" data-user_name="<?php echo $_SESSION['admin_user_name']?>">
                    	<?php
                     	if(0 != strlen($_SESSION['admin_nick_name'])){
                     		echo $_SESSION['admin_nick_name'];
                     	}else{
                     		echo $_SESSION['admin_user_name'];
                     	}                     	
                     	?>
                    </span>
                	<span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                	<li><a href="<?php echo base_url('index.php/admin/admin_manage/nickname')?>">修改昵称</a></li>
                    <li><a href="<?php echo base_url('index.php/admin/admin_manage/password')?>">修改密码</a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?php echo base_url('index.php/admin/admin_manage/logout')?>">退出登录</a></li>
                </ul>
            </li>
       </ul>
    </div>
</nav>