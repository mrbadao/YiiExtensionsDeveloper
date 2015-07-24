<form method="post" enctype="multipart/form-data">
	<input type="file" name="file">
	<input type="text" name="album">
	<input type="submit">
</form>

<?php if($res){?>
<div>
	<img src="<?php echo $res->getLink();?>">
</div>
<?php }?>