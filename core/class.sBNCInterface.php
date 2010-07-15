<?php
	class sBNCInterface{
		private $connection = false;
		private $itype = false;
		
		private $config = array();
		
		private $user = '';
		private $pass = '';
		
		public function __construct() {
			$this->config = parse_ini_file('config.ini', true);
			
			$this->itype = new itype;
			
			$this->connection = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			
			if (!socket_connect($this->connection, $this->config['connection']['ip'], $this->config['connection']['port'])) {
				Error::failure('Connection failure', array('Could not connect to server:', socket_strerror(socket_last_error())));
				
				$this->connection = false;
				
				return false;
			} else {
				$this->write("RPC_IFACE");
				
				while($line = $this->read()) {
					if (stripos($line, "rpc_iface_ok") !== FALSE) {
						break;
					}
					
					if (stripos($line, "rpc_block") !== FALSE) {
						Error::failure('IP blocked', array('This IP ('.$_SERVER['SERVER_ADDR'].') is blocked.'));
					}
				}
				
				return true;
			}
		}
		
		public function __destruct() {
			socket_write($this->connection, 'QUIT'."\n");
			
			socket_close($this->connection);
		}
		
		private function read() {
			do {
				$line = socket_read($this->connection, 128000, PHP_NORMAL_READ);
				
				if (strlen($line) == 0) {
					return false;
				}
				
				$line = str_replace(array("\r", "\n"), '', $line);
			} while ($line == '');
			
			return $line;
		}
		
		private function write($text) {
			if (socket_write($this->connection, $text."\r\n") !== false) {
				return true;
			} else {
				return false;
			}
		}
		
		function call($command, $parameters = array(), $user = false) {
			if (empty($this->user) || empty($this->pass)) {
				return false;
			}
			
			if ($user == false) {
				$cmd = array($this->user, $this->pass);
			} else {
				$cmd = array($user, $this->user . ':' . $this->pass);
			}
	
			array_push($cmd, $command);
			array_push($cmd, $parameters);
			
			$this->write($this->itype->fromphp($cmd));
	
			$response = $this->read();
	
			if ($response === false) {
				Error::warn('Connection failure', array('Could not read from server', socket_strerror(socket_last_error())));
				
				return false;
			}
			
			$parsedResponse = $this->itype->parse($response);
	
			if ($parsedResponse[0] == 'empty') {
				Error::warn('Connection failure', array('Could not parse data delivered by server', $line));
				
				return false;
			}
	
			$response = $this->itype->flat($parsedResponse);
	
			if (is_a($response, 'itype_exception')) {
				$response = $response->getCode();
			}
	
			return $response;
		}
		
		function login($user, $pass) {
			$this->user = $user;
			$this->pass = $pass;
			
			$call = $this->call('commands');
			
			if ($call != 'RPC_INVALIDUSERPASS') {
				return true;
			} else {
				$this->user = '';
				$this->pass = '';
				
				return false;
			}
		}
	}
?>