<?php
namespace Core;

class View {

	public function render($tpl, $vars = [])
	{
		ob_start();
		include $tpl;

		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}
}
