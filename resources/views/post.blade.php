@extends('template')

@section('title')
Post
@stop

@section('content')

<?php
	use Carbon\Carbon;
	$car = Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at);	
?>

<div class="row-fluid" align="middle" >
	<div class="col-sm-12">
		<img src="/{{ $post->adress }}" class="img1 img-responsive" />	
	</div>
</div>

	

<div class="container bootstrap snippet">
    <div class="row">
		<div class="col-md-12">
			<div class="blog-comment">
				<h5 class="text">Zalito {{{$car->toFormattedDateString()}}}</h5>
				<h4 class="text"><a href="/plu/{{$post->id}}"><code> + {{{$post->plus}}}</code></a> <a href="/min/{{$post->id}}"><kbd> - {{{$post->minus}}}</kbd></a></h4>
				@if(Auth::check())
					<h5 class="text" align="right"><a href="/dpost/{{$post->id}}">delete demotiv</a></h5>
				@endif
				<h3 class="text">Comments</h3>
                <hr/>
				<ul class="comments">
@if(!is_null($comments))
	@foreach($comments as $comm)
		<?php
			$car = Carbon::createFromFormat('Y-m-d H:i:s', $comm->created_at);
		?>
	
		<li class="clearfix">
			<img src="/user.jpg" class="avatar" alt="">
				<div class="post-comments">
				    <p class="meta">{{{$car->toFormattedDateString()}}} <a href="#">{{{$comm->user}}}</a> says : 
						@if(Auth::check())
							<h5 class="text" align="right"><a href="/dcomm/{{$comm->id}}">delete comment</a></h5>
						@endif
					</p>
				    <p>{{{$comm->text}}}
					</p>
				</div>
		</li>

	@endforeach

<div class="col-sm-12" align="center">
	<?php echo $comments->links(); ?>
</div>
@endif
	
	<form action='/comm/{{$post->id}}'  method='post' enctype="multipart/form-data">
		{!! csrf_field() !!} 
		<p>Никнейм<Br>
		<p><input type="text" name="user" value="Онаним"></input></p>
		<p>Комментарий<Br>
			<textarea name="text" cols="40" rows="3"></textarea></p>
		<p><input type="submit" value="Reply"></p>
	</form>
			  
				</ul>
			</div>
		</div>
	</div>
</div>	
	
	
@stop
