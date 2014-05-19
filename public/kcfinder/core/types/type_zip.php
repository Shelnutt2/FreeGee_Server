<?php

/** This file is part of Freegee project
 *
 *      @desc Zip detection class
 *   @package KCFinder
 *   @version 3.10
 *    @author Seth Shelnutt <Shelnutt2@gmail.com>
 * @copyright 2014 
 *   @license http://opensource.org/licenses/GPL-3.0 GPLv3
 *   @license http://opensource.org/licenses/LGPL-3.0 LGPLv3
 */

namespace kcfinder;

class type_zip{

	public function checkFile($zipFile, array $config){
		$extension = file::getExtension($config['filename']);
		$params = $config['params'];
		
/* Saving this for future use if we support multiple upload types
 *  		$extOkay = false;
		foreach ($params as $param){
			if (strtolower($extension) == strtolower($param))
				$extOkay = true;
		}
		if(!$extOkay) */
		if (strtolower($extension) != strtolower($params))
			return "Extension is not for type zip";
		
		$zip = new \ZipArchive();

		// ZipArchive::CHECKCONS will enforce additional consistency checks
		$res = $zip->open($zipFile, \ZipArchive::CHECKCONS);
		switch((int)$res) {
			case \ZipArchive::ER_EXISTS:{
				echo $res .PHP_EOL;
				return 'File already exists';
				break;}
			case \ZipArchive::ER_INVAL:{
				echo $res .PHP_EOL;
				return 'Invalid argument for zip';
				break;
				}
			case \ZipArchive::ER_MEMORY:{
				return 'Malloc failure with zip';
				break;
				}
			case \ZipArchive::ER_NOENT:{
				return 'No such zip file';
				break;
				}
			case \ZipArchive::ER_NOZIP :{
				return 'not a zip archive';
				break;
				}
			case \ZipArchive::ER_OPEN:{
				return "Can't open zip file";
				break;
				}
			case \ZipArchive::ER_READ:{
				return "Read error with zip";
				break;
				}
			case \ZipArchive::ER_SEEK:{
				return 'Seek error with zip';
				break;
				}
			case \ZipArchive::ER_INCONS :{
				return 'consistency check failed';
				break;
				}
			case \ZipArchive::ER_CRC :{
				return 'checksum failed';
				break;
				}
		}
		//Check to make sure the zip is signed correctly
		$keys='/var/www/freegee.codefi.re/htdocs/keys';
		echo $keys.PHP_EOL;
		exec('android_zip_verifier '.$zipFile." ".$keys, $output, $exitCode);
		if($exitCode != 0){
/* 			foreach($output as $line){
				echo $line.PHP_EOL;
			}
			echo $exitCode.PHP_EOL;
 */			return 'Sig check of zip failed';
		}
		else
			return true;
	}
}