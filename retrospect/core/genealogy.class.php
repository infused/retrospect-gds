<?php
/**
 * Genealogy classes
 *
 * This file contains classes for genealogy objects such as people, 
 * events, and families (marriages).  All of these classes query the 
 * database for information, so a database connection needs to be 
 * established prior to instantiating any of these classes.
 *
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		genealogy
 * @license http://opensource.org/licenses/gpl-license.php
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
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
 * Defines a person.
 * Some of the properties of this class are other class objects.
 * The example below instantiates a new person object populated with 
 * all of the information available.  If $p_vitals_only is set to true, 
 * then the marriages, parents, children, and notes variables will not be populated.
 * Example:
 * <code>
 * $person = new Person('I100')
 * </code>
 * This class requires a valid database connection before instantiating it
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package	genealogy
 */
class Person {

	/**
	* Hold the indkey used to look up the individuals data from the database
	* @var string
	*/
	var $indkey;				
	
	/**
	* Holds all given names.
	* Example: John David
	* @var string
	*/
	var $gname ;
	
	/**
	* Holds the first name.
	* Example: John
	* @var string
	*/
	var $fname;
	
	/**
	* Holds the surname.
	* Example: Smith
	* @var string
	*/
	var $sname;
	
	/**
	* Holds the full name.
	* Example: John David Smith
	* @var string
	*/
	var $name;
	
	/**
	* Hold the aka or nickname.
	* Example: Curly
	* @var string
	*/
	var $aka;

	/**
	* Holds the gender
	* Valid values are:
	* <ul>
	* <li>Male</li>
	* <li>Female</li>
	* <li>Unknown</li>
	* </ul>
	* @var string
	*/
	var $gender;
	
	/**
	* Holds the birth date.
	* The date string is pulled straight from the database and is not parsed in any way
	* @var string
	*/
	var $birth;
		
	/**
	* Holds the death date.
	* The date string is pulled straight from the database and is not parsed in any way
	* @var string
	*/
	var $death;
	
	/**
	* Holds general notes about the individual
	* @var string
	*/	
	var $notes;	
	
	/**
	* An array of Event objects
	* @see Event
	* @var array
	*/
	var $events;
	
	/**
	* Number of events contained in $events
	* @var integer
	*/
	var $event_count;			# count of events
	
	/**
	* An array of Marriage objects
	* @see Marriage
	* @var array
	*/
	var $marriages; 			# array of marriage objects
	
	/**
	* The count of Marriage objects in $marriages
	* @see Marriages
	* @var integer
	*/
	var $marriage_count;

	/**
	* The father's indkey.
	* The indkey can be used to instantiate a new person object.
	* Example:
	* <code>$father = new Person($indiv->father_indkey);</code>
	* @var string
	*/
	var $father_indkey;
	
	/**
	* The mother's indkey.
	* The indkey can be used to instantiate a new person object.
	* Example:
	* <code>$mother = new Person($indiv->mother_indkey);</code>
	* @var string
	*/
	var $mother_indkey;

	/**
	* Numbering System number.
	* This can represent any Numbering System number, such as an Ahnentafel
	* Register, or Henry number
	* @var string
	*/
	var $ns_number;

	# private properties
	
	/**
	*	Notekey.
	* Used internally to lookup notes from the database
	* @var sting
	*/
	var $notekey;
					
	/**
	* Sex.
	* Possible values are M, F, or ?
	* @var string
	*/
	var $sex;
	
