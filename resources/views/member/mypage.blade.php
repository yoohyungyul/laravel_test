@extends('layouts.master')
@section('content')


<section class="subheader">
  <div class="container">
    <h1>Profile</h1>
    <div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/mypage" class="current">Profile</a></div>
    <div class="clear"></div>
  </div>
</section>

<section class="module favorited-properties">
  <div class="container">
	
  
	<div class="row">
		<div class="col-lg-3 col-md-3 sidebar-left">
			@include('member.left_menu')		
			
		</div>

		<div class="col-lg-9 col-md-9">

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

			<form autocomplete="off" method="POST" onsubmit="return r_writeCheck(this);" action="/mypage/mod/user"  enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="row">
					<div class="col-lg-3">
						<div class="edit-avatar">
							<img class="profile-avatar" src="{{Auth::user()->photo}}" alt=""  style="width:100%"/>
							<input type="file"  class="form-control" style="width:95%" name="photo"/>
						</div>
					</div>
					<div class="col-lg-9">
						<div class="form-block">
							<label>Full Name</label>
							<input class="border" type="text" name="name" value="{{Auth::user()->name}}" />					
						</div>
						<div class="row">
							<div class="col-lg-6">

								<label>Gender</label><br>
								<label><input type="radio" name="gender"  value="2" @if(Auth::user()->gender == "2") checked="checked" @endif/>Female</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="gender" value="1" @if(Auth::user()->gender == "1") checked="checked" @endif/>Male</label>
							</div>
							<div class="col-lg-6">
								<label>Date of Birth</label>
								<input type="text" name="birthday" id="datepicker" placeholder="" class="border" readonly value="{{Auth::user()->birthday}}">
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<label>Country of Residence</label>
								<select class="border" name="country">
									<option value="">Select an Option</option>
									@foreach($CountryData as $data)
										<option value="{{$data->group_value}}" @if(Auth::user()->country == $data->group_value) selected="selected" @endif>{{$data->group_str}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-lg-6">
								<label>Phone Number</label>
								<input class="border" type="text" name="tel" value="{{Auth::user()->tel}}"   placeholder="+ 82"/>
							</div>
						</div>
					</div>
				</div><!-- end row -->
				
				<div class="row" style="margin-top:50px;">
					<div class="col-lg-6">
						<h4>Contact Information</h4>
						<div class="divider"></div>
						<div class="form-block">
							<label>Messenger</label>
							<select class="border" name="messenger">
								<option value="">Select an Option</option>
								@foreach($MessengerData as $data)
									<option value="{{$data->group_value}}" @if(Auth::user()->messenger == $data->group_value) selected="selected" @endif >{{$data->group_str}}</option>
								@endforeach
							</select>
						</div>
						
						<div class="form-block">
							<label>ID</label>
							<input class="border" type="text" name="messenger_id" value="{{Auth::user()->messenger_id}}" />
						</div>
					</div>
					
					<div class="col-lg-6">
						<h4>Change Password</h4>
						<div class="divider"></div>
						<div class="form-block">
							<label>Current Password</label>
							<input class="border" type="password" name="current_pass" />
						</div>
						
						<div class="form-block">
							<label>New Password</label>
							<input class="border" type="password" name="new_pass" />
						</div>
						
						<div class="form-block">
							<label>Confirm New Password</label>
							<input class="border" type="password" name="new_pass_confirm" />
						</div>
					</div>
				</div><!-- end row -->
				
				<div class="form-block text-right">
					<button type="submit" class="button button-icon"><i class="fa fa-check"></i>Save Changes</button>
				</div>
				
			</form>
		
		</div><!-- end col -->
	</div><!-- end row -->

  </div><!-- end container -->
</section>


@include('layouts.footer')

@include('layouts.js')

<script>
	function r_writeCheck(f) {

		if (f.name && f.name.value == '') {
			alert("Please write your name. ");
			f.name.focus();
			return false;
		}


		if(f.new_pass.value) {

			if (f.current_pass && f.current_pass.value == '') {
				alert("Current password. ");
				f.current_pass.focus();
				return false;
			}

			if (f.new_pass_confirm && f.new_pass_confirm.value == '') {
				alert("New password. ");
				f.new_pass_confirm.focus();
				return false;
			}

			if (f.new_pass.value.length < 6) {
				 alert("Your new password must be more than 6 charaters. ");
				 f.new_pass.focus();
				return false;
			 }	

			 if (f.current_pass.value == f.new_pass.value) {
				 alert("This seems to be the same as your current password.");
				 f.new_pass.focus();
				return false;
			 }	

			  if (f.new_pass.value != f.new_pass_confirm.value) {
				 alert("Please confirm your new password.");
				 f.new_pass_confirm.focus();
				return false;
			 }				
		}

		 if (confirm('Are you sure you want to modify this?    '))
			{
				return true;
			}
		return false;
	}

	 $("#datepicker").datepicker({
        inline: true
    });
</script>
@stop