<div class="box-name">ПРЕТРАГА САДРЖАЈА</div>
<div class="forma-pretraga">
<form action="<?php echo base_url(); ?>search/post/" method="post" >
        <label>Кључна реч</label>
        <input name="keyword" type="text" class="pretraga" value="<?php echo(isset($_POST['keyword'])?$_POST['keyword']:''); ?>" />
         <input name="id" type="hidden" value="<?php echo $module_id; ?>" />
        <input type="submit" value="Тражи" class="button" />
</form>        
</div>