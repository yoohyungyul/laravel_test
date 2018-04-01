@extends('layouts.master')
@section('content')


<section class="subheader">
	<div class="container">
	
		<div class="clear"></div>
	</div>
</section>


<section class="module">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8">
				
				<div class="comment-form">
					<h4><span>Quick Contact</span> <img src="/front/images/divider-half.png" alt="" /></h4>
					<p><b>Fill out the form below.</b> Morbi accumsan ipsum velit Nam nec tellus a odio tincidunt auctor a ornare odio sedlon maurisvitae erat consequat auctor</p>
			  

					<form autocomplete="off" id="contact-us" name="form_add" method="POST" action="/add/contact" onsubmit="return r_writeCheck(this);"  >
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-block">
						<label>
							<font color="red">*</font> Name 
						</label>
						<input class="requiredField" type="text" placeholder="Your Name" name="name" value="" />
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-block">
								<label>
									<font color="red">*</font> Email 
								</label>
								<input class="email requiredField" type="email" placeholder="Your email" name="email" value="" />
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-block">
								<label>Phone</label>
								<input type="text" placeholder="Your phone" name="phone" value="" />
							</div>
						</div>
					</div>
					<div class="form-block">
						<label><font color="red">*</font> Subject </label>
						<input type="text" class="requiredField" placeholder="Subject" name="subject" value="" />
					</div>

					<div class="form-block">
						<label>
							<font color="red">*</font> Message 
						</label>
						<textarea class="requiredField" placeholder="Your message..." name="message"></textarea>
					</div>

					<div class="form-block">
						<input type="submit" value="Submit" />
						<input type="hidden" name="submitted" id="submitted" value="true" />
					</div>
					</form>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 sidebar">        
				@include('layouts.popural_treatment')
				@include('layouts.popural_doctor')
			</div>
		</div><!-- end row -->
	</div><!-- end container -->
</section>

@include('layouts.footer')

@include('layouts.js')


<script>
function r_writeCheck(f) {
		if (f.name && f.name.value == '') {
		alert("이름을 입력하세요. ");
		f.name.focus();
		return false;
	}

	if (f.email && f.email.value == '') {
		alert("이메일을 입력하세요. ");
		f.email.focus();
		return false;
	}

	if (f.subject && f.subject.value == '') {
		alert("제목을 입력하세요. ");
		f.subject.focus();
		return false;
	}

	if (f.message && f.message.value == '') {
		alert("내용을 입력하세요. ");
		f.message.focus();
		return false;
	}

	if (confirm('정말 등록 하시겠습니까?    '))
	{
		return true;	
	}
		return false;
}
</script>


@stop