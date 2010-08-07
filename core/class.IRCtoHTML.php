<?php

/*  *****************************************************************************
**
**  IRC to HTML
**
**  Website     : http://marco.zingelmann.name
**  Email       : marco@zingelmann.de
**  Description : Diese Klasse convertiert IRC Farbcodes in HTML-Tags,
**                damit IRC Zitate und/oder Topics auf einer Website
**                angezeigt werden können
**
**  Copyright Notice:
**
**  (C) Copyright 2003 Marco Zingelmann [http://marco.zingelmann.name]
**  All Rights Reserved
**
**  This program is free software; you can redistribute it and/or
**  modify it under the terms of the GNU General Public License
**  as published by the Free Software Foundation; either version 2
**  of the License, or (at your option) any later version.
**
**  This program is distributed in the hope that it will be useful,
**  but WITHOUT ANY WARRANTY; without even the implied warranty of
**  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
**  GNU General Public License for more details.
**
**  The GNU General Public License can be found at
**  http://www.gnu.org/copyleft/gpl.html
**
**  You should have received a copy of the GNU General Public License
**  along with this program; if not, write to the Free Software
**  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
**
**  ****************************************************************************/


class IRCtoHTML {

	var $WorkString;					// IRC-Text zum convertieren
	var $ReturnString;					// HTML Rückgabe-String
	var $Vordergrundfarbe;					// Ist eine V-Farbe gesetzt?
	var $Hintergrundfarbe;					// Ist eine H-Farbe gesetzt?
	var $FettSchrift;					// Ist Fett-Modus gesetzt?
	var $Unterstrichen;					// Ist Unterstreich-Modus gesetzt?
	var $LetzteBFarbe;					// Letzte Hintergrundfarbe
	var $Farbtabelle = array ( 	0  => '#FFFFFF',	// Farbtabelle
					1  => '#000000',
					2  => '#0033CC',
					3  => '#008000',
					4  => '#FF0000',
					5  => '#800000',
					6  => '#800080',
					7  => '#FF9900',
					8  => '#FFFF00',
					9  => '#00FF00',
					10 => '#008080',
					11 => '#00FFFF',
					12 => '#0000FF',
					13 => '#FF00FF',
					14 => '#808080',
					15 => 'lightgrey');


// **************************************************
// Konstruktor
// **************************************************

	function __construct ($IRCString) {
		$this->WorkString	= $IRCString;
		$this->ReturnString	= '';
		$this->Vordergrundfarbe = false;
		$this->Hintergrundfarbe = false;
		$this->FettSchrift      = false;
		$this->Unterstrichen    = false;
		$this->LetzteBFarbe     = '';
	}


	function HTMLFarbTagsSchliessen ($BStatussetzen) {
		if($this->Hintergrundfarbe) { 
			  $this->ReturnString    .= '</span>'; 
			  if($BStatussetzen) $this->Hintergrundfarbe = false; 
		}
		if($this->Vordergrundfarbe) { 
			  $this->ReturnString    .= '</span>'; 
			  $this->Vordergrundfarbe = false; 
		}
	}

	function SetBack($Farbe) {
		$this->ReturnString    .= '<span style=\'background-color: '.$this->Farbtabelle[$Farbe].'\'>';
	}
	

// **************************************************
// Überprüft, welche Farbsettings gemacht wurden
// **************************************************

	function ColorSettings ( $SubString ) {
		
		$ReturnFortschritt = 0;

		if(is_numeric($SubString[0])) {										// Kommt eine Farbnummer?
			$Farbe = $SubString[0];
			$ReturnFortschritt++;
			if(is_numeric($SubString[1])) {									// Ist diese Zweistellig?
				  $Farbe .= $SubString[1];
				  $ReturnFortschritt++;
			}
			$this->HTMLFarbTagsSchliessen(false);
			$this->ReturnString .= '<span style="color:'.$this->Farbtabelle[$Farbe].';">';  // HTML Code erstellen
			$this->Vordergrundfarbe = true;
		} else {
			$this->HTMLFarbTagsSchliessen(true);
		}
				 
		// Kommt noch eine Hintergrundfarbe?		
		if($SubString[$ReturnFortschritt]==',') {										
			$ReturnFortschritt++;
			if(is_numeric($SubString[$ReturnFortschritt])) {		// Kommt wirklich ein Farbcode?
				$Background = $SubString[$ReturnFortschritt];
				$ReturnFortschritt++;
				if(is_numeric($SubString[$ReturnFortschritt])) {	// Ist diese zweistellig?
					$Background .= $SubString[$ReturnFortschritt];
					$ReturnFortschritt++;
				}
				$this->SetBack($Background);
				$this->LetzteBFarbe = $Background;
				$this->Hintergrundfarbe = true;
			}

		} else {
			if($this->Hintergrundfarbe) 
				$this->SetBack($this->LetzteBFarbe);	 
		}
		return $ReturnFortschritt;
	}


	function Fett () {
		if(!$this->FettSchrift) {
			$this->ReturnString .= '<span style="font-weight:bolder;">';
			$this->FettSchrift = true;
		} else {
			$this->ReturnString .= '</span>';
			$this->FettSchrift = false;
		}
	}

	function Unterstrichen () {
		if(!$this->Unterstrichen) {
			$this->ReturnString .= '<span style="font-style:italic;">';
			$this->Unterstrichen = true;
		} else {
			$this->ReturnString .= '</span>';
			$this->Unterstrichen = false;
		}
	}

// **************************************************
// Main Funktion zum generieren des HTML-Strings
// **************************************************

	function GetHTML () {

		// IRC-Text durchlaufen
		for ($i=0; $i<strlen($this->WorkString); $i++) {

			$Zeichen = $this->WorkString[$i];

			switch($Zeichen) {

				case chr(2):				// FETT
					$this->Fett();
					break;

				case chr(3):				// Farbeinstellung 
					$Fortschritt = $this->ColorSettings(substr($this->WorkString, $i+1, 5));
					$i = $i + $Fortschritt; 	
					break;

				case chr(15):				// Zurücksetzen aller Formatierungen
					$this->HTMLFarbTagsSchliessen(true);
					if($this->FettSchrift)   $this->Fett();
					if($this->Unterstrichen) $this->Unterstrichen();
					break;

				case chr(31):				// Unterstrichen
					$this->Unterstrichen();
					break;

				case chr(32):				// Leerzeichen
					$this->ReturnString .= ' ';
					break;

				default:
					$this->ReturnString .= htmlentities($this->WorkString[$i]);
			}
		}

		$this->HTMLFarbTagsSchliessen(true);
		if($this->FettSchrift)   $this->Fett();
		if($this->Unterstrichen) $this->Unterstrichen();
		return $this->ReturnString;
	}
}
?>