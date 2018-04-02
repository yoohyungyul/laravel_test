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
		<h1 class="page-title">병원 간호등급</h1>
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
				<form name="form_nursing"  method="get" >	
				<input type="hidden" name="returnurl" value="{{ $_SERVER['REQUEST_URI'] }}" />
				<div class="row row-lg">
					<div class="col-xl-12">   
						<h4 class="pt-30">간호등급 리스트</h4>
						<table class="table table-hover">
							<thead>
							<tr>
								<th><input type="checkbox" id="checkall" /></th>
								<th>#</th>
								<th>간호등급 항목</th>
								<th>등급</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
								<?php $_i=0; ?>
								@foreach($ClinicNursingData as $data)
								<?php 
									$nursing_name = DB::table('kmh_nursing_grade')->where('id', $data->nursing_grade_id)->value('gov_name');

								?>
								<tr>
									<td><input class="chk" type="checkbox" name="id[]" value="{{$data->id}}"/></td>
									<td>{{$ClinicNursingData->total() - ( ( ($ClinicNursingData->currentPage() - 1) * $ClinicNursingData->perPage()) + $_i ) }}</td>
									<td>{{$nursing_name}}</td>
									<td>{{$data->grade}}</td>
									<td>
										<button type="button" class="btn btn-info btn-xs" onclick="fuNursingMod({{ $data->id }})">수정</button>
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
						{!! $ClinicNursingData->render() !!}
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-6 ">						
						<button type="button" class="btn btn-danger" onclick="fuNursingDel('id[]')">삭제</button>
						<button type="button" class="btn btn-info" onclick="fuNursingAdd()">+ 추가</buttoN>						
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

function fuNursingAdd() {

	url = "/modal/nursing/add?id={{ $id }}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";
	
	$("#Modal_fade .modal-content").load(url, function() { 
		 $("#Modal_fade").modal("show"); 
	});
}

function fuNursingMod(nursing_id) {

	 url = "/modal/nursing/mod?nursing_id="+nursing_id+"&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";
	
	$("#Modal_fade .modal-content").load(url, function() { 
		 $("#Modal_fade").modal("show"); 
	});
}

function fuNursingDel(obj) {
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
		alert("삭제 할 간호등급을 선택해 주세요");
		return false;
	}

	if (confirm('정말 삭제 하시겠습니까?    '))
	{
		document.form_nursing.action="/dbmon/del/nursing";
		document.form_nursing.submit();
	}	
}





</script>

@stop