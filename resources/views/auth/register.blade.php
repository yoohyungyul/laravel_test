@extends('layouts.master')
@section('content')

<section class="subheader">
	<div class="container">
		<h1>Register</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/register" class="current">Register</a></div>
		<div class="clear"></div>
	</div>
</section>

<section class="module login">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-lg-offset-4"> 
				@if(Session::has('success'))			
				 <div class="row">
					<div class="col-lg-12">
						<div class="alert-box success"><i class="fa fa-check icon"></i> {{ Session::get('success') }}</div>
					</div>
				</div>
				@endif
				@if(Session::has('danger'))
				
				 <div class="row">
					<div class="col-lg-12">
						<div class="alert-box error"><i class="fa fa-close icon"></i> {{ Session::get('danger') }}</div>
					</div>
				</div>
				@endif
				<p>Already have an account? <strong><a href="{{ route('login') }}">Login here.</a></strong></p> 
				<form class="login-form" method="POST" action="{{ route('register') }}" autocomplete="off"  onsubmit="return r_writeCheck(this);" >
                {{ csrf_field() }}

				<div class="form-block{{ $errors->has('name') ? ' has-error' : '' }}">
					<label>Name</label>
					<input id="name" type="text" class="border" name="name" value="{{ old('name') }}" required autofocus>
					@if ($errors->has('name'))
						<span class="help-block">
							<strong>{{ $errors->first('name') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-block{{ $errors->has('email') ? ' has-error' : '' }}">
					<label>Email</label>
					<input id="email" type="email" class="border" name="email" value="{{ old('email') }}" required autofocus>
					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-block{{ $errors->has('password') ? ' has-error' : '' }}">
					<label>Password</label>
					<input id="password" type="password" class="border" name="password" required>
					 @if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif

				</div>
				<div class="form-block">
					<label>Confirm Password</label>
					<input id="password-confirm" type="password" class="border" name="password_confirmation" required>
				</div>
				<div class="form-block">
					<button class="button button-icon" type="submit" id="m_submit"><i class="fa fa-angle-right"></i>Register</button>
				</div>
				<div class="divider"></div>
				<p class="note">By clicking the "Register" button you agree with our <a href="#">Terms and conditions</a></p>    
				</form>
			</div>
		</div><!-- end row -->
	</div>
</section>


@include('layouts.footer')

@include('layouts.js')

<script>
function r_writeCheck(f) {

	

	$('#m_submit').attr("disabled",true);
}
</script>
@stop