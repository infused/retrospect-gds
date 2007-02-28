<?php

# Ensure this file is being included by a parent file
defined( '_RGDS_VALID' ) or die( 'Direct access to this file is not allowed.' );

/**
* Require Atree class
*/
require_once(CORE_PATH.'atree.class.php');

class RelCalculator {
	var $_indkey;
	var $_other_indkey;
	var $_indiv;
	var $_max_gens;
	var $_treeIndiv;

	/**
	* RelCalculator constructor
	* @param string $indkey 
	* @param integer $max_gens
	*/
	function RelCalculator($indkey, $max_gens = 250) {
		$this->_indkey = $indkey;
		$this->_max_gens = $max_gens;

		# get first person information
		$this->_indiv = new Person($this->_indkey);

		# instantiate new tree and populate with ancestors
		$this->_treeIndiv = new ATree($this->_indkey);
		$this->_treeIndiv->fill_tree($this->_max_gens);

	}

	function calculate($other_indkey, $common_indiv = false) {
		$treeOtherIndiv = new ATree($other_indkey);
		$treeOtherIndiv->fill_tree($this->_max_gens);

		$skip_i = array();
		$skip_o = array();
		$common_ancestors = array();

    foreach ($this->_treeIndiv->nodes as $i) {
      foreach ($treeOtherIndiv->nodes as $o) {
        if (strcmp($i->data, $o->data) == 0) {
          $branch_found = false;
          foreach ($common_ancestors as $common) {
            $ci = $common['indiv'];
            if (in_array($i->node_index, $skip_i)) {
              if ($i->father_index && !in_array($i->father_index, $skip_i))
                $skip_i[] = $i->father_index;
              if ($i->mother_index && !in_array($i->mother_index, $skip_i))
                $skip_i[] = $i->mother_index;
              $branch_found = true;
            }
            if (in_array($o->node_index, $skip_o)) {
              if ($o->father_index && !in_array($o->father_index, $skip_o))
                $skip_o[] = $o->father_index;
              if ($o->mother_index && !in_array($o->mother_index, $skip_o))
                $skip_o[] = $o->mother_index;
              $branch_found = true;
            }
          }
            if (!$branch_found) {
              $common_ancestor = array();
              $common_ancestor["indiv"] = $i;
              $common_ancestor["other_indiv"] = $o;
              $skip_i[] = $i->node_index;
              if ($i->father_index && !in_array($i->father_index, $skip_i))
                $skip_i[] = $i->father_index;
              if ($i->mother_index && !in_array($i->mother_index, $skip_i))
                $skip_i[] = $i->mother_index;

              $skip_o[] = $o->node_index;
              if ($o->father_index && !in_array($o->father_index, $skip_o))
                $skip_o[] = $o->father_index;
              if ($o->mother_index && !in_array($o->mother_index, $skip_o))
                $skip_o[] = $o->mother_index;
              $common_ancestors[] = $common_ancestor;
            }
          }
        }
		}

		$common_indivs = array();
		foreach ($common_ancestors as $common) {
			$common_indiv = new Person($common['indiv']->data);
			$common_indivs[] = $common_indiv;
		}

		# get other person information
		$other_indiv = new Person($other_indkey);

		$relationship = "";
		$number_suffixes = array( 1 => "st", 2 => "nd", 3 => "rd");
		$removed_names = array(1 => 'once', 2 => 'twice');
		if (count($common_ancestors) < 1) {
			$relationship = "";
		} else {
			$common = $common_ancestors[0];

			$level = min($common['indiv']->generation, $common['other_indiv']->generation);
			$removed = abs($common['indiv']->generation - $common['other_indiv']->generation);

			switch ($level) {
			case 1: 
				if ($level == $common['indiv']->generation) {
					$grand_type = ($other_indiv->sex == 'F') ? 'daughter' : 'son';
				} else {
					$grand_type = ($other_indiv->sex == 'F')  ? 'mother' : 'father';
				}
				switch ($removed) {
					case 0: $relationship = ""; break; // same person
					case 1: $relationship = $grand_type; break;
					case 2: $relationship = "grand" . $grand_type; break;
					case 3: $relationship = "great grand" . $grand_type; break;
					default:
						$great_level = $removed-2;
						$suffix = $number_suffixes[$great_level] ? $number_suffixes[$great_level] : "th";
						$relationship = "" . $great_level . $suffix . " great grand" . $grand_type; break;
						break;
				}
				break;
			case 2: 
				if ($level == $common['indiv']->generation) {
					$nephew_type = ($other_indiv->sex == 'F') ? 'niece' : 'nephew';
				} else {
					$nephew_type = ($other_indiv->sex == 'F') ? 'aunt' : 'uncle';
				}
				switch ($removed) {
					case 0: $relationship = $other_indiv->sex == 'F' ? 'sister' : 'brother'; break;
					case 1: $relationship = $nephew_type; break;
					case 2: $relationship = "grand" . $nephew_type; break;
					case 3: $relationship = "great grand" . $nephew_type; break;
					default:
						$great_level = $removed-2;
						$suffix = $number_suffixes[$great_level] ? $number_suffixes[$great_level] : "th";
						$relationship = "" . $great_level . $suffix . " great grand" . $nephew_type; break;
						break;
				}
				break;
			default:
				$cousin_type = $level - 2;
				$suffix = $number_suffixes[$cousin_type] ? $number_suffixes[$cousin_type] : "th";
				$relationship = "" . $cousin_type . $suffix . " cousin";
				if ($removed > 0) {
					$removed_name = $removed_names[$removed] ? $removed_names[$removed] : "" . $removed . " times";
					$relationship .= " " . $removed_name . " removed";
				}
				break;
			}
		}

		$results = array();
		$results['relationship'] = $relationship;
		$results['common_ancestors'] = $common_indivs;

		return $results;
	}
}
?>