<?php

namespace Core\Library;

class Mail
{
	/**
	 * @param $senderName string sender name
	 * @param $senderEmail string sender email
	 * @param $receiverName string receiver name
	 * @param $receiverEmail string receiver email
	 * @param $subject string message subject
	 * @param $body string html message body
	 * @param array $attachments
	 * @return boolean
	 */
	public static function send($senderName, $senderEmail, $receiverName, $receiverEmail, $subject, $body, $attachments = [])
	{
		$mail = new \SimpleMail();
		$mail->setTo($receiverEmail, $receiverName)
			->setSubject($subject)
			->setFrom($senderEmail, $senderName);

		if ($attachments) {
			foreach ($attachments as $path) {
				$mail->addAttachment($path);
			}
		} else {
			$mail
				->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
				->addGenericHeader('Content-Type', 'text/html; charset="utf-8"');
		}

		$mail
			->setMessage($body)
			->setWrap(100);

		return $mail->send();
	}
}
