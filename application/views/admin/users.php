<?php $this->load->view('admin/head');?>
<?php $this->load->view('admin/top')?>

<script src="<?php echo base_url('lib/md5.js')?>"></script>
<script src="<?php echo base_url('js/admin/left_menu.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/admin/user_manage.js')?>"></script>
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
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/admin_manage')?>">管理员用户管理</a></li>
                                <li role="presentation" class="active"><a href="<?php echo base_url('index.php/admin/user_manage')?>">普通用户管理</a></li>
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/video_manage')?>">视频管理</a></li>
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/article_manage')?>">文章管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="data_page" class="col-lg-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">普通用户管理</div>
                        <div class="panel-body">
                            <nav class="nav navbar-default">
                                <div class="container-fluid">
                                    <ul class="nav navbar-nav">
                                        <li><button id="add_user_btn" type="button" class="btn btn-primary btn-sm navbar-btn" data-toggle="modal" data-target="#add_user_modal">添加用户</button></li>
                                        <li>
                                            <form class="navbar-form">
                                        		<div class="form-group">
                                            		<label for="search_user_name"></label>
                                            		<input id="search_user_name" class="form-control" type="text" placeholder="用户名" <?php if(isset($search)) echo 'value="'.$search.'"'?> />
                                        		</div>
                                        		<button id="search_user_name_button" class="form-control btn btn-default" type="button">搜索</button>
                                    		</form>
                                        </li>
                                    </ul>
                                    <ul class="nav navbar-nav navbar-right">
                                        <li><a href=""><span class="label label-info">用户总数<span class="badge"><?php echo $user_count?></span></span></a></li>
                                    </ul>                                
                                </div>
                            </nav>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>用户名</th>
                                        <th>创建时间</th>
                                        <th>上次登录</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    $index = 0;
                                   	foreach ($users as $user):
                                    ?>
                                    <tr>
                                        <td><?php echo ++$index?></td>
                                        <td><?php echo $user['user_name']?></td>
                                        <td><?php echo $user['create_time']?></td>
                                        <td><?php echo $user['last_login_time']?></td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_user_modal" data-user_name="<?php echo $user['user_name'];?>">删除</button>
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modify_password" data-user_name="<?php echo $user['user_name'];?>">修改密码</button>
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#user_records" data-user_name="<?php echo $user['user_name'];?>">观看记录</button>
                                        </td>
                                    </tr>
									<?php endforeach;?>
									</tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
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
                                    <a href="<?php echo base_url('index.php/admin/user_manage/'.$option.'/'.$search.$paging_param['pre'])?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for($i = $paging_param['min']; $i <= $paging_param['max']; $i++):?>
                                <li <?php if($i == $page_index) echo 'class="active"';?>><a href="<?php echo base_url('index.php/admin/user_manage/'.$option.'/'.$search.$i)?>"><?php echo $i;?></a></li>
                                <?php endfor;?>
                                <li>
      								<a href="<?php echo base_url('index.php/admin/user_manage/'.$option.'/'.$search.$paging_param['next'])?>" aria-label="Next">
        								<span aria-hidden="true">&raquo;</span>
      								</a>
    							</li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                            	<li><a href=""><span class="label label-info">总页数<span class="badge"><?php echo $page_num;?></span></span></a></li>
                            </ul>
                        </nav>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="sep20"></div>
</div>   
    <!--修改用户密码模态框-->
    <div class="modal fade" role="dialog" id="modify_password" aria-labelledby="myModalLabel_add_user">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_add_user">修改用户密码</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="user_name" class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-9">
                                <input id="user_name" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-5">
                                <input id="password" type="text" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="use_default_password">使用默认密码
                                    </label>
                                </div>
                            </div>
                        </div> 
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="password_confirm_btn">确定</button>
                </div>
                <p class="message ajax_message collapse bg-info"></p>
            </div>
        </div>
    </div>
    
    <!--添加用户模态框-->
    <div class="modal fade" role="dialog" id="add_user_modal" aria-labelledby="myModalLabel_add_user">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_add_user">添加用户</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="user_name" class="col-sm-2 control-label">用户名</label>
                            <div class="col-sm-8">
                                <input id="user_name" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-5">
                                <input id="password" type="text" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="use_default_password">使用默认密码
                                    </label>
                                </div>
                            </div>
                        </div>                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="add_user_confirm_btn">确定</button>
                </div>
                <p class="message bg-info collapse"></p>
            </div>
        </div>
    </div>
    
    <!--删除用户模态框-->
    <div class="modal fade" id="delete_user_modal" role="dialog" aria-labelledby="myModalLabel_delete_user">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_delete_user">删除用户</h4>
                </div>
                <div class="modal-body">
                    <p class="message bg-danger">删除用户: <span id="user_name_to_delete"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="delete_user_confirm_btn">确定</button>
                </div>
                <p class="ajax_message message bg-info collapse"></p>
            </div>            
        </div>
    </div>
    
    <!--查看观看记录模态框-->
    <div class="modal fade  bs-example-modal-lg" id="user_records" role="dialog" aria-labelledby="myModalLabel_user_records">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_user_records">观看记录</h4>
                </div>
                <div class="modal-body">
                    <div id="download_progress" class="progress collapse">
                       <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                            <span id="progress_data"></span>
                       </div>
                    </div>
                    <div id="content"></div>
                </div>
                <p id="response" class="message bg-info collapse"></p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
                </div>
                <p class="ajax_message message bg-info collapse"></p>
            </div>            
        </div>
    </div> 
</body>
</html>