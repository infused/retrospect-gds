<?php 
/**
 * Language Functions
 * @copyright 	Keith Morrison, Infused Solutions	2001-2004
 * @author			Keith Morrison <keithm@infused-solutions.com>
 * @package 		language
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
	* Gets Birth Sentence
	* 
	* Given a Person object, this function returns a sentence describing the birth of 
	* the individual in the currently selected language.  This function has the capability 
	* to return a different sentence structure based on the individual's gender.
	* @access public
	* @param Person $p_node Individual 
	* @return string
	*/
	function get_birth_sentence($p_node) {
		$s = null;
		# populate keyword array
		keyword_push($p_node->name);
		if (!empty($p_node->birth->place)) { keyword_push($p_node->birth->place); }
		
		# for males
		if ($p_node->sex == 'M') { 
			if ($p_node->birth->date AND $p_node->birth->place) {
				$s = sprintf(gtc("He was born on %s in %s."), lang_translate_date($p_node->birth->date), $p_node->birth->place).' ';		
			}
			elseif ($p_node->birth->date) {
				$s = sprintf(gtc("He was born on %s."), lang_translate_date($p_node->birth->date)).' ';
			}
			elseif ($p_node->birth->place) {
				$s = sprintf(gtc("He was born in %s."), $p_node->birth->place).' ';
			}
		}
		# for females
		if ($p_node->sex == 'F') { 
			if ($p_node->birth->date AND $p_node->birth->place) {
				$s = sprintf(gtc("She was born on %s in %s."), lang_translate_date($p_node->birth->date), $p_node->birth->place).' ';
			}
			elseif ($p_node->birth->date) {
				$s = sprintf(gtc("She was born on %s."), lang_translate_date($p_node->birth->date)).' ';
			}
			elseif ($p_node->birth->place) {
				$s = sprintf(gtc("She was born in %s."), $p_node->birth->place).' ';
			}
		}
		return $s;
	}
	
	/**
	* Gets Death Sentence
	* 
	* Given a Person object, this function returns a sentence describing the death of 
	* the individual in the currently selected language.  This function has the capability 
	* to return a different sentence structure based on the individual's gender.
	* @access public
	* @param Person $p_node Individual
	* @return string
	*/
	function get_death_sentence($p_node) {
		$s = null;
		# populate keyword array
		if (!empty($p_node->death->place)) { keyword_push($p_node->death->place); }
		
		# for males
		if ($p_node->sex == 'M') { 
			if ($p_node->death->date and $p_node->death->place) {
				$s = sprintf(gtc("He died on %s in %s."), lang_translate_date($p_node->death->date), $p_node->death->place).' ';		
			}
			elseif ($p_node->death->date) {
				$s = sprintf(gtc("He died on %s."), lang_translate_date($p_node->death->date)).' ';
			}
			elseif ($p_node->death->place) {
				$s = sprintf(gtc("He died in %s."), $p_node->death->place).' ';
			}
		}
		# for females
		if ($p_node->sex == 'F') { 
			if ($p_node->death->date and $p_node->death->place) {
				$s = sprintf(gtc("She died on %s in %s."), lang_translate_date($p_node->death->date), $p_node->death->place).' ';		
			}
			elseif ($p_node->death->date) {
				$s = sprintf(gtc("She died on %s."), lang_translate_date($p_node->death->date)).' ';
			}
			elseif ($p_node->death->place) {
				$s = sprintf(gtc("She died in %s."), $p_node->death->place).' ';
			}
		}
		return $s;
	}
	
	/**
	* Gets Parent Sentence
	* 
	* Given a Person object, this function returns a sentence describing the parents of 
	* the individual in the currently selected language.  This function has the capability 
	* to return a different sentence structure based on the individual's gender.
	* @access public
	* @param Person $p_node Individual
	* @param Person $p_father Father
	* @param Person $p_mother Mother
	* @return string
	*/
	function get_parents_sentence($p_node, $p_father, $p_mother) {
		# populate keyword array
		keyword_push($p_father->name);
		keyword_push($p_mother->name);
		
		$mother_link = '<a class="secondary" href="'.$_SERVER['PHP_SELF'].'?option=family&amp;id='.$p_mother->indkey.'">'.$p_mother->name.'</a>';
		$father_link = '<a class="secondary" href="'.$_SERVER['PHP_SELF'].'?option=family&amp;id='.$p_father->indkey.'">'.$p_father->name.'</a>';
		if ($p_node->father_indkey || $p_node->mother_indkey) {
			if ($p_node->sex == 'M') { 
				# structure for son of father and mother
				if ($p_node->father_indkey and $p_node->mother_indkey) {
					return sprintf(gtc(", son of %s and %s."), $father_link, $mother_link).' ';
				}
				# structure for son of father
				elseif ($p_node->father_indkey) {
					return sprintf(gtc(", son of %s."), $father_link).' ';
				}
				# structure for son of mother
				elseif ($p_node->mother_indkey) {
					return sprintf(gtc(", son of %s."), $mother_link).' ';
				}
			}
			if ($p_node->sex == 'F') { 
				# structure for daughter of father and mother
				if ($p_node->father_indkey and $p_node->mother_indkey) {
					return sprintf(gtc(", daughter of %s and %s."), $father_link, $mother_link).' ';
				}
				# structure for daugher of father
				elseif ($p_node->father_indkey) {
					return sprintf(gtc(", daughter of %s."), $father_link).' ';
				}
				# structure for daugher of mother
				elseif ($p_node->mother_indkey) {
					return sprintf(gtc(", daughter of %s."), $mother_link).' ';
				}
			}
		}
	}
	
	/**
	* Gets Marriage Sentence
	* @access public
	* @param Person $p_node Individual
	* @return string
	*/
	function get_marriage_sentences($p_node) {
		global $g_family_page;
		$s = ' ';
		for ($i = 0; $i < $p_node->marriage_count; $i++) {
			$marriage =& $p_node->marriages[$i];
			if ($marriage->spouse) {
				$spouse = new Person($marriage->spouse, 3);
				$spouse_link = '<a class="secondary" href="'.$_SERVER['PHP_SELF'].'?option=family&amp;id='.$spouse->indkey.'">'.$spouse->name.'</a>';
				# populate keyword array
				keyword_push($spouse->name);
				
				# fix some problems
				if (!$spouse->name) { $spouse->name =  gtc("Unknown"); }
				if ($spouse->name == 'Unknown Unknown') { $spouse->name = gtc("Unknown"); }
				
				if ($marriage->beginstatus == 'Marriage') {
					if ($p_node->sex == 'M') {
						# structure for male married with date and place
						if ($marriage->date and $marriage->place) {
							$s .= sprintf(gtc("male %s married %s on %s in %s."), $p_node->fname, $spouse_link, lang_translate_date($marriage->date), $marriage->place);
						}
						# structure for male married with date only
						elseif ($marriage->date) {
							$s .= sprintf(gtc("male %s married %s on %s."), $p_node->fname, $spouse_link, lang_translate_date($marriage->date));
						}
						# structure for male married with place only
						elseif ($marriage->place) {
							$s .= sprintf(gtc("male %s married %s in %s."), $p_node->fname, $spouse_link, $marriage->place);
						}
						# structure for male married with no date or place
						else {
							$s .= sprintf(gtc("male %s married %s."), $p_node->fname, $spouse_link);
						}
						if ($marriage->endstatus) { 
							$s .= ' ';
							$s .= sprintf(gtc("This marriage ended in %s."), strtolower(gtc($marriage->endstatus))); 
						}
					}
					elseif ($p_node->sex == 'F') {
						# structure for female married with date and place
						if ($marriage->date and $marriage->place) {
							$s .= sprintf(gtc("female %s married %s on %s in %s."), $p_node->fname, $spouse_link, lang_translate_date($marriage->date), $marriage->place);
						}
						# structure for female married with date only
						elseif ($marriage->date) {
							$s .= sprintf(gtc("female %s married %s on %s."), $p_node->fname, $spouse_link, lang_translate_date($marriage->date));
						}
						# structure for female married with place only
						elseif ($marriage->place) {
							$s .= sprintf(gtc("female %s married %s in %s."), $p_node->fname, $spouse_link, $marriage->place);
						}
						# structure for female married with no date or place
						else {
							$s .= sprintf(gtc("female %s married %s."), $p_node->fname, $spouse_link);
						}
						if ($marriage->endstatus) { 
							$s .= ' ';
							$s .= sprintf(gtc("This marriage ended in %s."), strtolower(gtc($marriage->endstatus))); 
						}
					}
				}
				else {
					if ($p_node->sex == 'M') {
						# structure for male relationship with date and place
						if ($marriage->date and $marriage->place) {
							$s .= sprintf(gtc("male %s had a relationship with %s on %s in %s."), $p_node->fname, $spouse_link, lang_translate_date($marriage->date), $marriage->place);
						}
						# structure for male relationship with date only
						elseif ($marriage->date) {
							$s .= sprintf(gtc("male %s had a relationship with %s on %s."), $p_node->fname, $spouse_link, lang_translate_date($marriage->date));
						}
						# structure for male relationship with place only
						elseif ($marriage->place) {
							$s .= sprintf(gtc("male %s had a relationship with %s in %s."), $p_node->fname, $spouse_link, $marriage->place);
						}
						# structure for male relationship with no date or place
						else {
							$s .= sprintf(gtc("male %s had a relationship with %s."), $p_node->fname, $spouse_link);
						}
						if ($marriage->endstatus) { 
							$s .= ' ';
							$s .= sprintf(gtc("This marriage ended in %s."), gtc($marriage->endstatus)); 
						}
					}
					elseif ($p_node->sex == 'F') {
						# structure for female relationship with date and place
						if ($marriage->date and $marriage->place) {
							$s .= sprintf(gtc("female %s had a relationship with %s on %s in %s."), $p_node->fname, $spouse_link, lang_translate_date($marriage->date), $marriage->place);
						}
						# structure for female relationship with date only
						elseif ($marriage->date) {
							$s .= sprintf(gtc("female %s had a relationship with %s on %s."), $p_node->fname, $spouse_link, lang_translate_date($marriage->date));
						}
						# structure for female relationship with place only
						elseif ($marriage->place) {
							$s .= sprintf(gtc("female %s had a relationship with %s in %s."), $p_node->fname, $spouse_link, $marriage->place);
						}
						# structure for female relationship with no date or place
						else {
							$s .= sprintf(gtc("female %s had a relationship with %s."), $p_node->fname, $spouse_link);
						}
						if ($marriage->endstatus) { 
							$s .= ' ';
							$s .= sprintf(gtc("This relationship ended in %s."), gtc($marriage->endstatus));
						}
					}			
				}
			}
			if ($s) { $s .= ' '; }
		}
		return $s;
	}
	
	/**
	* Gets 'children of' sentence
	* @access public
	* @param Person $p_node Individual
	* @param Person $p_s_node Spouse
	*/
	function get_children_of_sentence($p_node, $p_s_node) {
		$s = '';
		if ($p_node->name and $p_s_node->name) {
			$s .= sprintf(gtc("Children of %s and %s"), $p_node->name, $p_s_node->name);
		}
		else {
			$s .= sprintf(gtc("Children of %s"), $p_node->name);
		}
		return $s;
	}
?>