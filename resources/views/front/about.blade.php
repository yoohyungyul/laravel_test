@extends('layouts.master')
@section('content')


<section class="subheader" style="padding-top: 80px;">
	<div class="container">
		<div class="clear"></div>
	</div>
</section>

<section class="module">
	<div class="container">  
		<div class="row">
			<div class="col-lg-6 col-md-6">
				<h3>We are Homely Real Estate.</h3>
				<img src="/front/images/divider-half.png" alt="" /><br/><br/>
				<p><strong>hasellus suscipit sem sapien. Phasellus risus purus, accumsan vel molestie vitae, sagittis sed massa. Sed elementum nisl tellus, at pharetra odio pharetra.</strong></p>
				<p>Aenean quis sem nisi. Aliquam vehicula gravida orci, nec pretium mi ultricies in. Donec fermentum pulvinar mauris sed gravida. Pellentesque neque justo, commodo sed varius at, sagittis ut neque. In luctus pellentesque hendrerit. Vivamus congue laoreet urna, sed cursus odio scelerisque id. Curabitur volutpat pretium laoreet. Cras pulvinar vulputate porttitor.</p>
			</div>
			<div class="col-lg-6 col-md-6">
				<a href="https://youtu.be/mehLx_Fjv_c" class="html5lightbox"><img class="about-video-thumb right" src="/front/images/530x345.png" alt="about" /></a>
				<div class="clear"></div>
			</div>
		</div> 
	</div><!-- end container -->
</section>

@include('layouts.footer')

@include('layouts.js')

<script>
</script>
@stop