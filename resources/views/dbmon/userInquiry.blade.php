@extends('dbmon_layouts.master')
@section('content')

<!-- Page -->
<div class="page">
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/dbmon">관리자홈</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/user">회원리스트</a></li>
			<li class="breadcrumb-item active">{{ $userData->name }}</li>
		</ol>
		<h1 class="page-title">회원 상담 정보</h1>
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
						<div class="nav-tabs-horizontal" data-plugin="tabs">
							<ul class="nav nav-tabs" >
								<li class="nav-item" ><a class="nav-link @if(strpos($_SERVER['REQUEST_URI'],'dbmon/user/view?') == '1' ) active @endif"  href="/dbmon/user/view?id={{$id}}&returnurl={{ urlencode(urldecode($returnurl)) }}" >정보수정</a></li>
								<li class="nav-item" ><a class="nav-link @if(strpos($_SERVER['REQUEST_URI'],'dbmon/user/inquiry') == '1' ) active @endif"  href="/dbmon/user/inquiry?id={{$id}}&returnurl={{ urlencode(urldecode($returnurl)) }}" >상담정보</a></li>
								
							</ul>
						</div>               
					</div>
				</div>		

				<div class="row row-lg pt-30">
					<div class="col-xl-12">   

						<form name="form_list"  method="post" >	
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="returnurl" value="{{ $_SERVER['REQUEST_URI'] }}" />
						<table class="table table-hover">
							<thead>
							<tr>
								<th><input type="checkbox" id="checkall" /></th>
								<th>#</th>
								<th>병원</th>
								<th>구분</th>
								<th>제목</th>
								<th>등록인</th>
								<th>등록일</th>
								<th>관리</th>
							</tr>
							</thead>
							<tbody>
								<?php $_i=0 ?>
								@foreach($InquiryData as $Data)
								<?php
									
									$clinic_name = DB::table('kmh_clinic')->where('id',$Data->clinic_id)->value('name');
									$user_name = DB::table('users')->where('id',$Data->user_id)->value('name');

									$messageCount = DB::table('kmh_inquiry_message')->where('inquiry_id',$Data->id)->count('id');


									$body_part_name = DB::table('kmh_procedure_info')->where('id',$Data->body_part_id)->value('name_en');
									$procedure_info_name = DB::table('kmh_procedure_info')->where('id',$Data->procedure_info_id)->value('name_en');

								?>
								<tr>
									<td><input type="checkbox"  class="chk" name="id[]" value="{{$Data->id}}"/></td>
									<td>{{$InquiryData->total() - ( ( ($InquiryData->currentPage() - 1) * $InquiryData->perPage()) + $_i ) }}</td>
									<td>{{ $clinic_name }}</td>
									<td> {{$body_part_name}} @if($procedure_info_name)- {{$procedure_info_name}}@endif </td>
									<td>{{ $Data->title }}</td>
									<td>{{$user_name}}</td>
									<td>{{ $Data->d_regis }}</td>
									<td>
										<a href="/dbmon/inquiry/clinic/view?id={{$Data->id}}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}" class="btn btn-primary btn-xs waves-effect waves-effect">상담 보기</a>
										<a href="/dbmon/inquiry/clinic/view?id={{$Data->id}}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}#message" class="btn btn-danger btn-xs waves-effect waves-effect">{{$messageCount}} 메시지</a>
									</td>
								</tr>						
								<?php $_i++; ?>
								@endforeach
							</tbody>
						</table>
						<div class="row">
							<div class="col-md-12 text-right">
								{!! $InquiryData->links('vendor.pagination.bootstrap-4') !!}
							</div>
						</div>
						<hr>
						<div class="row ">
							<div class="col-12 ">						
								<button type="button" class="btn btn-danger" onclick="fuInquiryDel('id[]')">삭제</button>	
								<a class="btn  btn-default" href="{{ $returnurl }}">돌아가기</a>
							</div>
						</div>
						</form>
					</div>
				</div>
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


function fuInquiryDel(obj) {
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
		alert("삭제 할 상담을 선택해 주세요");
		return false;
	}

	if (confirm('정말 삭제 하시겠습니까?    '))
	{
		document.form_list.action="/dbmon/del/inquiry";
		document.form_list.submit();
	}	
}
</script>

@stop