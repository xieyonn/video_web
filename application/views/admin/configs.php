<?php $this->load->view('admin/head')?>
<?php $this->load->view('admin/top')?>
<script src="<?php echo base_url('js/admin/configs.js')?>"></script>
<div id="wrapper">
	    <div class="sep20"></div>
        <div class="container-fluid">
            <div class="row">
                <div id="left_menu" class="col-lg-2">
                    <div class="panel panel-primary">
                        <div class="panel-heading">菜单</div>
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li role="presentation" class="active"><a href="<?php echo base_url('index.php/admin/configs')?>">系统信息</a></li>
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/admin_manage')?>">管理员用户管理</a></li>
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/user_manage')?>">普通用户管理</a></li>
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/video_manage')?>">视频管理</a></li>
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/article_manage')?>">文章管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="data_page" class="col-lg-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">站点设置</div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="settings_form">
                                <fieldset id="field">
                                    <div class="form-group">
                                        <label for="site_title" class="control-label col-lg-2">首页标题</label>
                                        <div class="col-lg-5">
                                            <input id="site_title" type="text" class="form-control" value="<?php echo $configs['site_title']?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="site_name" class="control-label col-lg-2">站点名称</label>
                                        <div class="col-lg-5">
                                            <input id="site_name" type="text" class="form-control" value="<?php echo $configs['site_name']?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="logo" class="control-label col-lg-2">首页图片</label>
                                        <div class="col-lg-5">
                                            <input id="logo" type="file" class="form-control" name="logo" />
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                            <div class="panel-footer">
                                <button id="modify" type="button" class="btn btn-default btn-sm">修改</button>
                                <button id="submit" type="button" class="btn btn-primary btn-sm">提交更改</button>
                            </div>
                            <p id="response" class="message bg-info collapse"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sep20"></div>
</div>
	</body>
</html>