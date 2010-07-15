<?php
	/**
	 * Error Handler
	 *
	 * I know, that's bad code. Feel free to send me a better version :)
	 */
	
	class Error{
		public static function failure($title, $messages) {
			Error::warn($title, $messages);
			
			exit;
		}
		public static function warn($title, $messages) {
			echo '
<div style="border:1px solid #FF4400; margin:15px 100px; padding:5px; color:#000000;">
	<h1 style="background-color:#800000; color:#FFFFFF; font-size:16px; margin:0px 0px 15px 0px; padding:5px;">'.$title.'</h1>';
			
			foreach ($messages as $msg) {
				echo '
	<p>'.$msg.'</p>';
			}
			
			echo '
</div>';
		}
	}
?>