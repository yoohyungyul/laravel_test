@extends('dbmon_layouts.master')
@section('content')

<!-- Page -->
<div class="page">	
	<div class="page-header">
	    <h1 class="page-title">병원 관리자 신청</h1>
		<p class="m-b-0">디비몬에 등록되어있는 병원 관리자 신청 리스트를 확인하실 수 있습니다.</p>
	    <ol class="breadcrumb breadcrumb-arrow">
		    <li class="breadcrumb-item"><a href="/" target="_blank">Korea Medical Hub</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/">관리자 홈</a></li>        
            <li class="breadcrumb-item active">병원 관리자 신청</li>        
		</ol>
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

		
			
		<div class="panel">
		
			<div class="panel-heading">
				<h3 class="panel-title">관리자 신청 리스트 ({{number_format( $clinicAdminData->total()   )}}건)</h3>
				<!-- <div class="panel-actions">
					<button type="button" data-toggle="modal" data-target="#clinic-search-modal" class="btn btn-xs btn-primary waves-effect">상세 검색</button>
				</div> -->
			</div>

			<div class="panel-body">
				<form name="form_list"  method="post" >	
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="returnurl" value="{{ $_SERVER['REQUEST_URI'] }}" />
				<table class="table table-hover">
					<thead>
					<tr>
						<th><input type="checkbox" id="checkall" /></th>
						<th>#</th>
						<th>병원</th>
						<th>신청 회원</th>
						<th>등록일</th>
					</tr>
					</thead>
					<tbody>
						<?php $_i=0 ?>
						@foreach($clinicAdminData as $Data)

						<?php
							$clinic_name = DB::table('kmh_clinic')->where('id', $Data->clinic_id)->value('name');
							$user_name = DB::table('users')->where('id', $Data->user_id)->value('name');


						?>
						
						<tr>
							<td><input type="checkbox"  class="chk" name="id[]" value="{{$Data->id}}"/></td>
							<td>{{$clinicAdminData->total() - ( ( ($clinicAdminData->currentPage() - 1) * $clinicAdminData->perPage()) + $_i ) }}</td>							
							<td><a href="/dbmon/clinic/view?id={{$Data->clinic_id}}" target="_blank">{{$clinic_name}}</a></td>
							<td><a href="/dbmon/user/view?id={{$Data->user_id}}" target="_blank">{{$user_name}}</a></td>
							<td>{{$Data->d_regis}}</td>
							
						</tr>						
						<?php $_i++; ?>
						@endforeach
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12 text-right">
						{!! $clinicAdminData->links('vendor.pagination.bootstrap-4') !!}
					</div>
				</div>
				<hr>
				<div class="row ">
					<div class="col-12 ">						
						<button type="button" class="btn btn-danger" onclick="fuClinicAdminDel('id[]')">삭제</button>			
						<button type="button" class="btn btn-primary" onclick="fuClinicAdminApp('id[]')">승인</button>			
					</div>
				</div>
				</form>
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


function fuClinicAdminDel(obj) {
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
		alert("삭제 할 회원을 선택해 주세요");
		return false;
	}

	if (confirm('정말 삭제 하시겠습니까?    '))
	{
		document.form_list.action="/dbmon/del/clinicAdminApp";
		document.form_list.submit();
	}	
}


function fuClinicAdminApp(obj) {
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
		alert("승인 할 회원을 선택해 주세요");
		return false;
	}

	if (confirm('정말 승인 하시겠습니까?    '))
	{
		document.form_list.action="/dbmon/app/clinicAdmin";
		document.form_list.submit();
	}	
}

</script>

@stop