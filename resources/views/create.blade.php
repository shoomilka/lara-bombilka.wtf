@extends('template')

@section('title')
Post
@stop

@section('content')



	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<div class="row-fluid" align="middle">
	<div class="col-md-12">
	

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Залить новый</div>
                <div class="panel-body">
	
	
@if(Auth::check())
	Hello, {{Auth::user()->name}}
	<p></p>
@endif
	
	<form class="form-horizontal" action='/post' role="form"  method='post' enctype="multipart/form-data">
		{!! csrf_field() !!} 
		
		@if($errors->has())			
			@foreach ($errors->all() as $error)
				<div class="alert alert-warning">{{ $error }}</div>
			@endforeach
		@endif

		<div class="form-group">

			<div class="col-md-2 col-md-offset-4">
				<label>Файл</label>
				<input name="type" type="radio" value="1"
				<?php
					if(old('type')){
						if (intval(old('type'))==1){
							echo ' checked="checked"';
						}
					} else {
						echo ' checked="checked"';
					}
					
				?>
					>
			</div>

			<div class="col-md-2">
				<label>URL</label>
				<input name="type" type="radio" value="2"
				<?php
					if (intval(old('type')) == 2){
						echo ' checked="checked"';
					}
				?>
					>
			</div>
		</div>
		
		
		<div class="form-group{{ $errors->has('pic') ? ' has-error' : '' }} comp"
				<?php
					if(old('type')){
						if (old('type')==2){
							echo ' hidden="true"';
						}
					}
				?>
			>
			
			<div class="col-md-6 col-md-offset-3">
				<input type="file" name="pic" value="{{ old('pic') }}">
			</div>
		</div>
		
		<div class="form-group{{ $errors->has('link') ? ' has-error' : '' }} link"
				<?php
					if(old('type')){
						if (old('type')==1){
							echo ' hidden="true"';
						}
					} else {
						echo ' hidden="true"';
					}
				?>
			>
			
			<div class="col-md-4" align="right">
				<label>ссыль</label>
			</div>
			
			<div class="col-md-4">
				<input type="text" name="link" value="{{ old('link') }}">
			</div>
		</div>
		
		<div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
			<div class="col-md-4" align="right">
				<label>Надпись</label>
			</div>
			
			<div class="col-md-4">
				<input type="text" name="text" value="{{ old('text') }}">
			</div>
		</div>
		
		<div class="form-group">
            <div class="col-md-6 col-md-offset-3">
				<input type="submit" value="Загрузить">
			</div>
		</div>
		
	</form>


	
				</div>
            </div>
        </div>
    </div>
</div>
	
	
	
	</div>
</div>

<script>
$('input[name="type"]').on('click', function() {
    $('.link').toggle(+this.value === 2 && this.checked);
    $('.comp').toggle(+this.value === 1 && this.checked);
}).change();
</script>
	
@stop
