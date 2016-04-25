<?php $this->load->view('head');?>
<?php $this->load->view('top');?>
<script src="<?php echo base_url('lib/md5.js')?>"></script>
<script src="<?php echo base_url('js/front/password.js')?>"></script>

    <div id="base_url" data-base_url="<?php echo base_url();?>"></div>
    <div id="wrapper">
        <div class="sep20"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="box col-lg-6 col-lg-offset-3">
                    <div id="password_form">
                        <p class="text-center">修改密码</p>
                        <form>
                            <div class="form-group">
                                <label for="old_password"></label>
                                <input id="old_password" class="form-control" type="password" placeholder="原密码"  />
                            </div>
                            <div class="form-group">
                                <label for="new_password"></label>
                                <input id="new_password" class="form-control" type="password" placeholder="新密码" />
                            </div>
                            <div class="form-group">
                                <label for="new_password_2"></label>
                                <input id="new_password_2" class="form-control" type="password" placeholder="再次输入新密码" />
                            </div>
                            <button id="confirm_btn" class="btn btn-primary btn-block" type="button">确定</button>
                            <div id="password_message" class="collapse">
                                <p class="message"></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="sep20"></div>
    </div>