<?php
/**
 * @copyright 	Infused Solutions	2001-2003
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		installation
 * @version			1.0
 *
 */  

	$g_root_path = dirname($_SERVER['PATH_TRANSLATED']) . '/..';
	
	/**
	* Require core.php
	* @access public
	*/
	require_once($g_root_path . '/core/core.php');
	
	$sql = @file_get_contents('install.sql');
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>phpGene Pro Installation - Step 3</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../administrator/styles.css" rel="stylesheet" type="text/css" />
</head>
<body> 
<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
  <tr> 
    <td height="50" background="/administrator/images/adminlogo3.gif">&nbsp;</td> 
  </tr> 
  <tr> 
    <td><table width="100%"  border="0" cellspacing="4" cellpadding="0"> 
        <tr> 
          <td class="text">&nbsp;</td> 
        </tr> 
        <tr> 
          <td class="content-subtitle">Installation Step 3 - Create Database Tables </td> 
        </tr> 
        <tr>
          <td class="text">&nbsp;</td>
        </tr>
        <tr>
          <td class="text">&nbsp;</td>
        </tr>
        <tr> 
          <td class="text">
						<table  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="150" class="content-label">Creating Tables...</td>
                <td width="300" class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="text">gms_children</td>
                <td class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="text">gms_citation</td>
                <td class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="text">gms_fact</td>
                <td class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="text">gms_family</td>
                <td class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="text">gms_indiv</td>
                <td class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="text">gms_language</td>
                <td class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="text">gms_note</td>
                <td class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="text">gms_options</td>
                <td class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="text">gms_relation</td>
                <td class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="text">gms_source</td>
                <td class="text">&nbsp;</td>
              </tr>
              <tr>
                <td class="text">gms_user</td>
                <td class="text">&nbsp;</td>
              </tr>
            </table>
					</td> 
        </tr> 
        <tr>
          <td class="text">&nbsp;</td>
        </tr>
        <tr>
          <td class="text">
						<?php if ($fatal_error == false) { ?>
						<form name="install1" id="install1" method="post" action="install3.php">
            	<input name="Next" type="submit" class="text" id="Next" value="Next" />
	          </form>
						<?php } ?>
					</td>
        </tr> 
    </table></td> 
  </tr> 
</table> 
<p class="content-label">&nbsp;</p> 
<p class="content-label">&nbsp;</p> 
<p> </p> 
<table width="100%"  border="0" cellspacing="5" cellpadding="0"> 
  <tr> 
    <td class="text"> </td> 
  </tr> 
</table> 
</body>
</html>
