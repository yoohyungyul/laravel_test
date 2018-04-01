@extends('layouts.master')
@section('content')


<section class="subheader">
  <div class="container">
    <h1>{{$ClinicData->name_en}}</h1>
    <div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/mypage/clinic/view" class="current">Clinic</a></div>
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

			@include('member.clinic_top')	

			<div class="widget  ">
				<div class="widget-content box">		
					<form name="form_list"  method="get" >	
					<input type="hidden" name="returnurl" value="{{ $_SERVER['REQUEST_URI'] }}" />
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
						<tbody style="font-size:12px">
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
						if($specialty) $specialty = mb_substr($specialty,1,(mb_strlen($specialty) - 3) );


						// 진료과목
						$MedicalData = DB::table('kmh_clinic_doctor_medical_subject')		
							->select('gov_name')
							->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_doctor_medical_subject.medical_subject_id')		
							->where('doctor_id',$data->id)->get();

						$medical = "";
						foreach($MedicalData as $m_data) {
							$medical .= $m_data->gov_name.", ";
						}
						if($medical) $medical = mb_substr($medical,1,(mb_strlen($medical) - 3) );


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
					<div class="row ">
						<div class="col-lg-12t">
							{!! $ClinicDoctorData->render() !!}
						</div>
					</div>
					<div class="row row-lg">
						<div class="col-lg-12 ">						
							<button type="button" class="btn btn-danger" onclick="fuDoctorDel('id[]')">삭제</button>
							<button type="button" class="btn btn-info" onclick="fuDoctorAdd()">+ 등록</buttoN>	
						
						</div>
					</div>

					</form>
				</div>
			</div>

		</div><!-- end col -->
	</div><!-- end row -->

  </div><!-- end container -->
</section>





@include('layouts.footer')

@include('layouts.js')
<script>
$(document).ready(function() {


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


function fuDoctorAdd() {

  url = "/modal/user_doctor/add?id={{ Auth::user()->clinic_id }}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";

  
	
	$("#Modal .modal-content").load(url, function() { 
		 $("#Modal").modal("show"); 
	});
}



function fuDoctorMod(doctor_id) {	

    url = "/modal/user_doctor/mod?doctor_id="+doctor_id+"&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";
	
	$("#Modal .modal-content").load(url, function() { 
		 $("#Modal").modal("show"); 
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
		document.form_list.action="/member/del/doctor";
		document.form_list.submit();
	}	
}

</script>

@stop