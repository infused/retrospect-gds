<?php
/**
 * Admin - Misc Functions
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		administration
 * @license 		http://opensource.org/licenses/gpl-license.php
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License contained in the file GNU.txt for
 * more details.
 *
 * $Id$
 *
 */  
?>
<?php
	# Additional admin functions
	
	/**
	* Redirect to another page w/delay
	*/
	function redirect_j($p_url, $p_delay) {
		?>
			<script language="javascript">
  		<!--
				setTimeout("this.location = '<?php echo $p_url; ?>' ",'<?php echo ($p_delay*1000); ?>')
			// -->
			</script>
		<?php
	}
	
	/**
	* Print notification message
	*/
	function notify($message) {
		echo '<table cellpadding="10" cellspacing="0"><tr><td class="notification">'.$message.'</td></tr></table>';
	}
	
	
?>