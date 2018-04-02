@extends('layouts.master')
@section('content')


<section class="subheader">
  <div class="container">
    <h1>Favorite Clinics</h1>
    <div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/mypage" class="current">Favorite Clinics</a></div>
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
			<div class="row">
				


			@foreach($FavoriteData as $data)

			<?php

				$ClinicMedicalSubjectName = DB::table('kmh_clinic_medical_subject')
					->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
					->where('clinic_id',$data->id)->orderBy('kmh_clinic_medical_subject.id', 'desc')->value('name_en');

				if(!$ClinicMedicalSubjectName) $ClinicMedicalSubjectName = "all";

				$medical_subject_url = $ClinicMedicalSubjectName."/";
				$medical_subject_url = str_replace(" ","-",$medical_subject_url);

				
				$url = "/clinic/".$medical_subject_url.$data->name_url;



				$clinic_img = DB::table('kmh_media')->where('of','CLINIC')->where('of_id',$data->id)->orderBy('id', 'desc')->value('path');
				if(!$clinic_img) $clinic_img = "/front/images/1837x1206.png";

				$addr_arry = explode(",",$data->address_en);
				$addr = $data->address_en;
				if(count($addr_arry) > 3 ) $addr = $addr_arry[count($addr_arry)-2].", ".$addr_arry[count($addr_arry)-1];

				$type_name = DB::table('kmh_clinic_type')->where('id',$data->type_id)->value('name_en');

				// 병원 의사 정보
				$DoctorCount = DB::table('kmh_clinic_doctor');
				$DoctorCount = $DoctorCount->where('clinic_id',$data->id);
				$DoctorCount = $DoctorCount->orderBy('id', 'desc')->count('id');


				// 병원 진료 정보
					$ClinicMedicalSubjectData = DB::table('kmh_clinic_medical_subject')
						->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
						->where('clinic_id',$data->id)->orderBy('kmh_clinic_medical_subject.id', 'asc')->get();

			?>
				<div class="col-lg-6">
					<div class="property property-hidden-content slide">
						<a href="{{ $url }}" class="property-content">
							<div class="property-title">
								<p class="property-address"><i class="fa fa-map-marker icon"></i>{{$addr}}</p>
								<p class="property-text" style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;margin-bottom:0px;">Type: {{ $type_name }}</p>
								<p class="property-text" style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;margin-top:0px;">Department : 
									@if(count($ClinicMedicalSubjectData) > 0 )
										<?php $index = 1; ?>
										@foreach($ClinicMedicalSubjectData as $m_data)
											{{$m_data->name_en}}
											@if( $index != count($ClinicMedicalSubjectData)), @endif
											<?php $index++ ?>
										@endforeach
									@else 
										information unavailable
									@endif								
								</p>
								
							</div>
							<table class="property-details">
								<tr>
									<td><i class="fa fa-user-md"></i> {{ number_format($DoctorCount) }} Doctor<?php if($DoctorCount > 1 ) echo "s" ?></td>
									<td><i class="fa fa-anchor"></i> Since {{ substr($data->established,0,4)}}</td>							
								</tr>
							</table>
						</a>
						<a href="{{ $url }}" class="property-img">
							<div class="img-fade"></div>
							
							<div class="property-price">{{$data->name_en}}</div>
							<div class="property-color-bar"></div>
							<img src="{{$clinic_img}}" alt="" />
						</a>
					</div>
				</div>
			@endforeach   
			</div>

			
			
			<div class="pagination">
				<div class="center">
					{!! $FavoriteData->links('vendor.pagination.bootstrap-4') !!}
				</div>
				<div class="clear"></div>
			</div>
		</div><!-- end col -->
	</div><!-- end row -->

  </div><!-- end container -->
</section>


@include('layouts.footer')

@include('layouts.js')

<script>
	function fnfavoriteDel(id) {

		if (confirm('Are you sure you want to delete this?    '))
		{
			var url_str = '/mypage/del/favorite?id='+id;	
		
			$.ajax({
				url:url_str,
				type:'get',
				success:function(data){	
					window.location.reload();
				},
				complete : function(data) {
					
			   },
				error:function(request,status,error){
					
			   }
			});	
		}

		
	}
</script>
@stop