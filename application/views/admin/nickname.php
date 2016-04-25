<?php $this->load->view('admin/head')?>
<script src="<?php echo base_url('js/admin/nickname.js')?>"></script> 
   <div id="base_url" data-base_url="http://localhost/"></div>
    <div id="wrapper">
        <?php $this->load->view('admin/top')?>
        <div class="sep20"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="box col-lg-6 col-lg-offset-3">
                    <div id="password_form">
                        <p class="text-center">修改昵称</p>
                        <form>
                            <div class="form-group">
                                <label for="nick_name"></label>
                                <input id="nick_name" class="form-control" type="text" placeholder="昵称"/>
                            </div>
                            <button id="confirm_btn" class="btn btn-primary btn-block" type="button">确定</button>
                            <div id="nick_name_message" class="collapse">
                                <p class="message"></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="sep20"></div>
    </div>