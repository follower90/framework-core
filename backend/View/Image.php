<?php

namespace Core\Traits\View;

trait Image
{
	public function imageResize($filename, $width, $height)
	{
		if (!file_exists($filename) || !is_file($filename)) {
			return null;
		}

		$info = pathinfo($filename);
		$extension = $info['extension'];

		$old_image = $filename;
		$new_image = mb_substr($filename, 0, mb_strrpos($filename, '.', null, 'utf-8'), 'utf-8') . '-' . $width . 'x' . $height . '.' . $extension;

		if (!file_exists($new_image) || (filemtime($old_image) > filemtime($new_image))) {
			$path = '';

			$directories = explode('/', dirname($new_image));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!file_exists($path)) {
					mkdir($path, 0755, true);
				}
			}

			$image = new \Core\Library\Image($old_image);
			$image->resize($width, $height);
			$image->save($new_image);
		}

		return $new_image;
	}
}
