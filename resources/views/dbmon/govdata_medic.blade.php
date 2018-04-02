@extends('dbmon_layouts.master')
@section('content')

<!-- Page -->
<div class="page">	
	<div class="page-header">
	    <h1 class="page-title">병원정보서비스</h1>
		<p class="m-b-0">병원정보서비스 심평원 공공데이터 확인이 가능합니다.</p>
	    <ol class="breadcrumb breadcrumb-arrow">
		    <li class="breadcrumb-item"><a href="/" target="_blank">Korea Medical Hub</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/">관리자 홈</a></li>        
            <li class="breadcrumb-item active">병원정보서비스</li>        
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
				<h3 class="panel-title">병원정보서비스</h3>			
			</div>

			<div class="panel-body">				
				<table class="table table-hover">
					<thead>
					<tr>
						<th>#</th>
						<th>병원명</th>
						<th>종별코드명</th>
						<th>시도/시군구/읍면동</th>
						<th>(우편번호)주소</th>
						<th>X, Y좌표</th>
					</tr>
					</thead>
					<tbody>
						<?php $_i=0 ?>
						@foreach($medicInsttData as $data)
						<tr>
							<td>{{$medicInsttData->total() - ( ( ($medicInsttData->currentPage() - 1) * $medicInsttData->perPage()) + $_i ) }}</td>
							<td>{{$data->yadm_nm}}</td>
							<td>{{$data->cl_cd_nm}}</td>
							<td>{{$data->sido_cd_nm}} / {{$data->sggu_cd_nm}}</td>
							<td>({{$data->post_no}}) {{$data->addr}}</td>
							<td>{{$data->x_pos}} {{$data->y_pos}}</td>
						</tr>
						<?php $_i++; ?>
						@endforeach
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12 text-right">
						{!! $medicInsttData->links('vendor.pagination.bootstrap-4') !!}
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

</script>

@stop