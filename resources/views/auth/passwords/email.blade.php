@extends('layouts.master')
@section('content')
<section class="subheader">
	<div class="container">
		<h1>Reset Password</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="{{ route('password.request') }}" class="current">Reset Password</a></div>
		<div class="clear"></div>
	</div>
</section>


<section class="module login">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-lg-offset-4"> 
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif
				<form class="login-form" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

				<div class="form-block{{ $errors->has('email') ? ' has-error' : '' }}">
					<label>E-Mail Address</label>
					<input id="email" type="email" class="border" name="email" value="{{ old('email') }}" required>
					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>
				<div class="form-block">
					<button class="button button-icon" type="submit"><i class="fa fa-angle-right"></i>Send Password Reset Link</button>
				</div>
				</form>				
			</div>
		</div><!-- end row -->
	</div>
</section>


@include('layouts.footer')

@include('layouts.js')


@stop