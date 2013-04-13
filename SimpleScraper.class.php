<?php
/*
+---------------------------------------------------------------------------+
| SimpleScraper.class.php                                                   |
| Copyright (c) 2013, Ramon Kayo                                            |
+---------------------------------------------------------------------------+
| Author        : Ramon Kayo                                                |
| Email         : ramaismon@gmail.com                                       |
| License       : Distributed under the MIT License                         |
| Full license  : http://www.workster.com.br/simple-scraper                 |
+---------------------------------------------------------------------------+
| "Have the courage to follow your heart and intuition."                    |
+---------------------------------------------------------------------------+
| Last modified : 12/April/2013                                             |
+---------------------------------------------------------------------------+
*/

class SimpleScraper {
	
	private
		$contentType,
		$data,
		$content,
		$HTTPCode,
		$URL;
	
/*===========================================================================*/
// CONSTRUCTOR
/*===========================================================================*/
	/**
	 * 
	 * @param string $URL
	 * @throws Exception
	 */
	public function __construct($URL) {
		$this->data = array(
			'ogp' => array(),
			'twitter' => array(),
			'meta' => array()
		);
		
		$URLPattern = '/\(?\b(?:(http|https|ftp):\/\/)?((?:www.)?[a-zA-Z0-9\-\.]+[\.][a-zA-Z]{2,4}|localhost(?=\/)|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(?::(\d*))?(?=[\s\/,\.\)])([\/]{1}[^\s\?]*[\/]{1})*(?:\/?([^\s\n\?\[\]\{\}\#]*(?:(?=\.)){1}|[^\s\n\?\[\]\{\}\.\#]*)?([\.]{1}[^\s\?\#]*)?)?(?:\?{1}([^\s\n\#\[\]\(\)]*))?([\#][^\s\n]*)?\)?/';
		if (!is_string($URL))
			throw new Exception("Argument 'url' is invalid. Not a string.");
		if (!(preg_match($URLPattern, $URL)))
			throw new Exception("Argument 'url' is invalid. Not a URL.");
		$this->URL = $URL;
		
		$this->fetchResource();
		if ($this->contentType == 'text/html') {
			libxml_use_internal_errors(true);
			$dom = new DOMDocument(null, 'UTF-8');
			$dom->loadHTML($this->content);
			$metaTags = $dom->getElementsByTagName('meta');
	
			for ($i=0; $i<$metaTags->length; $i++) {
				$attributes = $metaTags->item($i)->attributes;
				$attrArray = array();
				foreach ($attributes as $attr) $attrArray[$attr->nodeName] = $attr->nodeValue;
				
				if (
					array_key_exists('property', $attrArray) && 
					preg_match('~og:([a-zA-Z:_]+)~', $attrArray['property'], $matches)
				) {
					$this->data['ogp'][$matches[1]] = $attrArray['content'];
				} else if (
					array_key_exists('name', $attrArray) &&
					preg_match('~twitter:([a-zA-Z:_]+)~', $attrArray['name'], $matches)
				) {
					$this->data['twitter'][$matches[1]] = $attrArray['content'];
				} else if (
					array_key_exists('name', $attrArray) &&
					array_key_exists('content', $attrArray)
				) {
					$this->data['meta'][$attrArray['name']] = $attrArray['content'];
				}
			}
		}
		
	}
	
/*===========================================================================*/
// PUBLIC METHODS
/*===========================================================================*/
	/**
	 * 
	 * @return string
	 */
	public function getContentType() {
		return $this->contentType;
	}
	
	/**
	 * 
	 * @return array
	 */
	public function getAllData() {
		return $this->data;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getHTTPCode() {
		return $this->HTTPCode;
	}
	
	/**
	 *
	 * @return array
	 */
	public function getMeta() {
		return $this->data['meta'];
	}
	
	/**
	 *
	 * @return array
	 */
	public function getOGP() {
		return $this->data['ogp'];
	}
	
	/**
	 *
	 * @return array
	 */
	public function getTwitter() {
		return $this->data['twitter'];
	}
	
/*===========================================================================*/
// PRIVATE METHODS
/*===========================================================================*/
	private function fetchResource() {
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (compatible; SimpleScraper)');
		curl_setopt($ch, CURLOPT_URL, $this->URL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); // times out after 30s
		$this->content = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		
		$this->HTTPCode = $info['http_code'];
		$this->contentType = $info['content_type'];
		
		if (((int) $this->HTTPCode) >= 400) {
			throw new Exception('STATUS CODE: ' . $this->HTTPCode);
		}
	}	
}