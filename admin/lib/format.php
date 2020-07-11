<?php
	date_default_timezone_set("Asia/Bangkok");
	
	function money_idr($input)
	{
		$output="Rp ".number_format( $input, 0 , '' , '.' )."";
		return $output;
	}
	
	function money($input)
	{
		$output=number_format( $input, 0 , '' , ',' );
		return $output;
	}
	

	
			

?>