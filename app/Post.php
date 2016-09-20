<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model{
	function reImg($img, $text){
		$width = $img->width();
		$height = $img->height();
		
		$this->adress = 'dem/'.date('Y').'/'.date('m');
		File::makeDirectory($this->adress, 0755, true, true);
		$this->adress = $this->adress.'/'.$this->id.'_'.str_random(20).'.jpg';
		$img->save($this->adress);
		
		$img->resizeCanvas($width+12, $height+12, 'center', false, '000000');
		$img->resizeCanvas($width+15, $height+15, 'center', false, 'ffffff');
		$img->resizeCanvas($width+70, $height+70, 'center', false, '000000');
		$img->resizeCanvas($width+70, $height+135, 'top', false, '000000');
		
		$chs = floor($width/23);
		//$chs = 5;
		mb_internal_encoding("UTF-8");
		if(mb_strlen($text)<$chs+1){
			$this->putText($img, $width, $height+90, $text);
		}else{
			mb_internal_encoding("UTF-8");
			$tempe = mb_substr($text,0,$chs);
			
			$pos = mb_strripos($tempe, " ", 0, "UTF-8");
			
			if($pos == false){
				mb_internal_encoding("UTF-8");
				$text = mb_substr($text,$chs,strlen($text) - $chs);
			} else {
				mb_internal_encoding("UTF-8");
				$tempe = mb_substr($text,0,$pos);
				mb_internal_encoding("UTF-8");
				$text = mb_substr($text,$pos+1,strlen($text) - $pos - 1);
			}
			
			$this->putText($img, $width, $height+90, $tempe);

			mb_internal_encoding("UTF-8");
			if(mb_strlen($text)<$chs+1){
				$img->resizeCanvas($width+70, $height+200, 'top', false, '000000');
				$this->putText($img, $width, $height+150, $text);
			}else{
				mb_internal_encoding("UTF-8");
				$tempe = mb_substr($text,0,$chs);
					
				$pos = mb_strripos($tempe, " ", 0, "UTF-8");

				if($pos === false){
					mb_internal_encoding("UTF-8");
					$text = mb_substr($text,$chs,strlen($text) - $chs);
				} else {
					mb_internal_encoding("UTF-8");
					$tempe = mb_substr($text,0,$pos);
					mb_internal_encoding("UTF-8");
					$text = mb_substr($text,$pos+1,strlen($text) - $pos - 1);
				}
				
				$img->resizeCanvas($width+70, $height+200, 'top', false, '000000');
				$this->putText($img, $width, $height+150, $tempe);
				
				if(strlen($text)>0){
					mb_internal_encoding("UTF-8");
					$text = mb_substr($text,0,$chs);
				
					$img->resizeCanvas($width+70, $height+265, 'top', false, '000000');
					$this->putText($img, $width, $height+210, $text);
				}
			}
		}
		$img->resizeCanvas($width+70, $img->height()+20, 'top', false, '000000');
		
		$this->save();
		$img->save($this->adress);
		
		$img->resize(300, null, function ($constraint) {
			$constraint->aspectRatio();
		});
		$img->save(substr($this->adress,0,-4).'s.jpg');
	}
	
	function putText($img, $width, $he, $text){
		$img->text($text,($width+70)/2,$he,function($font) {
			$font->color(array(255, 255, 255, 1));
			$font->file('AdonisC_Bold_Italic.otf');
			$font->size(40);
			$font->align('center');
			$font->valign('bottom');
		});
	}
}
