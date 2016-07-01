<?php $this->load->view('admin/head');?>
<?php $this->load->view('admin/top');?>

<script src="<?php echo base_url('js/admin/left_menu.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/admin/series_manage.js')?>" type="text/javascript"></script>
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
                                <li role="presentation" class="active"><a href="<?php echo base_url('index.php/admin/video_manage')?>">视频管理</a></li>
                            	<li role="presentation"><a href="<?php echo base_url('index.php/admin/article_manage')?>">文章管理</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="data_page" class="col-lg-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">视频管理</div>
                        <div class="panel-body">
                            <nav class="nav navbar-default">
                                <div class="container-fluid">
                                    <ul class="nav navbar-nav">
                                        <li><button id="add_user_btn" type="button" class="btn btn-primary btn-sm navbar-btn" data-toggle="modal" data-target="#add_series_modal">添加视频</button></li>
                                        <li>
                                            <form class="navbar-form">
                                                <div class="form-group">
                                                    <label for="search_video_title"></label>
                                                    <input id="search_video_title" class="form-control" type="text" placeholder="视频标题" />
                                                </div>
                                                <button id="search_video_title_button" class="form-control btn btn-default" type="button">搜索</button>
                                            </form>
                                        </li>                                        
                                    </ul>
                                    <ul class="nav navbar-nav navbar-right">
                                        <li><a href=""><span class="label label-info">视频总数<span class="badge"><?php echo $series_count?></span></span></a></li>
                                    </ul>
                                </div>
                            </nav>
                            
                            <?php foreach ($series as $item):?>
                            <div class="sep20"></div>
                            <div class="container-fluid">
                				<div class="row">
                    				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                       					<div class="panel panel-default">
                        					<div class="panel-heading"><?php echo $item['title']?></div>
                            				<div class="panel-body">
                            					<div class="container-fluid">
                                					<div class="row">
                                    					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                        					<img src="<?php echo base_url($this->config->item('video_dir_name').'/'.$item['series_name'].'/'.$item['cover_name']);?>" class="video_cover img-responsive" alt="" />
                                    					</div>
                                    					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                        					<table class="table">
                                        						<tr>
                                        							<td>
                                        								<table class="table table-condensed">
                                        									<tr>
                                        										<td>
                                        										<?php if(0 == $item['status']):?>
                                        										<span class="label label-danger">禁用</span>
                                        										<?php else:?>
                                        										<span class="label label-success">启用</span>
                                        										<?php endif;?>
                                        										</td>
                                        										<td>上传用户 <strong><?php echo $item['admin']?></strong></td>
                                        										<td>分集数 <strong><?php echo $item['amount']?></strong></td>
                                        										<td>发布时间 <strong><?php echo $item['create_time']?></strong></td>
                                        										<td>更新时间 <strong><?php echo $item['update_time']?></strong></td>
                                        									</tr>
                                        								</table>
                                        							</td>
                                        						</tr>
                                            					<tr><td><?php echo $item['brief']?></td></tr>
                                       						</table>
                                    					</div>
                                					</div>
                            					</div>                              
                            				</div>    
                            				<div class="panel-footer">
                                				<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_series_modal" data-id="<?php echo $item['id'];?>" data-title="<?php echo $item['title'];?>">删除</button>
                                           		<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modify_series_modal" data-id="<?php echo $item['id']?>">设置</button>
                                            	<a class="btn btn-primary btn-xs" href="<?php echo base_url('index.php/admin/video_manage/video_list/'.$item['id'])?>">分集列表</a>
                            				</div>
                        				</div>
                    				</div>
                				</div>
            				</div>
            				<?php endforeach;?>
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
                                    <a href="<?php echo base_url('index.php/admin/video_manage/'.$option.'/'.$search.$paging_param['pre'])?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for($i = $paging_param['min']; $i <= $paging_param['max']; $i++):?>
                                <li <?php if($i == $page_index) echo 'class="active"';?>><a href="<?php echo base_url('index.php/admin/video_manage/'.$option.'/'.$search.$i)?>"><?php echo $i;?></a></li>
                                <?php endfor;?>
                                <li>
      								<a href="<?php echo base_url('index.php/admin/video_manage/'.$option.'/'.$search.$paging_param['next'])?>" aria-label="Next">
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
    
    <!--删除视频模态框-->
    <div class="modal fade" id="delete_series_modal" role="dialog" aria-labelledby="myModalLabel_delete_series">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_delete_series">删除该视频</h4>
                </div>
                <div class="modal-body">
                    <p class="message bg-danger">确定删除视频    <span id="series_to_delete"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="delete_series_confirm_btn">确定</button>
                </div>
                <p class="message bg-info collapse"></p>
            </div>            
        </div>
    </div>
    
    <!--添加视频模态框-->
    <div class="modal fade" role="dialog" id="add_series_modal" aria-labelledby="myModalLabel_add_series">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_add_series">添加视频</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="add_series_form" enctype="multipart/form-data" method="post" name="add_series_form">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-9">
                                <input id="title" type="text" class="form-control" name="title" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="brief" class="col-sm-2 control-label">简介</label>
                            <div class="col-sm-9">
                                <textarea id="brief" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cover" class="col-sm-2 control-label">封面图片</label>
                            <div class="col-sm-9">
                                <input id="cover" type="file" class="form-control" name="cover" />
                                <p class="help-block">请选择视频封面图片(png gif jpg bmp jpeg 图片大小200 * 200)</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_open" class="col-sm-2 control-label"></label>
                            <div class="col-sm-9">
                                <div class="checkbox">
                                    <label>
                                        <input id="is_open" type="checkbox" value="" />是否启用
                                    </label>
                                </div>
                            </div>
                        </div>
                        <p id="input_info" class="message bg-info well collapse"></p>
                        <div class="progress collapse">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                <span id="progress_data"></span>
                            </div>
                        </div>        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="add_modal_confirm_btn">确定</button>
                </div>
                <p id="status" class="message bg-info collapse"></p>
            </div>
        </div>
    </div>
    
       <!--修改视频信息模态框-->
    <div class="modal fade" role="dialog" id="modify_series_modal" aria-labelledby="myModalLabel_modify_series">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_modify_series">设置</h4>
                </div>
                <div class="modal-body">
                	<div id="download_progress" class="progress collapse">
                       <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                            <span id="progress_data"></span>
                       </div>
                    </div>
                    <form class="form-horizontal" id="modify_series_form">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-9">
                                <input id="title" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="brief" class="col-sm-2 control-label">简介</label>
                            <div class="col-sm-9">
                                <textarea id="modify_brief" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-sm-2 control-label">分集数</label>
                            <div class="col-sm-9">
                                <input id="amount" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cover" class="col-sm-2 control-label">封面图片</label>
                            <div class="col-sm-9">
                                <input id="cover" type="file" class="form-control" name="cover"/>
                                <p class="help-block">请选择视频封面</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_open" class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input id="is_open" type="checkbox" value="" />是否启用
                                    </label>
                                </div>
                            </div>
                        </div>
                        <p id="input_info" class="message bg-info well collapse"></p>
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
                <p id="status" class="message bg-info collapse"></p>
            </div>
        </div>
    </div>
</body>
</html>