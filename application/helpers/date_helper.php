<?php

	function dateconvert($gelburayaveritabanindantarihigetir)
	{
		$tarihirakamlaracevir=strtotime($gelburayaveritabanindantarihigetir);
		$rakamlariistedigimtarihecevir=date("Y-n-j-H-i-s",$tarihirakamlaracevir);	
		$mesajtarihi = explode("-",$rakamlariistedigimtarihecevir);
        	$mesajyil = $mesajtarihi[0];
	        $dogumaynumara = $mesajtarihi[1];
        	$mesajgun = $mesajtarihi[2];
		$ayisimleri = array("", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$mesajay = $ayisimleri[floor($dogumaynumara)];
		return "$mesajay $mesajgun, $mesajyil";
	}

	function isDateWeekend($date){
		if ( date("w", $date) ==  0 || date("w", $date) ==  6 )
			return true;

		return false;
	}

	function validateDate($date, $format = 'Y-m-d H:i:s')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

	/**
	 * Creates a \DateTime object from the given date and times
	 *
	 * @param string  $date 	Date in Y-m-d
	 * @param int 	  $hour 	Hour	
	 * @param int 	  $minute 	Minute
	 * @param string  $amPm 	AM/PM
	 *
	 * @return \DateTime
	 */
	function timecard_to_datetime($date, $hour, $minute, $amPm)
	{
		return DateTime::createFromFormat(
			'Y-m-d h:i A',
			$date . ' ' . $hour . ':' . $minute . ' ' . $amPm
		);
	}


/*end of date_helper.php **/

