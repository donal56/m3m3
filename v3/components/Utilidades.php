<?php 
namespace app\components;

class Utilidades
{
	public static function getDate(string $format = "Y-m-d")
	{
		$date = new \DateTime('NOW', new \DateTimeZone('America/Mexico_City'));
		return $date->format($format);
	}

	public static function generateRandomString(int $length = 10, bool $letters = true, bool $numbers = true) {
		$characters = '';
		$randomString = '';

		if($letters)
			$characters .= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

		if($numbers)
			$characters .= "0123456789";

		$charactersLength = strlen($characters);

		if($charactersLength > 0) {
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
		}

		return $randomString;
	}
}
?>