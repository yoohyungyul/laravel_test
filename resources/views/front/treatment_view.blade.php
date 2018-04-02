@extends('layouts.master')
@section('content')

<section class="subheader">
	<div class="container">
		<h1>{{$ProcedureInfoData->name_en}}</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/treatments">treatments</a> <i class="fa fa-angle-right"></i> {{$ProcedureInfoData->name_en}}</div>
		<div class="clear"></div>
	</div>
</section>

<section class="module">
	<div class="container">    
		<div class="row">
			<div class="col-lg-8 col-md-8">
				<div class="blog-post">
					<a href="#" class="blog-post-img">
						<div class="img-fade"></div>						
						<img src="{{$ProcedureInfoData->img}}" alt="" />
					</a>
					<div class="content blog-post-content">
						<h3>{{$ProcedureInfoData->name_en}}</h3>		
						<hr>
						<p><?php echo str_replace(chr(13),'<br />',$ProcedureInfoData->description) ?></p>						
						<div class="blog-post-share">
							<div class="divider"></div>
							<span class="left"><strong>Share:</strong> </span>
							<ul class="social-icons circle">
								<li><a class="a2a_dd" href="https://www.addtoany.com/share"><i class="fa fa-share-alt"></i></a></li>
							</ul>
						</div>						
					</div>
				</div><!-- end blog post -->
				
				@if($ProcedureInfoData->relation)
				<?php

					$relation_id = $ProcedureInfoData->relation;
					$relation_id = str_replace("[[","",$relation_id);
					$relation_id = str_replace("]]","",$relation_id);

					$relation_id = explode(",",$relation_id);

					

					$relationTreatmentData = DB::table('kmh_procedure_info')->whereIn('id', $relation_id)->take(2)->get();

				?>

				<div class="widget blog-post-related">
					<h4><span>Related Treatment</span> <img src="/front/images/divider-half.png" alt="" /></h4>				
					<div class="row">
						<div class="col-md-12">
							<div class="tagcloud01">
								<ul >
						<?php $_i = 0 ?>
						@foreach($relationTreatmentData as $data)
						<?php
							$procedureSubData	= DB::table('kmh_procedure_info')->where('depth',3)->where('parent_id',$data->id)->orderBy('name_en', 'asc')->get();
							$url = "/treatment/".$data->name_url;
						?>
									<li><a href="{{$url}}"><i class="fa fa-tag" aria-hidden="true"></i> {{$data->name_en}}</a></li>
						
						<?php $_i++ ?>
						
						@endforeach
								</ul>
							</div>
						</div>
					</div><!-- end row -->				
				</div><!-- end related posts -->
				@endif
			</div>

			<div class="col-lg-4 col-md-4 sidebar"> 
				@include('layouts.popural_treatment')
				@include('layouts.popural_doctor')
			</div>
		</div>
	</div>
</section>

@include('layouts.footer')

@include('layouts.js')

<script>
</script>
@stop