	/**
	* Person Constructor
	* 
	* The $p_level parameter specifies that amount of information that is populated.
	* Levels:<br />
	* 0: All data<br />
	* 1: Only vital statistics, parents, and sources<br />
	* 2: Parents only (populates only $father_indkey and $mother_indkey)<br /> 
	* 3: Vitals only - No Parents, No Sources
	* @param string $p_id indkey
	* @param integer $p_level populate all class properties or only vital stats?
	* @param integer $p_ns_number anhnentafel number
	*/
	function Person($p_id, $p_level = 0, $p_ns_number = null) {
		$this->indkey =& $p_id;
		$this->ns_number =& $p_ns_number;
		$this->sources = array();
		
		# 0: All data
		if ($p_level == 0) {
			$this->_get_name();
			$this->_get_events();
			$this->_get_parents();
			$this->marriages = array();
			$this->children = array();
			$this->_get_marriages();
			$this->_get_children();
			$this->_get_notes();
		}
		# 1: Vitals only
		elseif($p_level == 1) {
			$this->_get_name();
			$this->_get_events();
			$this->_get_parents();
		}
		# 2: Parents only
		elseif($p_level == 2) {
			$this->_get_parents();
		}
		# 3: Vitals (No Parents, No Sources)
		elseif($p_level == 3) {
			$this->_get_name();
			$this->_get_events(false);
		}
		# 4: Custom (used for Ahnentafel report)
		elseif($p_level == 4) {
			$this->_get_name();
			$this->_get_events(false);
			$this->_get_parents();
			$this->marriages = array();
			$this->_get_marriages(false);
		}
	}
	
	/**
	* Gets name information from database
	*/
	function _get_name() {
		$sql = 'SELECT * FROM '.TBL_INDIV.' WHERE indkey = "'.$this->indkey.'"';
		$row = $GLOBALS['db']->GetRow($sql);
		$this->gname = htmlentities($row['givenname']);
		$this->sname = htmlentities($row['surname']);
		$this->aka = htmlentities($row['aka']);
		$this->notekey = $row['notekey'];
		# split out the first name
		$fnames = explode(' ', $row['givenname']); 
		$this->fname = $fnames[0];
		$this->name = trim($this->gname.' '.$this->sname);
		$this->sex = $row['sex'];
		# determine correct gender string
		if ($this->sex == 'M') $this->gender = 'Male'; 
		elseif ($this->sex == 'F') $this->gender = 'Female'; 
		else $this->gender = 'Unknown'; 
	}

	/**
	* Gets events from database
	*/
	function _get_events($p_fetch_sources = true) {
		$this->events = array();
		$sql =  'SELECT * FROM '.TBL_FACT." WHERE indfamkey = '{$this->indkey}'";
		$rs = $GLOBALS['db']->Execute($sql);
		while ($row = $rs->FetchRow()) {
			$event = new event($row, $p_fetch_sources);
			if (strtolower($event->type) == 'birth') $this->birth = $event;
			elseif (strtolower($event->type) == 'death') $this->death = $event;
			else array_push($this->events, $event);
		}
		$this->event_count = count($this->events);
	}

	/**
	* Gets parents from database
	*/	
	function _get_parents() {
		$sql  = 'SELECT spouse1, spouse2 FROM '.TBL_FAMILY.' ';
		$sql .= 'INNER JOIN '.TBL_CHILD.' ';
		$sql .= 'ON '.TBL_FAMILY.'.famkey = '.TBL_CHILD.'.famkey ';
		$sql .= 'WHERE '.TBL_CHILD.".indkey = '{$this->indkey}'";
		if ($row = $GLOBALS['db']->GetRow($sql)) {
			$this->father_indkey = $row['spouse1'];
			$this->mother_indkey = $row['spouse2'];
		}
	}

	/**
	* Gets marriages/family units from database
	* @param boolean $fetch_sources
	*/	
	function _get_marriages($fetch_sources = true) {
		if ($this->sex == 'M') { 
			$p_col = 'spouse1'; 
			$s_col = 'spouse2'; 
		}
		else { 
			$p_col = 'spouse2'; 
			$s_col = 'spouse1'; 
		}
		$sql = 'SELECT * FROM '.TBL_FAMILY." WHERE {$p_col}='{$this->indkey}'";
		$rs = $GLOBALS['db']->Execute($sql);
		while ($row = $rs->FetchRow()) {
			$marriage = new marriage($row['famkey'], $row[$s_col], $row['beginstatus'], $row['endstatus'], $row['notekey'], $fetch_sources);
			array_push($this->marriages, $marriage);
		}
		$this->marriage_count = count($this->marriages);
	}

	/**
	* Gets children from database
	*/	
	function _get_children() {
		foreach ($this->marriages as $marriage) {	
			$famkey = $marriage['famkey'];
			$sql = "SELECT indkey FROM ".TBL_CHILD." WHERE famkey='{$famkey}'";
			$children = $GLOBALS['db']->GetCol($sql);
			foreach ($children as $child) {
				$this->children[] = $child;
			}
		}
	}

