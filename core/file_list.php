<div class="col-md-12">
	<h1>List of Stored Files</h1>
	<table class="table">
		<thead>
		</thead>
		<tbody>
<?php
	$dir    = "extracted";
	$files1 = scandir($dir);

	for($ii = 2; $ii < count($files1); $ii++){
?>
			<tr>
				<td>
					<a href="extracted/<?php echo $files1[$ii]; ?>"><?php echo $files1[$ii]; ?></a>
				</td>
			</tr>
<?php
	}
?>
		</tbody>
	</table>
</div>