<?php
  require_once('test_helper.php');
  require_once('../../core/genealogy.class.php');
  require_once('../../core/date.class.php');
  
  class PersonTest extends TestCase {
    
    function PersonTest( $name = "PersonTest" ) {
  		 $this->TestCase( $name );
  	}
  	
  	function setUp() {
  	  $this->person = new Person('I1900');
  	}
    
    function test_gname() {
      $this->assertEquals($this->person->gname, 'Keith Douglas');
    }
    
    function test_sname() {
      $this->assertEquals($this->person->sname, 'Morrison');
    }
    
    function test_surname() {
      $this->assertEquals($this->person->surname(), 'Morrison');
    }
    
    function test_FirstName() {
      $this->assertEquals($this->person->first_name(), 'Keith');
    }
    
    function test_Fname() {
      $this->assertEquals($this->person->first_name(), 'Keith');
    }
    
    function test_name() {
      $this->assertEquals('Keith Douglas Morrison', $this->person->full_name());
      $this->person->gname = '';
      $this->person->sname = '';
      $this->assertEquals('(--?--)', $this->person->full_name());
    }
    
    function test_Gender() {
      $this->assertEquals('Male', $this->person->gender());
    }
    
    function test_Sex() {
      $this->assertEquals('M', $this->person->sex);
    }
    
    
  }
  
  $suite = new TestSuite( "PersonTest" );
  $testRunner = new TestRunner();
  $testRunner->run($suite);
  
?>