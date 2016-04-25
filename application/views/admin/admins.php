<?php $this->load->view('admin/head');?>
<?php $this->load->view('admin/top')?>
<script src="<?php echo base_url('lib/md5.js')?>"></script>
<script src="<?php echo base_url('js/admin/left_menu.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/admin/admin_manage.js')?>" type="text/javascript"></script>
	<div id="wrapper">
        <div class="sep20"></div>
        <div class="container-fluid">
            <div class="row">
                <div id="left_menu" class="col-lg-2">
                   	<div class="panel panel-primary">
                        <div class="panel-heading">菜单</div>
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/configs')?>">系统信息</a></li>
                                <li role="presentation" class="active"><a href="<?php echo base_url('index.php/admin/admin_manage')?>">管理员用户管理</a></li>
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/user_manage')?>">普通用户管理</a></li>
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/video_manage')?>">视频管理</a></li>
                            	<li role="presentation"><a href="<?php echo base_url('index.php/admin/article_manage')?>">文章管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="data_page" class="col-lg-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">管理员用户管理</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                	<tbody>
                                	<tr>
                                        <th>id</th>
                                        <th>用户名</th>
                                        <th>昵称</th>
                                        <th>用户类型</th>
                                        <th>创建时间</th>
                                        <th>上次登录</th>
                                        <th>操作</th>
                                    </tr>
                                    <?php 
                                    $CI =& get_instance();
                                    $CI->load->model('Admins_model');
                                    $admins = $CI->Admins_model->get_all();
                                    $index = 0;
                                    ?>
                                    <?php foreach ($admins as $admin):?>
                                    <tr>
                                        <td><?php echo ++$index?></td>
                                        <td><?php echo $admin['user_name']?></td>
                                        <td><?php echo $admin['nick_name']?></td>
                                        <td><?php if(0 == $admin['type']) echo '超级管理员'; else echo '普通管理员';?></td>
                                        <td><?php echo $admin['create_time']?></td>
                                        <td><?php echo $admin['last_login_time']?></td>                            
                                        <td>
                                            <?php if(0 != $admin['type'] && ($_SESSION['admin_user_name'] == 'admin')):?>
                                            <button type="button" class="btn btn-danger btn-xs delete_admin" data-toggle="modal" data-target="#delete_admin_modal" data-user_name="<?php echo $admin['user_name']?>">删除</button>
                                            <?php endif;?>
                                        </td>
                                    </tr>
									<?php
									endforeach;
									unset($CI);
									unset($admins);
									?>
									</tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button id="add_admin_btn" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_admin_modal">添加管理员</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sep20"></div>
    </div>
    
    <!--添加管理员模态框-->
    <div class="modal fade" role="dialog" id="add_admin_modal" aria-labelledby="myModalLabel_add_admin">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_add_admin">添加管理员</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                        	<div class="alert-dismissible"></div>
                            <label for="user_name" class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-9">
                                <input id="user_name" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-9">
                                <input id="password" type="text" class="form-control" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="add_admin_confirm_btn">确定</button>
                </div>
                <div class="collapse" id="add_admin_message">
                	<p class="message bg-info"></p>
                </div>
            </div>
        </div>
    </div>
    
    <!--删除管理员模态框-->
    <div class="modal fade" id="delete_admin_modal" role="dialog" aria-labelledby="myModalLabel_delete">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_delete">删除管理员</h4>
                </div>
                <div class="modal-body">
                    <p class="bg-danger message">删除管理员<span id="user_name_to_delete"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="delete_admin_confirm_btn">确定</button>
                </div>
                <div class="collapse" id="delete_admin_message">
                	<p class="message bg-info"></p>
                </div>
            </div>
        </div>
    </div>