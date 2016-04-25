<?php if(! empty($records)):?>
<?php 
    $CI =& get_instance();
    $CI->load->model('Series_model');
?>
<?php foreach ($records as $series_id => $videos):?>
<?php $series = $CI->Series_model->get_series_by_id($series_id);?>
<div class="container-fluid">
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><a href="<?php echo base_url('index.php/video/video_list/'.$series_id)?>"><?php echo $series['title']?></a></div>
            <div class="panel-body">
            	<div class="container-fluid">
	           		<?php foreach ($videos as $item):?>
                	<div class="row">
	            		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
	                		<a href="<?php echo base_url('index.php/video/play/'.$item['video_name'])?>">第<?php echo $item['indexing']?>集-<?php echo $item['title']?></a>
	            		</div>
	            		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
	            			<div class="progress">
                    			<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $item['played_percent']?>%">
                       	 		<?php echo $item['played_percent']?>%
                    			</div>
                			</div>
	        			</div>
	   				</div>	 
   					<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?php endforeach;?>
<?php endif;?>