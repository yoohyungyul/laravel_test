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
			<div class="col-lg-8 col-md-8">		
				@foreach($blogData as $data)
				<?php
					$blog_image = DB::table('kmh_media')->where('of','BLOG')->where('of_id',$data->id)->value('path');	
				?>
				<div class="blog-post shadow-hover">
				  <a href="/blogView?id={{$data->id}}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}" class="blog-post-img">
					<div class="img-fade"></div>
					
					<img src="{{$blog_image}}" alt="" />
				  </a>
				  <div class="content blog-post-content">
					<h3><a href="/blogView?id={{$data->id}}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}">{{$data->title}}</a></h3>
					<ul class="blog-post-details">
					
					</ul>
					<p><?php echo mb_substr(strip_tags($data->content), 0, 300, "UTF-8"); ?></p>
					<a href="/blogView?id={{$data->id}}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}" class="button button-icon small alt"><i class="fa fa-angle-right"></i> Read More</a>
				  </div>
				</div>
				@endforeach

				<div class="pagination">
					<div class="center">
						{!! $blogData->links('vendor.pagination.bootstrap-4') !!}
					</div>
					<div class="clear"></div>
				</div>
				
			
			</div><!-- end col -->
		
			<div class="col-lg-4 col-md-4 sidebar sidebar-property-single">		
				@include('layouts.clinic_search')
				@include('layouts.popural_treatment')
				@include('layouts.popural_doctor')


			</div><!-- end row -->
		</div>
	</div><!-- end container -->
</section>

@include('layouts.footer')

@include('layouts.js')

<script>
</script>
@stop