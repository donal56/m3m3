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

	public static function friendlyDate($date1, $date2 = null, $dateFullFormat = 'Y-m-d', $dateShortFormat = 'M d', $timeFormat = "h:i a")
	{	 
		
		$date_1 = new \DateTime($date1);
		
		if($date2 === null)
		{
			$date_2 = new \DateTime();
		}
		else
		{
			$date_2 = new \DateTime($date2);
		}
		
		$diff = $date_1->diff($date_2);

		if ($diff->days > 365) {
			return $date_1->format($dateFullFormat);
		} elseif ($diff->days >= 14) {
			return "Hace " . intval($diff->days / 7)  ." semanas"; 
		} elseif ($diff->days > 7) {
			return $date_1->format($dateShortFormat);
		} elseif ($diff->days > 2) {
			return $date_1->format('L - ' . $timeFormat);
		} elseif ($diff->days == 2) {
			return "Ayer ". $date_1->format($timeFormat);
		} elseif ($diff->days > 0 OR $diff->h > 1) {
			return $date_1->format($timeFormat);
		} elseif ($diff->i >= 1) {
			return "Hace " . $diff->i ." minutos";
		} else {
			return "Justo ahora";
		}
	}
}
?>