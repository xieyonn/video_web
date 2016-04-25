<?php $this->load->view('admin/head');?>
<?php $this->load->view('admin/top');?>

<script src="<?php echo base_url('js/admin/left_menu.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('js/admin/video_list.js')?>" type="text/javascript"></script>

<div id="wrapper">
        <div class="sep20"></div>
        <div class="container-fluid">
            <div class="row">
                <div id="left_menu" class="col-lg-2">
                   	<div class="panel panel-primary">
                        <div class="panel-heading">菜单</div>
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li role="presentation"><a href="">系统信息</a></li>
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
                        <div class="panel-heading"><?php echo $series['title']?></div>
                        <div class="panel-body">
                            <nav class="nav navbar-default">
                                <div class="container-fluid">
                                    <ul class="nav navbar-nav">
                                        <li><button type="button" class="btn btn-primary btn-sm navbar-btn" data-toggle="modal" data-target="#add_video_modal" data-series_title="<?php echo $series['title']?>" data-series_id="<?php echo $series['id']?>">添加</button></li>                                  
                                    </ul>
                                    <ul class="nav navbar-nav navbar-right">
                                        <li><a href=""><span class="label label-info">集数<span class="badge"><?php echo $series['amount']?></span></span></a></li>
                                    </ul>
                                </div>
                            </nav>
                            
                            <?php foreach ($videos as $item):?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                <?php if(1 == $item['has_cover']):?>
                                                <img src="<?php echo base_url($this->config->item('video_dir_name').'/'.$series['series_name'].'/'.$item['cover'])?>" class="img-responsive" />
                                                <?php else:?>
                                                <img src="<?php echo base_url($this->config->item('video_dir_name').'/'.$series['series_name'].'/'.$series['cover_name'])?>" class="img-responsive" />
                                                <?php endif;?>
                                            </div>
                                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <tr>
                                                            <td><?php echo $item['title']?></td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td>第<?php echo $item['indexing']?>集</td>
                                                            <td>上传用户:<?php echo $item['admin']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>创建时间:<?php echo $item['create_time']?></td>
                                                            <td>更新时间:<?php echo $item['update_time']?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                            	<?php if(0 == $item['status']):?>
                                        						<span class="label label-danger">禁用</span>
                                        						<?php else:?>
                                        						<span class="label label-success">启用</span>
                                        						<?php endif;?>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete_video_modal" data-series_id="<?php echo $series['id']?>" data-video_id="<?php echo $item['id']?>" data-index="<?php echo $item['indexing']?>">删除</button>
                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modify_video_modal" data-series_id="<?php echo $series['id']?>" data-video_id="<?php echo $item['id']?>" data-index="<?php echo $item['indexing']?>" data-title="<?php echo $item['title']?>" data-status="<?php echo $item['status']?>">修改</button>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sep20"></div>
    </div>
    
    <!--修改视频模态框-->
    <div class="modal fade" role="dialog" id="modify_video_modal" aria-labelledby="myModalLabel_modify_video">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_modify_video">修改</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="modify_series_form">   
                    	<div class="form-group">
                            <label for="title" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-8">
                                <input id="title" type="text" class="form-control"/>
                            </div>
                        </div>                     
                        <div class="form-group">
                            <label for="index" class="col-sm-2 control-label">集数</label>
                            <div class="col-sm-8">
                                <input id="index" type="text" class="form-control" />
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
                        <div class="form-group">
                            <label for="video_file" class="col-sm-2 control-label">选择视频</label>
                            <div class="col-sm-8">
                                <input id="video_file" type="file" class="form-control" name="video_file"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cover" class="col-sm-2 control-label">选择封面</label>
                            <div class="col-sm-8">
                                <input id="cover" type="file" class="form-control"  name="cover"/>
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
                    <button type="button" class="btn btn-primary" id="confirm_btn">确定</button>
                </div>
                <p id="status" class="message bg-info collapse"></p>
            </div>
        </div>
    </div>
    
    <!--添加视频模态框-->
    <div class="modal fade" role="dialog" id="add_video_modal" aria-labelledby="myModalLabel_add_video">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_add_video">添加视频</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="add_video_form">
                        <div class="form-group">
                            <label for="series" class="col-sm-2 control-label">添加到</label>
                            <div class="col-sm-8">
                                <input id="series" type="text" class="form-control" readonly="readonly"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-8">
                                <input id="title" type="text" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="index" class="col-sm-2 control-label">集数</label>
                            <div class="col-sm-8">
                                <input id="index" type="text" class="form-control"/>
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
                        <div class="form-group">
                            <label for="video_file" class="col-sm-2 control-label">选择视频</label>
                            <div class="col-sm-8">
                                <input id="video_file" type="file" class="form-control"  name="video_file"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cover" class="col-sm-2 control-label">选择封面</label>
                            <div class="col-sm-8">
                                <input id="cover" type="file" class="form-control"  name="cover"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="default_cover" class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <div class="checkbox">
                                    <label>
                                        <input id="default_cover" type="checkbox" value="" />使用默认封面
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
                    <button type="button" class="btn btn-primary" id="confirm_btn">确定</button>
                </div>
                <p id="status" class="message bg-info collapse"></p>
            </div>
        </div>
    </div>
    
        <!--删除视频模态框-->
    <div class="modal fade" id="delete_video_modal" role="dialog" aria-labelledby="myModalLabel_delete_video">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel_delete_video">删除该视频</h4>
                </div>
                <div class="modal-body">
                    <p class="message bg-danger">确定删除第  <span id="index"></span>集</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="confirm_btn">确定</button>
                </div>
                <p class="message bg-info collapse"></p>
            </div>
        </div>
    </div>
</body>
</html>