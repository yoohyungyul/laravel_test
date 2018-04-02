@extends('layouts.master')
@section('content')

<section class="subheader">
	<div class="container">
		<h1>Treatments</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/treatments" class="current">Treatments</a></div>
		<div class="clear"></div>
	</div>
</section>

<section class="module">
	<div class="container">    
		<div class="row">
			<div class="col-lg-8 col-md-8">
				<div id="accordion" class="content">
					@foreach($procedureData as $data)
					<?php $procedureSubData	= DB::table('kmh_procedure_info')->where('depth',3)->where('parent_id',$data->id)->orderBy('name_en', 'asc')->get(); ?>
					<h3>{{$data->name_en}}</h3>
					<div>
						
							<div class="tagcloud01">
								<ul >
								<?php $_i = 0 ?>
								@foreach($procedureSubData as $sub_date)
								<?php
									$url = "/treatment/".$sub_date->name_url;
								?>
									<li><a href="{{$url}}"><i class="fa fa-tag" aria-hidden="true"></i> {{$sub_date->name_en}}</a></li>								
								<?php $_i++ ?>
								
								@endforeach
								</ul>
							</div>

							@foreach($procedureSubData as $sub_date)
							@endforeach
						
						<div class="divider"></div>
						<span class=""><a href="/contact">Can't find your treatment? Please ask us to add on the list</a></span>
					</div>
					@endforeach

				</div>
			</div>
			<div class="col-lg-4 col-md-4 sidebar sidebar-property-single">		
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