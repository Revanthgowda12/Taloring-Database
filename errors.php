<!-- done -->
<!-- no errors -->
<?php if (count($errors) > 0){  ?>
	<div>
		<?php foreach ($errors as $error){ ?>
			<p style="color:red;"><?php echo $error; ?></p>
        <?php } ?>
	</div>
        <?php } ?>