@extends('dbmon_layouts.master')
@section('content')

<!-- Page -->
<div class="page">	
	<div class="page-header">
	    <h1 class="page-title">블로그 관리하기</h1>
		<p class="m-b-0">디비몬에 등록되어있는 블로그를 확인하고 추가, 수정, 삭제작업을 진행하실 수 있습니다.</p>
	    <ol class="breadcrumb breadcrumb-arrow">
		    <li class="breadcrumb-item"><a href="/" target="_blank">Korea Medical Hub</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/">관리자 홈</a></li>        
            <li class="breadcrumb-item active">블로그 관리</li>        
		</ol>
		<div class="page-header-actions">
            <a href="/dbmon/blogAdd?returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}" class="btn btn-sm btn-icon btn-primary btn-round waves-effect" data-toggle="tooltip" data-original-name="Add">
                <i class="icon wb-pencil" aria-hidden="true"></i> 새로 등록
            </a>
        </div>
	</div>

	

	<div class="page-content container-fluid">

		@if(Session::has('success'))
		<div class="alert  alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ Session::get('success') }}
		</div>
		@endif
		@if(Session::has('danger'))
		<div class="alert  alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			{{ Session::get('danger') }}
		</div>
		@endif

		<form autocomplete="off" name="form_search" method="GET" action="/dbmon/blog"  >
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">검색 조건</h3>				
				</div>
				<div class="panel-body">			
					<div class="row">
						<div class=" col-lg-3 col-md-12 col-sm-12 form-group">
							<div class="input-daterange" data-plugin="datepicker">
								<div class="input-group">
								  <span class="input-group-addon">
									<i class="icon wb-calendar" aria-hidden="true"></i>
								  </span>
								  <input type="text" class="form-control" name="s_date" value="{{ $s_date }}"/>
								</div>
								<div class="input-group">
								  <span class="input-group-addon">to</span>
								  <input type="text" class="form-control" name="e_date" value="{{ $e_date }}"/>
								</div>
							  </div>
						</div>
						<div class=" col-lg-2 col-md-6 col-sm-6 form-group">		
							<select class="form-control" name="search" >
								<option value="">선택</option>
								<option value="title" @if($search == "title") selected="selected" @endif>제목</option>
								<option value="userid" @if($search == "userid") selected="selected" @endif>글쓴이</option>
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
				<h3 class="panel-title">블로그 리스트 ({{number_format( $BlogData->total()   )}}건)</h3>			
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
						<th>이미지</th>
						<th>제목</th>
						<th>글쓴이</th>
						<th>조회수</th>
						<th>Update</th>
						<th>관리</th>
					</tr>
					</thead>
					<tbody>
						<?php $_i=0 ?>
						@foreach($BlogData as $data)
						<?php
							


							// 블로그 대표 이미지						
							$blog_img = DB::table('kmh_media')->where('of','BLOG')->where('of_id',$data->id)->value('path');

							

							$user_name = DB::table('users')->where('id', $data->userid)->value('name');

						?>
						<tr>
							<td><input type="checkbox"  class="chk" name="id[]" value="{{$data->id}}"/></td>
							<td>{{$BlogData->total() - ( ( ($BlogData->currentPage() - 1) * $BlogData->perPage()) + $_i ) }}</td>
							<td><a  href="/dbmon/blogMod?uid={{$data->id}}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}"><img src="{{ $blog_img }}" height="50"/></a></td>
							<td>{{$data->title}}</td>
							<td>{{$user_name}}</td>
							<td>{{number_format($data->hit)}}</td>
							<td>{{$data->d_upis}}</td>
							<td>
								<a href="/dbmon/blogMod?id={{$data->id}}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}" class="btn btn-info btn-xs">수정</a>
							</td>
						</tr>
						<?php $_i++; ?>
						@endforeach
					</tbody>
				</table>
				<div class="row">
					<div class="col-md-12 text-right">
						{!! $BlogData->appends(['s_date' => $s_date])->appends(['e_date' => $e_date])->appends(['search' => $search])->appends(['keyword' => $keyword])->links('vendor.pagination.bootstrap-4') !!}
					</div>
				</div>
				<hr>
				<div class="row ">
					<div class="col-12 ">						
						<button type="button" class="btn btn-danger" onclick="fuBlogDel('id[]')">삭제</button>				
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


function fuBlogDel(obj) {
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
		alert("삭제 할 블로그 선택해 주세요");
		return false;
	}

	if (confirm('정말 삭제 하시겠습니까?    '))
	{
		document.form_list.action="/dbmon/del/blog";
		document.form_list.submit();
	}	
}


</script>

@stop