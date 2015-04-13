<?php

namespace Core\Library;

class String
{

	static function translit($string, $flag = false)
	{
		$replace = [
			"'" => "",
			"`" => "",
			"а" => "a", "А" => "a",
			"б" => "b", "Б" => "b",
			"в" => "v", "В" => "v",
			"г" => "g", "Г" => "g",
			"д" => "d", "Д" => "d",
			"е" => "e", "Е" => "e",
			"ж" => "zh", "Ж" => "zh",
			"з" => "z", "З" => "z",
			"и" => "i", "И" => "i",
			"й" => "y", "Й" => "y",
			"к" => "k", "К" => "k",
			"л" => "l", "Л" => "l",
			"м" => "m", "М" => "m",
			"н" => "n", "Н" => "n",
			"о" => "o", "О" => "o",
			"п" => "p", "П" => "p",
			"р" => "r", "Р" => "r",
			"с" => "s", "С" => "s",
			"т" => "t", "Т" => "t",
			"у" => "u", "У" => "u",
			"ф" => "f", "Ф" => "f",
			"х" => "h", "Х" => "h",
			"ц" => "c", "Ц" => "c",
			"ч" => "ch", "Ч" => "ch",
			"ш" => "sh", "Ш" => "sh",
			"щ" => "sch", "Щ" => "sch",
			"ъ" => "", "Ъ" => "",
			"ы" => "y", "Ы" => "y",
			"ь" => "", "Ь" => "",
			"э" => "e", "Э" => "e",
			"ю" => "yu", "Ю" => "yu",
			"я" => "ya", "Я" => "ya",
			"і" => "i", "І" => "i",
			"ї" => "yi", "Ї" => "yi",
			"є" => "e", "Є" => "e",
			"	" => "-", " " => "-", "„" => "-", "”" => "-"
		];

		$string = iconv("UTF-8", "UTF-8//IGNORE", strtr($string, $replace));

		if (!$flag) {
			$string = preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/", "-", $string);
		} else {
			$string = preg_replace("/[^a-zA-ZА-Яа-я0-9\s\/\:]/", "-", $string);
		}

		return mb_strtolower($string);
	}

	public static function genPassword($size = 6)
	{
		$a = ['e', 'y', 'u', 'i', 'o', 'a'];
		$b = ['q', 'w', 'r', 't', 'p', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'z', 'x', 'c', 'v', 'b', 'n', 'm'];
		$c = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];

		$password = $b[array_rand($b)];

		do {
			$lastChar = $password[strlen($password) - 1];
			@$preLastChar = $password[strlen($password) - 2];
			if (in_array($lastChar, $b)) {
				if (in_array($preLastChar, $a)) {
					$r = rand(0, 2);
					if ($r) $password .= $a[array_rand($a)];
					else $password .= $b[array_rand($b)];
				} else $password .= $a[array_rand($a)];

			} elseif (!in_array($lastChar, $c)) {
				$r = rand(0, 2);
				if ($r == 2) $password .= $b[array_rand($b)];
				else $password .= $c[array_rand($c)];
			} else {
				$password .= $b[array_rand($b)];
			}

		} while (($len = strlen($password)) < $size);

		return $password;
	}
}
