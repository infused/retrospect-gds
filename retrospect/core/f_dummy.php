<?php 
/**
 * Dummy Translation Strings
 *
 * This file contains a list of gettext strings for values that 
 * are passed to gettext via a variable instead of static text.
 * This file is not intended to be used by any script.  It's only 
 * purpose is to be parsed by gettext when building a "po" file
 * for language translations.
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		genealogy
 * @license http://opensource.org/licenses/gpl-license.php
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
	
	/** 
	* Dummy function
	* This function does nothing
	* @access public
	*/
	function dummy() {
		
		# family beginstatus types
		gettext("Marriage");
		gettext("Unknown");
		gettext("Friends");
		gettext("Partners");
		
		# family endstatus types
		gettext("Death of one spouse");
		gettext("Divorced");
		gettext("Annulment");
		
		#family event types
		gettext("Divorce Filed");
		gettext("Engagement");
		gettext("Husband");
		gettext("Marriage Bann");
		gettext("Marriage Contract");
		gettext("Marriage Fact");
		gettext("Marriage License");
		gettext("Marriage Settlement");
		gettext("Wife");
			
		# genders
		gettext("Male");
		gettext("Female");
		gettext("Unknown");

		# individual event types
		gettext("Adoption");
		gettext("Adult Christening");
		gettext("Baptism");
		gettext("BaptismLDS");		
		gettext("Bar Mitzah");
		gettext("Bas Mitzah");
		gettext("Birth");
		gettext("Blessing");
		gettext("Burial");
		gettext("Caste");
		gettext("Census");
		gettext("Christening");
		gettext("Confirmation");
		gettext("Cremation");
		gettext("Death");
		gettext("Degree");
		gettext("Description");
		gettext("Education");
		gettext("Election");
		gettext("Emigration");
		gettext("Event");
		gettext("First Communion");
		gettext("Funeral");
		gettext("Graduation");
		gettext("ID Number");
		gettext("Immigration");
		gettext("Land");
		gettext("Last Known Addr");
		gettext("Marriage");
		gettext("Military");
		gettext("Military Award");
		gettext("Military Discharge");
		gettext("Military Enlist");
		gettext("Military Service");
		gettext("Nationality");
		gettext("Naturalization");
		gettext("Number of Children");
		gettext("Number of Marriages");
		gettext("Occupation");
		gettext("Ordinance");
		gettext("Possessions");
		gettext("Probate");
		gettext("Religion");
		gettext("Researcher");
		gettext("Residence");
		gettext("Retirement");
		gettext("Social Security Number");
		gettext("SSN");
		gettext("Title");
		gettext("Will");
		
		# misc
		gettext("ALL");
		
		# Supported Languages
		gettext("English");
		gettext("Spanish");
		gettext("Dutch");
	}
?>