	/**
	* Gets notes from database
	*/	
	function _get_notes() {
		$query = "SELECT text FROM ".TBL_NOTE." WHERE notekey='{$this->notekey}'";
		$this->notes = htmlentities(nl2br($GLOBALS['db']->GetOne($query)));
	}
}

/**
 * Defines an event
 * @package	genealogy
 */
class Event {
	/**
	* Event Type
	* @var string
	*/
	var $type;

	/**
	*	Event Date
	* @var string
	*/
	var $date;

	/**
	* Event Place
	* @var string	
	*/
	var $place;
	
	/**
	* Event Comment
	* @var string
	*/
	var $comment;
	
	/**
	* Event Factkey
	* @var string
	*/
	var $factkey;

	/**
	* Array of Sources
	* @var array
	*/
	var $sources;

	/**
	* Count of Sources
	* @var integer
	*/
	var $source_count;
	
	/**
	* Event Constructor
	* @param string $p_type The type of event
	* @param string $p_date When the event occured
	* @param string $p_place Where the event occured
	* @param string $p_factkey 
	*/
	function Event($event_data, $p_fetch_sources = true) {
		$this->type = ucwords(strtolower($event_data['type']));
		$this->place = htmlentities($event_data['place']);
		$this->comment = htmlentities($event_data['comment']);
		$this->factkey = $event_data['factkey'];
		
		$this->date = $event_data['date_str'];
		
		if ($p_fetch_sources === true) $this->_get_sources();
	}
	
	/** 
	* Gets sources
	* @access private
	*/
	function _get_sources() {
		$sources = array();
		$sql  = 'SELECT '.TBL_CITATION.'.source, '.TBL_SOURCE.'.text '; 
		$sql .= 'FROM '.TBL_CITATION.' INNER JOIN '.TBL_SOURCE.' ';
		$sql .= 'ON '.TBL_CITATION.'.srckey = '.TBL_SOURCE.'.srckey ';
		$sql .= 'WHERE '.TBL_CITATION.".factkey = '{$this->factkey}'";
		$rs = $GLOBALS['db']->Execute($sql);
		while ($row = $rs->FetchRow()) {
			$srccitation = $row['source'];
			$msrc = htmlentities($row['text']);
			$source = $msrc.'<br />'.$srccitation;
			$sources[] = $source;
		}
		$this->sources = $sources;
		$this->source_count = count($this->sources);
	}
}

/**
 * Defines a marriage or family unit
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package	genealogy
 */
class Marriage {
	
	/**
	* Famkey.
	* This is the key used to look up the family from the database.
	* @var string
	*/
	var $famkey;

	/**
	* Marriage/Union/Family type.
	* Some values are, but are not limited to:
	* "married", "unmarried", "friends", "partners", "single"
	* @var string
	*/
	var $type;
	
	/**
	* Indkey of spouse or partner
	* @var string
	*/
	var $spouse;

	/** 
	* Date of marriage
	* @var string
	*/
	var $date;
	
	/**
	* Place of marriage
	* @var string
	*/
	var $place;
	
	/** 
	* Marriage begin status
	* 
	* ie. married, single, partners, etc....
	* @var string
	*/
	var $beginstatus;
	
	/**
	* Begin status factkey
	* @var string
	*/
	var $beginstatus_factkey;
	
	/**
	* Marriage end status
	* ie. divorced, annulled, etc.
	* @var string
	*/
	var $endstatus;
	
	/**
	* End status factkey
	* @var string
	*/
	var $endstatus_factkey;
	
	/**
	* End date
	* @var string
	*/
	var $enddate;
	
	/**
	* End place
	* @var string
	*/
	var $endplace;
	
	/**
	* Marriage notes
	* @var string
	*/
	var $notes;
	
	/**
	* Array of child indkeys
	* @var array
	*/
	var $children;
	
	/**
	* Number/Count of children
	* @var integer
	*/
	var $child_count;

	/** 
	* Array of begin status sources
	* @var array
	*/
	var $sources;

	/**
	* Number/Count of begin status sources
	* @var integer
	*/
	var $source_count;
	
