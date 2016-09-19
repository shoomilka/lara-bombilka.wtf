<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Request;
use Image;
use Validator;
use App\Post;
use App\Comment;
use File;
use Redirect;
use Auth;
use Cookie;

class PostController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function getPost(){
		return view('create');
	}
	
	public function postPost(){
		$validator = Validator::make(Request::all(), [
            'text' => 'required|max:255'
        ]);
        
        if($validator->fails()) {
			return back()->withErrors(array('text' => 'Текст должен содержать от 1 до 255 символов'))->withInput();
		}
        
        $text = Request::input('text');
		
		$validator = Validator::make(Request::all(), [
            'pic' => 'required|image'
        ]);
		
		if($validator->fails()) {
			$validator = Validator::make(Request::all(), [
				'link' => 'required|url'
			]);
			
			if($validator->fails()){
				return back()->withErrors(array('pic' => 'И где картинка?'))->withInput();
			}
			
			$file_headers = @get_headers(Request::input('link'));
			if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
				return back()->withErrors(array('link' => 'Ссыль некорректна'))->withInput();
			}
			
			//if(!File::exists()){
				//return back()->withErrors(array('link' => 'Ссыль некорректна'))->withInput();
			//}
			
			$img = Image::make(Request::input('link'));
			
		}else{
			$img = Image::make(Request::file('pic'));
		}
		
		$width = $img->width();
		$height = $img->height();
		
		if($width > 950){
			$img->resize(950, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
		}
		
		if($height > 950){
			$img->resize(null, 950, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
		}

		$width = $img->width();
		$height = $img->height();
		
		$post = Post::create();
		
		$post->adress = 'dem/'.date('Y').'/'.date('m');
		File::makeDirectory($post->adress, 0755, true, true);
		$post->adress = $post->adress.'/'.$post->id.'_'.str_random(20).'.jpg';
		$img->save($post->adress);
		
		$img->resizeCanvas($width+12, $height+12, 'center', false, '000000');
		$img->resizeCanvas($width+15, $height+15, 'center', false, 'ffffff');
		$img->resizeCanvas($width+70, $height+70, 'center', false, '000000');
		$img->resizeCanvas($width+70, $height+135, 'top', false, '000000');
		
		$chs = floor($width/22);
		
		mb_internal_encoding("UTF-8");
		if(mb_strlen($text)<$chs+1){
			$img->text($text,($width+70)/2,$height+90,function($font) {
				$font->color(array(255, 255, 255, 1));
				$font->file('AdonisC_Bold_Italic.otf');
				$font->size(40);
				$font->align('center');
				$font->valign('bottom');
			});
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
			
			$img->text($tempe,($width+70)/2,$height+90,function($font) {
				$font->color(array(255, 255, 255, 1));
				$font->file('AdonisC_Bold_Italic.otf');
				$font->size(40);
				$font->align('center');
				$font->valign('bottom');
			});
			
			mb_internal_encoding("UTF-8");
			if(mb_strlen($text)<$chs+1){
				$img->resizeCanvas($width+70, $height+200, 'top', false, '000000');
				$img->text($text,($width+70)/2,$height+150,function($font) {
					$font->color(array(255, 255, 255, 1));
					$font->file('AdonisC_Bold_Italic.otf');
					$font->size(40);
					$font->align('center');
					$font->valign('bottom');
				});
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
				$img->text($tempe,($width+70)/2,$height+150,function($font) {
					$font->color(array(255, 255, 255, 1));
					$font->file('AdonisC_Bold_Italic.otf');
					$font->size(40);
					$font->align('center');
					$font->valign('bottom');
				});
			
				if(strlen($text)>0){
					mb_internal_encoding("UTF-8");
					$text = mb_substr($text,0,$chs);
				
					$img->resizeCanvas($width+70, $height+265, 'top', false, '000000');
					$img->text($text,($width+70)/2,$height+210,function($font) {
						$font->color(array(255, 255, 255, 1));
						$font->file('AdonisC_Bold_Italic.otf');
						$font->size(40);
						$font->align('center');
						$font->valign('bottom');
					});
				}
			}
		}
		$img->resizeCanvas($width+70, $img->height()+20, 'top', false, '000000');
		
		$post->save();
		$img->save($post->adress);
		
		$img->resize(300, null, function ($constraint) {
			$constraint->aspectRatio();
		});
		$img->save(substr($post->adress,0,-4).'s.jpg');
		//return strlen($tempe);
		return Redirect::to('/num/'.$post->id);
	}
	
	public function getNum($id){
		$post = Post::find($id);
		if($post->hasMany('App\Comment')->count() > 0){
			$comms = Post::find($id)->hasMany('App\Comment');
			$comms = $comms->paginate(10);
		} else {
			$comms = null;
		}
		return view('post', array('post' => $post, 'comments' => $comms));
	}
	
	public function getGal(){
		$posts = Post::latest()->paginate(20);
		return view('gal', array('posts' => $posts));
	}
	
	public function postComment($id){
		$post = Post::find($id);
		
		$validator = Validator::make(Request::all(), [
            'text' => 'required|max:255',
            'user' => 'required|max:255',
        ]);
        
        if($validator->fails()) { return 'Non valid comment'; }
		
		$comm = Comment::create();
		$comm->user = Request::input('user');
		$comm->text = Request::input('text');
		$comm->post_id = $id;
		$comm->save();
		
		return Redirect::to('/num/'.$post->id);
	}
	
	public function dropPost($id){
		if(Auth::check()){
			$post = Post::find($id);
			$comms = $post->hasMany('App\Comment');
			foreach($comms as $comm){
				$comm->delete();
			}
			$post->delete();
			File::delete($post->adress);
			File::delete(substr($post->adress,0,-4).'s.jpg');
		}
		return Redirect::to('/');
	}
	
	public function dropComment($id){
		if(Auth::check()){
			$comm = Comment::find($id);
			$post_num = $comm->post_id;
			$comm->delete();
		}
		return Redirect::to('/num/'.$post_num);
	}
	
	public function plusPost($id){
		$value = Cookie::get('post'.$id);
		
		$post = Post::find($id);
		$cookie = Cookie::forever('post'.$id, '1');
		
		if(is_null($value)){
			$post->plus = $post->plus + 1;
			$post->save();
			return Redirect::to('/num/'.$id)->withCookie($cookie);
		}

		if($value == '13'){
			$post->minus = $post->minus - 1;
			$post->plus = $post->plus + 1;
			$post->save();
			return Redirect::to('/num/'.$id)->withCookie($cookie);
		}
		
		return Redirect::to('/num/'.$id);
	}
	
	public function minusPost($id){
		$value = Cookie::get('post'.$id);
		
		$post = Post::find($id);
		$cookie = Cookie::forever('post'.$id, '13');
		
		if(is_null($value)){
			$post->minus = $post->minus + 1;
			$post->save();
			return Redirect::to('/num/'.$id)->withCookie($cookie);
		}

		if($value == '1'){
			$post->minus = $post->minus + 1;
			$post->plus = $post->plus - 1;
			$post->save();
			return Redirect::to('/num/'.$id)->withCookie($cookie);
		}
		
		return Redirect::to('/num/'.$id);
	}
	
	public function getBest(){
		$posts = Post::orderBy('plus', 'desc')->paginate(20);
		return view('gal', array('posts' => $posts));
	}
	
	public function getBad(){
		$posts = Post::orderBy('minus', 'desc')->paginate(20);
		return view('gal', array('posts' => $posts));
	}
}
