@extends('dbmon_layouts.master')
@section('content')

<!-- Page -->
<div class="page">	
	<div class="page-header">
	    <h1 class="page-title">의사 관리하기</h1>
		<p class="m-b-0">디비몬에 등록되어있는 의사를 확인하고 추가, 수정, 삭제작업을 진행하실 수 있습니다.</p>
	    <ol class="breadcrumb breadcrumb-arrow">
		    <li class="breadcrumb-item"><a href="/" target="_blank">Korea Medical Hub</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/">관리자 홈</a></li>        
            <li class="breadcrumb-item active">병원 관리</li>        
		</ol>
		<!--div class="page-header-actions">
            <a href="/dbmon/clinic/add?returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}" class="btn btn-sm btn-icon btn-primary btn-round waves-effect" data-toggle="tooltip" data-original-name="Add">
                <i class="icon wb-pencil" aria-hidden="true"></i> 새로 등록
            </a>
        </div-->
	</div>

	

	<div class="page-content container-fluid">

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

		<form autocomplete="off" name="form_search" method="GET" action="/dbmon/doctor"  >
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">검색 조건</h3>				
				</div>
				<div class="panel-body">
					<div class="row">						
						<div class=" col-lg-3 col-md-6 form-group">
							<div class="checkbox-custom checkbox-primary ">
								<input type="checkbox" name="is_main_baner" value="1" @if($is_main_baner) checked="checked" @endif/>
								<label for="inputUnchecked" style="padding-right:40px;padding-bottom:10px;">메인 배너</label>
							</div>
						</div>	
						<div class=" col-lg-3 col-md-6 form-group">
							<div class="checkbox-custom checkbox-primary ">
								<input type="checkbox" name="is_sub_baner" value="1" @if($is_sub_baner) checked="checked" @endif/>
								<label for="inputUnchecked" style="padding-right:40px;padding-bottom:10px;">서브 배너</label>
							</div>
						</div>	
					</div>
					<div class="row">
						<div class=" col-lg-4 col-md-6 col-sm-12 form-group">
							<select class="form-control" name="specialty_id" >
								<option value="">전문의 선택</option>
								@foreach($specialtyData as $Data) 
								<option value="{{$Data->id}}" @if($specialty_id == $Data->id) selected="selected" @endif >{{$Data->name}}</option>
								@endforeach
								
							</select>
							
						</div>
						<div class=" col-lg-4 col-md-6 col-sm-12 form-group">
							<select class="form-control" name="medical_subject_id" >
								<option value="">진료과목 선택</option>
								@foreach($medicalSubjectData as $Data) 
								<option value="{{$Data->id}}" @if($medical_subject_id == $Data->id) selected="selected" @endif >{{$Data->gov_name}}</option>
								@endforeach
							</select>
							
						</div>
						<div class=" col-lg-4 col-md-6 col-sm-12 form-group">
							<select class="form-control" name="education_id" >
								<option value="">학력 선택</option>
								@foreach($educationData as $Data) 
								<option value="{{$Data->id}}" @if($education_id == $Data->id) selected="selected" @endif>{{$Data->school_name}}</option>
								@endforeach								
							</select>
							
						</div>
					</div>
					<div class="row">
						<div class=" col-lg-4 col-md-6 col-sm-6 form-group">		
							<select class="form-control" name="search" >
								<option value="">선택</option>
								<option value="clinic" @if($search == "clinic") selected="selected" @endif>병원명</option>
								<option value="first_name_kr" @if($search == "first_name_kr") selected="selected" @endif>이름(한글)</option>
								<option value="first_name_en" @if($search == "first_name_en") selected="selected" @endif>이름(영문)</option>
								<option value="phone" @if($search == "phone") selected="selected" @endif>전화번호</option>
								<option value="email" @if($search == "email") selected="selected" @endif>이메일</option>
								<option value="memo" @if($search == "memo") selected="selected" @endif>메모</option>
							</select>
						</div>
						<div class=" col-lg-4 col-md-6 col-sm-6 form-group">		
							<input type="text" class="form-control" name="keyword" value="{{$keyword}}">
						</div>
						<div class=" col-lg-2 col-md-4 col-sm-4 form-group">							
							<button type="submit"class="btn btn-primary btn-block">검색</button>
						</div>
					</div>
				</div>
			</div>

		</form>
			
		<div class="panel">
		
			<div class="panel-heading">
				<h3 class="panel-title">의사 리스트 ({{number_format( $DoctorData->total()   )}}건)</h3>			
			</div>

			<div class="panel-body">
				<form name="form_list"  method="post" >	
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="returnurl" value="{{ $_SERVER['REQUEST_URI'] }}" />
				<input type="hidden" name="area" value="" />
				<input type="hidden" name="gubun" value="" />	
				<table class="table table-hover">
					<thead>
					<tr>
						<th><input type="checkbox" id="checkall" /></th>
						<th>#</th>
						<th>병원</th>
						<th>사진</th>
						<th>이름</th>
						<th>전문의</th>
						<th>진료과목</th>
						<th>학교</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
						<?php $_i=0 ?>
						@foreach($DoctorData as $data)
						<?php
							$clinic_name = DB::table('kmh_clinic')->where('id', $data->clinic_id)->value('name');


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


							$is_main_banner =  DB::table('kmh_banner')->where('b_id',$data->id)->where('area','1')->where('gubun','3')->count('id');

							$is_sub_banner =  DB::table('kmh_banner')->where('b_id',$data->id)->where('area','2')->where('gubun','3')->count('id');
						?>
						<tr>
							<td><input type="checkbox"  class="chk" name="id[]" value="{{$data->id}}"/></td>
							<td>{{$DoctorData->total() - ( ( ($DoctorData->currentPage() - 1) * $DoctorData->perPage()) + $_i ) }}</td>
							<td><a href="/dbmon/clinic/doctor?id={{$data->clinic_id}}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}">{{$clinic_name}}</a></td>
							<td><img src="{{$img}}" width="50" /></td>
							<td>@if($is_main_banner)<span class="btn btn-xs btn-info">메인 베너</span> @endif @if($is_sub_banner)<span class="btn btn-xs btn-info">서브 베너</span> @endif {{$data->first_name_kr}} {{$data->last_name_kr}}</td>
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
				<div class="row">
					<div class="col-md-12 text-right">
						{!! $DoctorData->appends(['is_main_baner' => $is_main_baner])->appends(['is_sub_baner' => $is_sub_baner])->appends(['search' => $search])->appends(['keyword' => $keyword])->links('vendor.pagination.bootstrap-4') !!}
					</div>
				</div>
				<hr>
				<div class="row ">
					<div class="col-12 ">						
						<button type="button" class="btn btn-danger" onclick="fuDoctorDel('id[]')">삭제</button>			
						<button type="button" class="btn btn-info" onclick="fuBannerAdd(1,3,'id[]')">메인 베너 등록</button>	
						<button type="button" class="btn btn-info" onclick="fuBannerAdd(2,3,'id[]')">서브 베너 등록</button>	
					</div>
				</div>
				</form>
				
				<!-- <div class="row">
					<div class="col-md-12 text-right">
						<h5 >전체 데이터 수 : 2851 | 현재 페이지 : 57(최대 58) | 페이지당 노출 개수 50 </h5>
					</div>
				</div> -->
			</div>
			
		</div>
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
		document.form_list.action="/dbmon/del/doctor";
		document.form_list.submit();
	}	
}


function fuBannerAdd(area,gubun,obj) {

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
		alert("등록 할 병원을 선택해 주세요");
		return false;
	}

	if (confirm('정말 등록 하시겠습니까?    '))
	{
		document.form_list.area.value = area;
		document.form_list.gubun.value = gubun;

		
		document.form_list.action="/dbmon/add/banner";
		document.form_list.submit();
		
	}	

}

</script>

@stop