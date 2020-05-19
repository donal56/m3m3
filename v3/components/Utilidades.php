<?php 
namespace app\components;

class Utilidades
{
	public static function getDate($format = "Y-m-d")
	{
		$date = new \DateTime('NOW', new \DateTimeZone('America/Mexico_City'));
		return $date->format($format);
	}

}
?>