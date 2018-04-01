@extends('layouts.master')
@section('content')

<?php

$intended_url = Request::server('HTTP_REFERER');
if($intended_url) Session::put('url.intended',$intended_url);


?>
<section class="subheader">
	<div class="container">
		<h1>Login</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/login" class="current">Login</a></div>
		<div class="clear"></div>
	</div>
</section>

<section class="module login">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-lg-offset-4"> 

				

				 @if(Session::has('status'))			
				 <div class="row">
					<div class="col-lg-12">
						<div class="alert-box success"><i class="fa fa-check icon"></i> 11{{ Session::get('status') }}</div>
					</div>
				</div>
				@endif
				


				<p>Don't have an account? <strong><a href="{{ route('register') }}">Register here.</a></strong></p> 
				<form class="login-form" method="POST" action="{{ route('login') }}">
                 {{ csrf_field() }}
				<div class="form-block">
					<label>Email</label>
					<input id="email" type="email" class="border" name="email" value="{{ old('email') }}" required autofocus>
					 @if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>
				<div class="form-block">
					<label>Password</label>
					<input id="password" type="password" class="border" name="password" required>
					@if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif
				</div>
				<div class="form-block">
					<label> <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me</label><br/>
				</div>
				<div class="form-block">
					<button class="button button-icon" type="submit"><i class="fa fa-angle-right"></i>Login</button>
				</div>
				<div class="divider"></div>
				<p class="note"><a href="{{ route('password.request') }}">I don't remember my password.</a> </p>    
				</form>
			</div>
		</div><!-- end row -->
	</div>
</section>



@include('layouts.footer')

@include('layouts.js')


@stop