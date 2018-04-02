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
		<h1 class="page-title">전후사진</h1>
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
				<form name="form_list"  method="get" >	
				<input type="hidden" name="returnurl" value="{{ $_SERVER['REQUEST_URI'] }}" />
				<div class="row row-lg">
					<div class="col-xl-12">   
						<h4 class="pt-30">전후사진 리스트</h4>
						<table class="table table-hover">
							<thead>
							<tr>
								<th><input type="checkbox" id="checkall" /></th>
								<th>#</th>
								<th>대표시술명</th>
								<th>사진</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
								<?php $_i=0; ?>
								@foreach($ClinicBeforeAfterData as $data)

								<?php
									$previous_img  = DB::table('kmh_media')->where('id', $data->previous_media_id)->value('path');
									$after_img  = DB::table('kmh_media')->where('id', $data->after_media_id)->value('path');

									

								?>
								
								<tr>
									<td><input type="checkbox"  class="chk" name="id[]" value="{{$data->id}}"/></td>
									<td>{{$ClinicBeforeAfterData->total() - ( ( ($ClinicBeforeAfterData->currentPage() - 1) * $ClinicBeforeAfterData->perPage()) + $_i ) }}</td>
									<td>{{$data->title}}</td>
									<td><img src="{{$previous_img}} " height="80" /> <img src="{{$after_img}}"  height="80"/></td>
									<td>
										<button type="button" class="btn btn-info btn-xs" onclick="fuBeforeAfterMod({{ $data->id }})">수정</button>
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
						{!! $ClinicBeforeAfterData->render() !!}
					</div>
				</div>
				<div class="row row-lg">
					<div class="col-6 ">						
						<button type="button" class="btn btn-danger" onclick="fuBeforeAfterDel('id[]')">삭제</button>
						<button type="button" class="btn btn-info" onclick="fuBeforeAfterAdd()">+ 추가</buttoN>
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

function fuBeforeAfterAdd() {

  url = "/modal/beforeafter/add?id={{ $id }}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";
	
	$("#Modal_fade .modal-content").load(url, function() { 
		 $("#Modal_fade").modal("show"); 
	});
}

function fuBeforeAfterMod(beforeafter_id) {
	

    url = "/modal/beforeafter/mod?beforeafter_id="+beforeafter_id+"&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";
	
	$("#Modal_fade .modal-content").load(url, function() { 
		 $("#Modal_fade").modal("show"); 
	});
}

function fuBeforeAfterDel(obj) {
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
		alert("삭제 할 전후사진을 선택해 주세요");
		return false;
	}

	if (confirm('정말 삭제 하시겠습니까?    '))
	{
		document.form_list.action="/dbmon/del/beforeafter";
		document.form_list.submit();
	}	
}
</script>

@stop