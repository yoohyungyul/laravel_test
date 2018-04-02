@extends('dbmon_layouts.master')
@section('content')

<!-- Page -->
<div class="page">	
	<div class="page-header">
	    <h1 class="page-title">사이트 상담 관리하기</h1>
		<p class="m-b-0">디비몬에 등록되어있는 사이트 문의를 확인하고 추가, 수정, 삭제작업을 진행하실 수 있습니다.</p>
	    <ol class="breadcrumb breadcrumb-arrow">
		    <li class="breadcrumb-item"><a href="/" target="_blank">Korea Medical Hub</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/">관리자 홈</a></li>        
            <li class="breadcrumb-item active">사이트문의 관리</li>        
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
				<h3 class="panel-title">상담 리스트 ({{number_format( $ContactData->total()   )}}건)</h3>
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
						<th>제목</th>
						<th>글쓴이</th>
						<th>이메일</th>
						<th>등록일</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
						<?php $_i=0 ?>
						@foreach($ContactData as $Data)
						
						<tr>
							<td><input type="checkbox"  class="chk" name="id[]" value="{{$Data->id}}"/></td>
							<td>{{$ContactData->total() - ( ( ($ContactData->currentPage() - 1) * $ContactData->perPage()) + $_i ) }}</td>
							<td>{{$Data->subject}}</td>
							<td>{{$Data->name}}</td>
							<td><a href="mailto:{{$Data->email}}">{{$Data->email}}</a></td>
							<td>{{$Data->d_regis}}</td>
							<td>
								<button type="button" class="btn btn-primary btn-xs waves-effect waves-effect" onclick="fuContactView({{$Data->id}})">상담 보기</button>
							</td>
						</tr>						
						<?php $_i++; ?>
						@endforeach
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12 text-right">
						{!! $ContactData->links('vendor.pagination.bootstrap-4') !!}
					</div>
				</div>
				<hr>
				<div class="row ">
					<div class="col-12 ">						
						<button type="button" class="btn btn-danger" onclick="fuContactDel('id[]')">삭제</button>			
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


function fuContactDel(obj) {
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
		document.form_list.action="/dbmon/del/contact";
		document.form_list.submit();
	}	
}



function fuContactView(id) {
	

    url = "/modal/contact/view?id="+id;
	
	$("#Modal_fade .modal-content").load(url, function() { 
		 $("#Modal_fade").modal("show"); 
	});
}

</script>

@stop