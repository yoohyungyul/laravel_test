@extends('dbmon_layouts.master')
@section('content')

<!-- Page -->
<div class="page">
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/dbmon">관리자홈</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/clinic">병원리스트</a></li>
			<li class="breadcrumb-item active">{{ $ClinicData->name }}</li>
		</ol>
		<h1 class="page-title">의사정보</h1>
	</div>
	<div class="page-content container-fluid" >	
		@if(Session::has('success'))
		 <div class="alert dark alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		  {{ Session::get('success') }}
		</div>
		@endif
		@if(Session::has('danger'))
		<div class="alert dark alert-danger alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		  {{ Session::get('danger') }}
		</div>
		@endif
		<div class="panel">
			<div class="panel-body container-fluid">
				<div class="row row-lg">
					<div class="col-xl-12">      
						@include('dbmon.clinicTop')
		                
					</div>
				</div>	
				<form name="form_doctor"  method="get" >	
				<input type="hidden" name="returnurl" value="{{ $_SERVER['REQUEST_URI'] }}" />
				<div class="row row-lg">
					<div class="col-xl-12">
						<h4 class="pt-30">의사 리스트</h4>
						<table class="table table-hover">
							<thead>
							<tr>
								<th><input type="checkbox" id="checkall" /></th>
								<th>#</th>
								<th>사진</th>
								<th>이름</th>
								<th>전문의</th>
								<th>진료과목</th>
								<th>학교</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
								<?php $_i=0; ?>
								@foreach($ClinicDoctorData as $data)
								<?php
									// 의사 사진 첫번째
									$ImgData = DB::table('kmh_media')->where('of','DOCTOR')->where('of_id', $data->id)->orderBy('id','desc')->first();
									$img = "";
									if($ImgData) $img = $ImgData->path;

									// 전문의
									$SpecialtyData = DB::table('kmh_clinic_doctor_specialty')		
										->select('name')
										->join('kmh_specialty', 'kmh_specialty.id', '=', 'kmh_clinic_doctor_specialty.specialty_id')		
										->where('doctor_id',$data->id)->get();

									$specialty = "";
									foreach($SpecialtyData as $s_data) {
										$specialty .= $s_data->name.", ";
									}
									if($specialty) $specialty = mb_substr($specialty,0,(mb_strlen($specialty) - 2) );

	
									// 진료과목
									$MedicalData = DB::table('kmh_clinic_doctor_medical_subject')		
										->select('gov_name')
										->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_doctor_medical_subject.medical_subject_id')		
										->where('doctor_id',$data->id)->get();

									$medical = "";
									foreach($MedicalData as $m_data) {
										$medical .= $m_data->gov_name.", ";
									}
									if($medical) $medical = mb_substr($medical,0,(mb_strlen($medical) - 2) );


									$education_name = DB::table('kmh_education')->where('id', $data->education_id)->value('school_name');


								?>
								
								<tr>
									<td><input type="checkbox"  class="chk" name="id[]" value="{{$data->id}}"/></td>
									<td>{{$ClinicDoctorData->total() - ( ( ($ClinicDoctorData->currentPage() - 1) * $ClinicDoctorData->perPage()) + $_i ) }}</td>
									<td><img src="{{$img}}" width="50" /></td>
									<td>{{$data->first_name_kr}} {{$data->last_name_kr}}</td>
									<td>{{$specialty}}</td>
									<td>{{$medical}}</td>
									<td>{{$education_name}}</td>
									<td>
										<button type="button" class="btn btn-info btn-xs" onclick="fuDoctorMod({{ $data->id }})">수정</button>
									</td>
								</tr>
								<?php $_i++; ?>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-xl-12 text-right">
						{!! $ClinicDoctorData->render() !!}
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-6 ">						
						<button type="button" class="btn btn-danger" onclick="fuDoctorDel('id[]')">삭제</button>
						<button type="button" class="btn btn-info" onclick="fuDoctorAdd()">+ 추가</buttoN>						
					</div>
					<div class="col-6 text-right ">
						<a class="btn btn-default" href="{{$returnurl}}">돌아가기</a>
					</div>
				</div>
				</form>
			</div>
		</div>
		
		</form>
	</div>
</div>
 <!-- End Page -->  



<!-- Footer -->  
@include('dbmon_layouts.footer')
<!-- End Footer -->

<!-- Javascript -->
@include('dbmon_layouts.js')
<!-- End Javascript -->

<script>
(function(document, window, $) {
'use strict';
var Site = window.Site;
$(document).ready(function() {
	Site.run();

	//최상단 체크박스 클릭
    $("#checkall").click(function(){
        //클릭되었으면
        if($("#checkall").prop("checked")){
            //input태그의 name이 chk인 태그들을 찾아서 checked옵션을 true로 정의
            $(".chk").prop("checked",true);
            //클릭이 안되있으면
        }else{
            //input태그의 name이 chk인 태그들을 찾아서 checked옵션을 false로 정의
            $(".chk").prop("checked",false);
        }
    })


});
})(document, window, jQuery);


function fuDoctorAdd() {

  url = "/modal/doctor/add?id={{ $id }}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";
	
	$("#Modal_fade .modal-content").load(url, function() { 
		 $("#Modal_fade").modal("show"); 
	});
}

function fuDoctorMod(doctor_id) {
	

    url = "/modal/doctor/mod?doctor_id="+doctor_id+"&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";
	
	$("#Modal_fade .modal-content").load(url, function() { 
		 $("#Modal_fade").modal("show"); 
	});
}

function fuDoctorDel(obj) {
	var i, sum=0, tag=[], str="";
    var chk = document.getElementsByName(obj);
    var tot = chk.length;
    for (i = 0; i < tot; i++) {
        if (chk[i].checked == true) {
            tag[sum] = chk[i].value;
            sum++;
        }
    }

	

    if(tag.length == 0)  {
		alert("삭제 할 의사를 선택해 주세요");
		return false;
	}

	if (confirm('정말 삭제 하시겠습니까?    '))
	{
		document.form_doctor.action="/dbmon/del/doctor";
		document.form_doctor.submit();
	}	
}

</script>

@stop