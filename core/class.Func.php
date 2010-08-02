<?php
	class Func{
		public static function duration($secs) {
			if ($secs < 1) {
				return '0s';
			}
			
			$vals = array(
					'w' => (int) ($secs / 86400 / 7),
					'd' => $secs / 86400 % 7,
					'h' => $secs / 3600 % 24,
					'm' => $secs / 60 % 60,
					's' => $secs % 60
				);
			$ret = array();
			foreach ($vals as $k => $v) {
				if ($v > 0) {
					$ret[] = $v.$k;
				}
			}
			
			return join(', ', $ret);
		}
		
		public static function byte_format($byte) {
			if ($bit) $byte /= 8;
			
			/* Define Known Unit Types */
			$units = array(
						"B",
						"KB",
						"MB",
						"GB",
						"TB",
						"PB",
						"EB",
						"ZB",
						"YB"
					);
			
			$i = 0;
			
			while ($byte > 1024) {
				$byte /= 1024;
				$i += 1;
			}
			
			$byte = round($byte, 2);
			
			return $byte . " " . $units[$i];
		}
	}
?>