	/**
	* Array of end status sources
	* @var array
	*/
	var $end_sources;

	/** Number/Count of end status sources
	* @var integer
	*/
	var $end_sources_count;
	
	# private properties
	
	/**
	* @access private
	* @var string
	*/
	var $notekey;
	
	/**
	* Marriage Constructor
	* @param string $p__famkey
	* @param string $p_spouse
	* @param string $p_beginstatus
	* @param string $p_endstatus
	* @param string $p_notekey
	* @param boolean $fetch_sources
	*/
	function Marriage($p_famkey, $p_spouse, $p_beginstatus, $p_endstatus, $p_notekey, $fetch_sources = true) {
		$this->famkey =& $p_famkey;
		$this->spouse =& $p_spouse;
		# work around wording discrepency
		if ($p_beginstatus == 'Married') { $this->beginstatus = 'Marriage'; }
		else { 
			if (!empty($p_beginstatus)) $this->beginstatus = $p_beginstatus; 
			else $this->beginstatus = 'Relationship';
		}
		$this->endstatus =& $p_endstatus;
		$this->notekey =& $p_notekey;
		$this->children = array();
		$this->_get_children();
		$this->_get_notes();
		$this->_get_beginstatus_event();
		$this->_get_endstatus_event();
		if ($this->beginstatus_factkey AND $fetch_sources == true) { 
			$this->sources = $this->_get_sources($this->beginstatus_factkey); 
		}
		$this->source_count = count($this->sources);
		if ($this->endstatus_factkey AND $fetch_sources == true) { 
			$this->end_sources = $this->_get_sources($this->endstatus_factkey); 
		}
		$this->end_source_count = count($this->end_sources);
	}
		
	/**
	* Get Children
	*/	
	function _get_children() {	
		$sql = 'SELECT indkey FROM '.TBL_CHILD.' WHERE famkey = "'.$this->famkey.'"';
		$this->children = $GLOBALS['db']->GetCol($sql);
		$this->child_count = count($this->children);
	}
	
	/**
	* Get Notes
	*/
	function _get_notes() {
		$query = 'SELECT text FROM '.TBL_NOTE.' WHERE notekey="'.$this->notekey.'"';
		$this->notes = htmlentities($GLOBALS['db']->GetOne($query));
	}
	
	/**
	* Get Sources
	*/
	function _get_sources($p_factkey) {
		$sources = array();
		$sql  = 'SELECT '.TBL_CITATION.'.source, '.TBL_SOURCE.'.text ';
		$sql .= 'FROM '.TBL_CITATION.' INNER JOIN '.TBL_SOURCE.' ';
		$sql .= 'ON '.TBL_CITATION.'.srckey = '.TBL_SOURCE.'.srckey ';
		$sql .= 'WHERE '.TBL_CITATION.'.factkey = "'.$p_factkey.'"';
		$rs = $GLOBALS['db']->Execute($sql);
		while ($row = $rs->FetchRow()) {
			$source = $row['text'].'<br />'.$row['source'];
			$sources[] = htmlentities($source);
		}
		return $sources;
	}
	
	/**
	* Get Begin Status Event
	*/
	function _get_beginstatus_event() {
		$query = 'SELECT * FROM '.TBL_FACT.' WHERE (indfamkey="'.$this->famkey.'") AND (type="'.$this->beginstatus.'")';
		if ($row = $GLOBALS['db']->GetRow($query)) {
			$this->beginstatus_factkey = $row['factkey'];
			$this->date = lang_translate_date(ucwords(strtolower($row['date_str'])));
			$this->place = htmlentities($row['place']);
		}
	}
	
	/** 
	* Get End Status Event
	*/
	function _get_endstatus_event() {
		$sql = "SELECT factkey, date_str, place FROM ".TBL_FACT." WHERE (indfamkey='{$this->famkey}') AND (type='{$this->endstatus}') LIMIT 1";
		if ($row = $GLOBALS['db']->GetRow($sql)) {
			$this->endstatus_factkey = $row['factkey'];
			$this->enddate = lang_translate_date(ucwords(strtolower($row['date_str'])));
			$this->endplace = htmlentities($row['place']);	
		}		
	}
}
?>