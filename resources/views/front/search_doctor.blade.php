@extends('layouts.master')
@section('content')


<style>
.highlight{color:#f37a6f;font-weight:600}
</style>

<section class="subheader">
	<div class="container">
		<h1>"{{$keyword}}"</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> Search</div>
		<div class="clear"></div>
	</div>
</section>

<section class="module">
	<div class="container"> 
		@if(count($DoctorData) > 0 )
		<div class="row">
			<div class="col-lg-12">
				<h3>Doctor</h3>
				<ul >
				@foreach($DoctorData as $data)
				<?php
				$clinic_name = DB::table('kmh_clinic')->where('id', $data->clinic_id)->value('name_en');

				// 학력 정보
				$education_name = DB::table('kmh_education')->where('id', $data->education_id)->value('school_name_en');


				// 전문의
				$SpecialtyData = DB::table('kmh_clinic_doctor_specialty')		
					->select('name_en')
					->join('kmh_specialty', 'kmh_specialty.id', '=', 'kmh_clinic_doctor_specialty.specialty_id')		
					->where('doctor_id',$data->id)->get();

				$specialty = "";
				foreach($SpecialtyData as $s_data) {
					$specialty .= $s_data->name_en.", ";
				}
				if($specialty) $specialty = mb_substr($specialty,1,(mb_strlen($specialty) - 3) );


				$ClinicMedicalSubjectName = DB::table('kmh_clinic_medical_subject')
					->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
					->where('clinic_id',$data->clinic_id)->orderBy('kmh_clinic_medical_subject.id', 'desc')->value('name_en');

				if(!$ClinicMedicalSubjectName) $ClinicMedicalSubjectName = "all";

				$medical_subject_url = $ClinicMedicalSubjectName."/";
				$medical_subject_url = str_replace(" ","-",$medical_subject_url);
				
				$url = "/clinic/".$medical_subject_url.$data->name_url."#doctor".$data->id;
				?>
					<li style="border-bottom:1px solid #e5e5e5;margin-bottom:10px;">
						<h5 class="search_box"><a href="{{$url}}">Dr. {{ucwords($data->first_name_en)}} {{ucwords($data->last_name_en)}}</a></h5>
						<p>{{$clinic_name}}, 
						@if($specialty){{$specialty}} ,@endif
						@if($education_name){{$education_name}} ,@endif
						</p>
					</li>
				@endforeach
				</ul>				
				<div class="divider"></div>
			</div>
		</div>
		<div class="pagination">
			<div class="center">
				{!! $DoctorData->appends(['keyword' => $keyword])->links('vendor.pagination.bootstrap-4') !!}
			</div>
			<div class="clear"></div>
		</div>
		@endif
	</div>
</section>

@include('layouts.footer')

@include('layouts.js')

<script>
jQuery(document).ready(function(){
	//// onload시 읽어드리는 스크립트에 다음과 같이 사용
	var sKey1 = "{{urldecode($keyword)}}"; // 해당 검색어
	if(sKey1 != ''){		
		$('.search_box').highlight(sKey1); // 하이라이트(여러개의 검색어라면 단순하게 여러번 사용
		@if(count($keyword_arry) > 1)
			@foreach($keyword_arry as $value)
			$('.search_box').highlight("{{$value}}"); // 하이라이트(여러개의 검색어라면 단순하게 여러번 사용
			@endforeach
		@endif
	}
});
</script>
@stop