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
		@if(count($ClinicData) > 0 )
		<div class="row">
			<div class="col-lg-12">
				<h3>Clinic</h3>
				<ul >
				@foreach($ClinicData as $data)
				<?php
					$ClinicMedicalSubjectName = DB::table('kmh_clinic_medical_subject')
						->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
						->where('clinic_id',$data->id)->orderBy('kmh_clinic_medical_subject.id', 'desc')->value('name_en');

					if(!$ClinicMedicalSubjectName) $ClinicMedicalSubjectName = "all";

					$medical_subject_url = $ClinicMedicalSubjectName."/";
					$medical_subject_url = str_replace(" ","-",$medical_subject_url);
					
					$url = "/clinic/".$medical_subject_url.$data->name_url;

					// 병원 의사 정보
					$DoctorCount = DB::table('kmh_clinic_doctor');
					$DoctorCount = $DoctorCount->where('clinic_id',$data->id);
					$DoctorCount = $DoctorCount->orderBy('id', 'desc')->count('id');

				
					
					$addr_arry = explode(",",$data->address_en);
					$addr = $data->address_en;
					if(count($addr_arry) > 3 ) $addr = $addr_arry[count($addr_arry)-2].", ".$addr_arry[count($addr_arry)-1];

					$type_name = DB::table('kmh_clinic_type')->where('id',$data->type_id)->value('name_en');

					// 병원 진료 정보
					$ClinicMedicalSubjectData = DB::table('kmh_clinic_medical_subject')
						->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
						->where('clinic_id',$data->id)->orderBy('kmh_clinic_medical_subject.id', 'asc')->get();

				?>
				<li style="border-bottom:1px solid #e5e5e5;margin-bottom:10px;">
					<h5 class="search_box"><a href="{{$url}}">{{$data->name_en}}</a></h5>
					<p>
					{{ number_format($DoctorCount) }} Doctor<?php if($DoctorCount > 1 ) echo "s" ?>, 
					Since {{ substr($data->established,0,4)}}, 
					address : {{$addr}}, Type : {{$type_name}}, Department : 
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
				</li>
				@endforeach
				</ul>
				<div class="divider"></div>
			</div>
		</div>
		<div class="pagination">
			<div class="center">
				{!! $ClinicData->appends(['keyword' => $keyword])->links('vendor.pagination.bootstrap-4') !!}
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