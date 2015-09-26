<?php

namespace Core\Library;

use Core\Config;
use Core\Router;

class Mail
{
	public static function send($name_from, $email_from, $name_to, $email_to, $subject, $body)
	{
		$data_charset = 'utf-8';
		$send_charset = 'windows-1251';

		$email_to = str_replace("&#044;", ",", $email_to);
		$email_cnt = explode(",", $email_to);
		$email_to = "";
		for ($i = 0; $i <= count($email_cnt) - 1; $i++) {
			if ($i != 0) $email_to .= ", ";
			$email_to .= "< {$email_cnt[$i]} >";
		}

		$to = Mail::mime_header_encode($name_to, $data_charset, $send_charset)
			. $email_to;
		$subject = Mail::mime_header_encode($subject, $data_charset, $send_charset);
		$from = Mail::mime_header_encode($name_from, $data_charset, $send_charset) . ' <' . $email_from . '>';

		if ($data_charset != $send_charset) {
			$body = iconv($data_charset, $send_charset, $body);
		}

		$headers = "From: $from \r\n";
		$headers .= "Reply-To: $from \r\n";
		$headers .= "Content-type: text/html; charset=$send_charset \r\n";

		return mail($to, $subject, $body, $headers, "-f info@" . Router::get('host'));
	}

	public static function error($text)
	{
		$contact_mail = Config::get('email_error');
		$url = Router::get('uri');
		$refer = Router::get('referer');
		$ip_user = Router::get('remote_addr');
		$br_user = Router::get('user_agent');

		$header = "From: $contact_mail" . "\r\n" .
			"Reply-To: $contact_mail" . "\r\n" .
			"Return-Path: $contact_mail" . "\r\n" .
			"Content-type: text/plain; charset=UTF-8";

		$subject = 'Error occurred at:' . Router::get('name');
		$body = "SERVER_NAME:" . Router::get('name') . "
				 URL: $url \n
				 REFER page: $refer \n
				 IP: $ip_user \n
				 Browser: $br_user \n
				 -----------------------------------------
				 $text";

		mail($contact_mail, $subject, $body, $header);
	}

	private static function mime_header_encode($str, $data_charset, $send_charset)
	{
		if ($data_charset != $send_charset) {
			$str = iconv($data_charset, $send_charset, $str);
		}

		return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
	}
}
