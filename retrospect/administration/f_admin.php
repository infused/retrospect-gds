<?php
	# Additional admin functions
	
	function redirect_j($p_url, $p_delay) {
		?>
			<script language="javascript">
  		<!--
				setTimeout("this.location = '<?php echo $p_url; ?>' ",'<?php echo ($p_delay*1000); ?>')
			// -->
			</script>
		<?php
	}
?>