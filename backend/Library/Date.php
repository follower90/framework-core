<?php

namespace Core\Library;

class Date
{
	public static function getMonth($num, $lang = 'ru')
	{
		$months = [
			'ru' => [
				'Январь', 'Февраль', 'Март', 'Апрель',
				'Май', 'Июнь', 'Июль', 'Август',
				'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
			]
		];

		return $months[$lang][--$num];
	}

}