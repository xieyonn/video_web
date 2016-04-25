<?php $this->load->view('head')?>
<div class="container-fluid">
        <div class="row">
            <img src="<?php echo base_url('images/top_logo.png')?>" class="img-responsive" />
        </div>
    </div>
    <div id="wrapper">
        <div class="sep20"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <div id="logout_message" class="border_box">
                        <p class="bg-success" style="padding: 5px 20px">成功退出</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="sep20"></div>
    </div>
    <?php $this->load->view('footer')?>
    </body>
</html>