<?php

//static, semi observer pattern
class Helper
{

	public static function getCommit()
	{
		return exec('git rev-parse --verify HEAD 2> /dev/null');
	}
	
}

/*end lib/helper.php */
