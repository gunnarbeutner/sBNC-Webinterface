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
			} else {
				$this->write("RPC_IFACE");
				
				$line = $this->read();
				
				if (strstr($line, "[RPC_BLOCK]") !== FALSE) {
					Error::failure('IP blocked', array('This IP ('.$_SERVER['SERVER_ADDR'].') is blocked.'));
				}
				
				if (strpos($line, "RPC_IFACE_OK") !== FALSE) {
					return true;
				}
			}
		}
		
		public function __destruct() {
			socket_write($this->connection, 'QUIT'."\n");
			
			usleep(500);
			
			socket_close($this->connection);
		}
		
		private function read() {
			$line = socket_read($this->connection, 128000, PHP_NORMAL_READ);
			
			$line = trim($line);
			
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
			}
			
			$parsedResponse = $this->itype->parse($response);
	
			if ($parsedResponse[0] == 'empty') {
				Error::warn('Connection failure', array('Could not parse data delivered by server', $line));
			}
	
			$response = itype_flat($parsedResponse);
	
			if (is_a($response, 'itype_exception')) {
				$code = $response->getCode();
	
				if ($code != 'RPC_ERROR') {
					Error::warn('Connection failure', array('Could not parse data delivered by server', '[' . $code . '] ' . $response->getMessage()));
				}
			}
	
			return $response;
		}
		
		function login($user, $pass) {
			$this->user = $user;
			$this->pass = $pass;
			
			if ($this->call('commands') != 'RPC_INVALIDUSERPASS') {
				return true;
			} else {
				$this->user = '';
				$this->pass = '';
				
				return false;
			}
		}
	}
?>