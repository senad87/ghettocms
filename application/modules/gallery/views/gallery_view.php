<script type="text/javascript" >
Galleria.run('#<?php echo $gallery_id; ?>');

Galleria.configure({
    idleMode: false
});
</script>

<?php //style u narednom duv-u je vrlo bitan, od njega zavisi da li ce galerija da se prikaze ili ne :) ?>
<div id="<?php echo $gallery_id; ?>" style="height: 432px; " >
<?php foreach($images_data as $image_data){ ?>
        <a href="<?php echo base_url().$image_data->path; ?>">
            <img data-title="<?php echo $image_data->lead; ?>" src="<?php echo base_url().$image_data->path; ?>">
        </a>
<?php } ?>    
</div>
