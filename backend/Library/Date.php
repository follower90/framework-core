<?php

namespace Core\Library;

use Core\Config;

class Date
{
	static function date_view($str, $format = "dd-mm-YY")
	{
		$dd = substr($str, 8, 2);

		$mm = substr($str, 5, 2);
		$MM = Date::getMonth($mm);
		$YY = substr($str, 0, 4);
		$yy = substr($str, 2, 2);
		$hh = substr($str, 11, 2);
		$ii = substr($str, 14, 2);
		$ss = substr($str, 17, 2);
		$DD = Date::getDay(mktime(0, 0, 0, $mm, $dd, $YY));
		$replace = array('YY' => $YY, 'yy' => $yy, 'mm' => $mm, 'dd' => $dd, 'DD' => $DD, 'hh' => $hh, 'ii' => $ii, 'ss' => $ss, 'MM' => $MM);
		$str = strtr($format, $replace);
		return $str;
	}

	public static function getMonth($month)
	{
		$language = Config::get('site.language');

		switch ($month) {
			case "01":
				$month = ($language == 'ru') ? 'Января' : 'January';
				break;
			case "02":
				$month = ($language == 'ru') ? 'Февраля' : 'February';
				break;
			case "03":
				$month = ($language == 'ru') ? 'Марта' : 'March';
				break;
			case "04":
				$month = ($language == 'ru') ? 'Апреля' : 'April';
				break;
			case "05":
				$month = ($language == 'ru') ? 'Мая' : 'May';
				break;
			case "06":
				$month = ($language == 'ru') ? 'Июня' : 'June';
				break;
			case "07":
				$month = ($language == 'ru') ? 'Июля' : 'July';
				break;
			case "08":
				$month = ($language == 'ru') ? 'Августа' : 'August';
				break;
			case "09":
				$month = ($language == 'ru') ? 'Сентября' : 'September';
				break;
			case "10";
				$month = ($language == 'ru') ? 'Октября' : 'October';
				break;
			case "11":
				$month = ($language == 'ru') ? 'Ноября' : 'November';
				break;
			case "12":
				$month = ($language == 'ru') ? 'Декабря' : 'December';
				break;
		}
		return $month;
	}

	public static function getDay($day)
	{
		$language = Config::get('site.language');
		$day = getdate($day);
		switch ($day['wday']) {
			case "1":
				$day = ($language == 'ru') ? 'Понедельник' : 'Monday';
				break;
			case "2":
				$day = ($language == 'ru') ? 'Вторник' : 'Tuesday';
				break;
			case "3":
				$day = ($language == 'ru') ? 'Среда' : 'Wednesday';
				break;
			case "4":
				$day = ($language == 'ru') ? 'Четверг' : 'Thursday';
				break;
			case "5":
				$day = ($language == 'ru') ? 'Пятница' : 'Friday';
				break;
			case "6":
				$day = ($language == 'ru') ? 'Суббота' : 'Saturday';
				break;
			case "0":
				$day = ($language == 'ru') ? 'Воскресенье' : 'Sunday';
				break;
		}
		return $day;
	}
}