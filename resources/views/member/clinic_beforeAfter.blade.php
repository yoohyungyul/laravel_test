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
								<td><img src="{{$previous_img}} " width="80" /> <img src="{{$after_img}}"  width="80"/></td>
								<td>
									<button type="button" class="btn btn-info btn-xs" onclick="fuBeforeAfterMod({{ $data->id }})">수정</button>
								</td>
							</tr>
							<?php $_i++; ?>
							@endforeach
						</tbody>
					</table>
					<div class="row ">
						<div class="col-lg-12 ">
							{!! $ClinicBeforeAfterData->render() !!}
						</div>
					</div>
					<div class="row ">
						<div class="col-lg-12 ">						
							<button type="button" class="btn btn-danger" onclick="fuBeforeAfterDel('id[]')">삭제</button>
							<button type="button" class="btn btn-info" onclick="fuBeforeAfterAdd()">+ 추가</buttoN>
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


function fuBeforeAfterAdd() {

  url = "/modal/user_beforeafter/add?id={{ Auth::user()->clinic_id }}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";
	
	$("#Modal .modal-content").load(url, function() { 
		 $("#Modal").modal("show"); 
	});
}

function fuBeforeAfterMod(beforeafter_id) {
	

    url = "/modal/user_beforeafter/mod?beforeafter_id="+beforeafter_id+"&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";
	
	$("#Modal .modal-content").load(url, function() { 
		 $("#Modal").modal("show"); 
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
		document.form_list.action="/member/del/beforeAfter";
		document.form_list.submit();
	}	
}



</script>

@stop