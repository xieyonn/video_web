<?php $this->load->view('admin/head');?>
<?php $this->load->view('admin/top');?> 
<script src="<?php echo base_url('js/admin/articles.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/admin/left_menu.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('lib/KindEditor/kindeditor-all-min.js')?>"></script>
<script src="<?php echo base_url('lib/KindEditor/lang/zh-CN.js')?>"></script>

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
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/user_manage')?>">普通用户管理</a></li>
                                <li role="presentation"><a href="<?php echo base_url('index.php/admin/video_manage')?>">视频管理</a></li>
                                <li role="presentation" class="active"><a href="<?php echo base_url('index.php/admin/article_manage')?>">文章管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="data_page" class="col-lg-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">标题</div>
                        <div class="panel-body">
                            <nav class="nav navbar-default">
                                <div class="container-fluid">
                                    <ul class="nav navbar-nav">
                                        <li><button type="button" class="btn btn-primary btn-sm navbar-btn" data-toggle="modal" data-target="#add_article_modal">添加文章</button></li> 
                                        <li>
                                            <form class="navbar-form">
                                                <div class="form-group">
                                                    <label for="search"></label>
                                                    <input id="search" type="text" class="form-control" placeholder="文章标题"/>
                                                </div>
                                                <button id="search_btn" class="form-control btn btn-default" type="button">搜索</button>
                                            </form>
                                        </li>
                                    </ul>
                                    <ul class="nav navbar-nav navbar-right">
                                        <li><a href=""><span class="label label-info">文章总数<span class="badge"><?php echo $articles_count?></span></span></a></li>
                                    </ul>
                                </div>
                            </nav>
                            
                            <div class="table-responsive">
                                <table id="users_table" class="table table-bordered table-hover">  
                                    <tr>
                                        <th>显示顺序</th>
                                        <th>标题</th>
                                        <th>创建时间</th>
                                        <th>更新时间</th>
                                        <th>点击数</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr>
                                    <?php foreach ($articles as $item):?>
                                    <tr>
                                        <td><?php echo $item['indexing']?></td>
                                        <td><?php echo $item['title']?></td>
                                        <td><?php echo $item['create_time']?></td>
                                        <td><?php echo $item['update_time']?></td>
                                        <td><?php echo $item['clicks']?></td>
                                        <td><?php if(0 == $item['status']):?>
                                        	<span class="label label-danger">禁用</span>
                                        	<?php else:?>
                                        	<span class="label label-success">启用</span>
                                        	<?php endif;?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_article_modal" data-id="<?php echo $item['id']?>" data-title="<?php echo $item['title']?>">删除</button>
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modify_article_modal" data-id="<?php echo $item['id']?>">修改</button>
                                        </td>   
                                    </tr>
                                    <?php endforeach;?>
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
                                    <a href="<?php echo base_url('index.php/admin/article_manage/'.$option.'/'.$search.$paging_param['pre'])?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for($i = $paging_param['min']; $i <= $paging_param['max']; $i++):?>
                                <li <?php if($i == $page_index) echo 'class="active"';?>><a href="<?php echo base_url('index.php/admin/article_manage/'.$option.'/'.$search.$i)?>"><?php echo $i;?></a></li>
                                <?php endfor;?>
                                <li>
      								<a href="<?php echo base_url('index.php/admin/article_manage/'.$option.'/'.$search.$paging_param['next'])?>" aria-label="Next">
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
        
	<!--添加文章模态框-->
    <div class="modal fade" role="dialog" id="add_article_modal" aria-labelledby="myModalLabel_add_article">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_add_article">添加文章</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="add_article_form">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-9">
                                <input id="title" type="text" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="indexing" class="col-sm-2 control-label" >显示顺序</label>
                            <div class="col-sm-9">
                                <input id="indexing" type="text" class="form-control" placeholder="数字越大越靠前"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-sm-2 control-label">内容</label>
                            <div class="col-sm-9">
                                <textarea id="content" name="content" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_open" class="col-sm-2 control-label">是否启用</label>
                            <div class="col-sm-9">
                                <div class="checkbox">
                                    <label>
                                        <input id="is_open" type="checkbox" value="" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="upload_progress" class="progress collapse">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                <span id="progress_data"></span>
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
    
   	<!--删除文章模态框-->
    <div class="modal fade" id="delete_article_modal" role="dialog" aria-labelledby="myModalLabel_delete_article">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_delete_article">删除文章</h4>
                </div>
                <div class="modal-body">
                    <p class="message bg-danger">删除文章--<span id="article_to_delete"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="confirm_btn">确定</button>
                </div>
                <p class="message bg-info collapse"></p>
            </div>            
        </div>
    </div>
    
    <!--修改文章模态框-->
    <div class="modal fade" role="dialog" id="modify_article_modal" aria-labelledby="myModalLabel_modify_article">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_modify_article">添加文章</h4>
                </div>
                <div class="modal-body">
                	<div id="download_progress" class="progress collapse">
                       <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                            <span id="progress_data"></span>
                       </div>
                    </div>
                    <form class="form-horizontal" id="modify_article_form">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-9">
                                <input id="title" type="text" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="indexing" class="col-sm-2 control-label" >显示顺序</label>
                            <div class="col-sm-9">
                                <input id="indexing" type="text" class="form-control" placeholder="数字越大越靠前"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-sm-2 control-label">内容</label>
                            <div class="col-sm-9">
                                <textarea id="modify_content" name="content" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_open" class="col-sm-2 control-label">是否启用</label>
                            <div class="col-sm-9">
                                <div class="checkbox">
                                    <label>
                                        <input id="is_open" type="checkbox" />
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="upload_progress" class="progress collapse">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                <span id="progress_data"></span>
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
    
        <!--显示文章模态框-->
    <div class="modal fade" role="dialog" id="article_detial_modal" aria-labelledby="myModalLabel_article_detial_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_article_detial_modal">文章内容</h4>
                </div>
                <div class="modal-body">
                    <div id="download_progress" class="progress collapse">
                       <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                            <span id="progress_data"></span>
                       </div>
                    </div>
                    <div id="content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="confirm_btn">确定</button>
                </div>
                <p id="response" class="message bg-info collapse"></p>
            </div>
        </div>
    </div>
    </div>
    </body>
</html>