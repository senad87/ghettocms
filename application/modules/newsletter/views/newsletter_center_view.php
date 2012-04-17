<div class="box-name">Newsletter</div>
<?php if(isset($message)){?>
<div>
<span><?php echo trans($message);?></span> 
<?php }else{ ?>
<?php echo validation_errors(); ?>
<div class="forma-pretraga">
<form action="<?php echo base_url(); ?>newsletter/subscribe/" method="post" >
        <label><?php echo trans('Elektronska pošta'); ?></label>
        <input name="email" type="text" class="pretraga" value="<?php echo(isset($_POST['email'])?$_POST['email']:''); ?>" />
         <input name="id" type="hidden" value="<?php echo $module_id; ?>" />
        <input type="submit" value="<?php echo trans('Prijava'); ?>" class="button" />
</form>  
<?php } ?>   
</div>