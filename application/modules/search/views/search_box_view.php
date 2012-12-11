<div class="forma-pretraga <?php if(isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>">
    <form action="<?php echo base_url(); ?>search/post/" method="post" >
            <input name="keyword" type="text" class="pretraga" value="<?php echo(isset($_POST['keyword'])?$_POST['keyword']:''); ?>" />
             <input name="id" type="hidden" value="<?php echo $module_id; ?>" />
            <input type="submit" class="button" value="">
    </form>
</div>