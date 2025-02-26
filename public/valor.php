<?php




if (class_exists('OssnUser')) {
	$obj = new OssnUser;

	$objeto2 = new stdClass();



}
else
{

	class OssnUser
	{
	  public function __set($name, $value) {
	    $this->{$name} = $value;
	  }
	}

	$obj = new OssnUser;

	$objeto2 = new stdClass();

}



?>