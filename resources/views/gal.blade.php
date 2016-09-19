@extends('template')

@section('title')
Post
@stop

@section('content')

<style>
.mosaicflow__column {
	float:left;
	}
.mosaicflow__item img {
	display:block;
	height:auto;
	}
</style>

<div class="mosaicflow">

@foreach($posts as $post)

<div class="row-fluid">
	<div class="mosaicflow__item">
		<div class="img-thumbnail">
			<a href="/num/{{ $post->id }}">	
				<img class="img-responsive" src="/{{ substr($post->adress,0,-4).'s.jpg' }}" />
			</a>
			<h4 class="text"><a href="/num/{{$post->id}}">Comm {{$post->hasMany('App\Comment')->count()}}</a>         <a href="/plu/{{$post->id}}"><code> + {{{$post->plus}}}</code></a> <a href="/min/{{$post->id}}"><kbd> - {{{$post->minus}}}</kbd></a></h4>
		</div>
	</div>
</div>

@endforeach

</div>

<div class="col-sm-12" align="center">
	<?php echo $posts->links(); ?>
</div>

		<script>
		if (window.innerWidth > 700) {
			var script=document.createElement('script');
			script.src='js/jquery.mosaicflow.min.js';
			document.getElementsByTagName('head')[0].appendChild(script);
		}
		</script>

@stop
