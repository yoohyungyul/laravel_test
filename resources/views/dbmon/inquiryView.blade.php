@extends('dbmon_layouts.master')
@section('content')
<link href="/front/css/jquery.fancybox.min.css" rel="stylesheet" />
<?php
	$inquiry_img = DB::table('kmh_media')->where('of','INQUIRY')->where('of_id',$id)->orderBy('id', 'desc')->orderBy('id','desc')->get();

	$body_part_name = "";
	if($InquiryData->body_part_id) {
		$body_part_name = DB::table('kmh_procedure_info')->where('id',$InquiryData->body_part_id)->value('name_en');
	}

	$procedure_info_name = "";
	if($InquiryData->procedure_info_id) {
		$procedure_info_name = DB::table('kmh_procedure_info')->where('id',$InquiryData->procedure_info_id)->value('name_en');
	}

	$gender = "";
	if($InquiryData->gender == "1") $gender = "Male";
	if($InquiryData->gender == "2") $gender = "Female";

?>


<!-- Page -->
<div class="page">
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/dbmon">관리자홈</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/inquiry/clinic">병원 상담 관리하기</a></li>
		</ol>
		<h1 class="page-title">상담 정보</h1>
	</div>
	<div class="page-content container-fluid" >
		

		<div class="panel">
			<div class="panel-heading">
              <h3 class="panel-title">{{ $InquiryData->title  }}</h3>
			  <hr>
            </div>

			<div class="panel-body container-fluid">

				@if($body_part_name or $procedure_info_name)
				<p style="color:#48a0dc">
					<strong>#{{$body_part_name}} @if($procedure_info_name) ▶ #{{$procedure_info_name}} @endif</strong>
				</p>
				
				@endif
				<h3>{{$InquiryData->name_en}}</h3>
				<p >Name : {{$InquiryData->name}} | Email : {{$InquiryData->email}} @if($InquiryData->birthday)| Date of Birth : {{$InquiryData->birthday}}@endif @if($InquiryData->gender)| Gender : {{$gender}}@endif</p>
				<div class="clear"></div>
				<hr>


				<p><?php echo str_replace(chr(13),'<br />',$InquiryData->content) ?></p>
					@if(count($inquiry_img) > 0)
					<div style="margin-top:10px">	
						@foreach($inquiry_img as $img)
							<figure>
								<figcaption>
									<a class="fancybox" rel="group_top_{{$InquiryData->id}}" href="{{$img->path}}" ><img src="{{$img->path}}" alt="{{$img->path}}" width="100" ></a>
								</figcaption>
							</figure>
							<!-- <img src="{{$img->path}}" width="100"/> -->
						@endforeach
					</div>
					@endif
				
				<div class="row row-lg">
					<div class="col-xl-12">	

						
					</div>
						
				</div>
			</div>
		</div>
		<a id="message"></a>
		<div class="panel">
			<div class="panel-heading">
              <h3 class="panel-title">메시지</h3>
			  <hr>
            </div>
			<div class="panel-body container-fluid">
				
				@foreach($messageData as $data)

				<?php

			
					$diff = time() - strtotime($data->d_regis); 

					if ( $diff>86400 ) { 
						$date = ceil($diff/86400).'일 전에 작성했습니다'; 
					} else if ( $diff>3600 ) { 
						$date =  ceil($diff/3600).'시간 전에 작성했습니다'; 
					} else if ( $diff>60 ) { 
						$date =  ceil($diff/60).'분 전에 작성했습니다'; 
					} else { 
						$date =  $diff.'초 전에 작성했습니다'; 
					} 

					$inquiry_message_img = DB::table('kmh_media')->where('of','INQUIRY_MESSAGE')->where('of_id',$data->id)->orderBy('id', 'desc')->orderBy('id','desc')->get();

					$memData = DB::table('users')->select('name','level','clinic_id')->where('id',$data->user_id)->first();

					// 병원 아이디이면
					if($memData->level == "3") {
						$name = DB::table('kmh_clinic')->where('id',$memData->clinic_id)->value('name_en');
					} else {
						$name = $memData->name;
					}

					$is_confirm = $data->is_confirm;

				
				?>


				<div class="comment">
					<div class="row">
						<div class="col-lg-12">
							<div class="comment-text">
								<h5>@if(!$is_confirm)<small style="color:#d9534f"><strong>New</strong></small> @endif{{$name}} @if(Auth::user()->id == $data->user_id)<span class="pull-right"><button type="button" class="btn btn-xs btn-danger" onclick="fnMessageDel({{$data->id}})">Del</button></span>@endif</h5>
								<div><?php echo str_replace(chr(13),'<br />',$data->message) ?></div>
								
								@if(count($inquiry_message_img) > 0 )
								<div style="margin-top:10px">
									@foreach($inquiry_message_img as $img)
									<figure>
										<figcaption>
											<a class="fancybox" rel="group_{{$data->id}}" href="{{$img->path}}" ><img src="{{$img->path}}" alt="{{$img->path}}" width="100" ></a>
										</figcaption>
									</figure>
									<!-- <img src="{{$img->path}}" width="100"/> -->
									@endforeach
								</div>
								@endif
								
								<div class="right"><i class="fa fa-clock-o icon"></i><small>{{$date}}</small></div>
								<div class="clear"></div>
							</div>							
						</div>
					</div>
				</div>
				@endforeach	
			</div>
		</div>
		<div class="panel">
			<div class="panel-heading">
              <h3 class="panel-title">댓글 작성</h3>
			  <hr>
            </div>
			<div class="panel-body container-fluid">
				<form autocomplete="off" method="POST" onsubmit="return r_writeCheck(this);" action="/add/inquiry-message"  enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="id" value="{{ $id }}" />
				<input type="hidden" name="clinic_id" value="{{ $InquiryData->clinic_id }}" />
				<input type="hidden" name="returnurl" value="{{ $_SERVER['REQUEST_URI'] }}" />

				<div class="form-group " >
					<label class="form-control-label" for="inputText">내용</label>
					<div class="row">
						<div class="col-xl-12">
							<div class="form-group  " >
								<textarea class="form-control" name="message" rows="5"></textarea>	
							</div>
						</div>
					</div>
				</div>

				<div class="form-group  pt-10" >
					<label class="form-control-label" for="inputText">파일</label>
					<div class="form-group  row">                                
						<div class="col-xs-6 col-md-3">
							<input type="file" data-plugin="dropify" data-default-file="" name="files[]"/>
						</div>
						<div class="col-xs-6 col-md-3">
							<input type="file" data-plugin="dropify" data-default-file="" name="files[]"/>
						</div>
						<div class="col-xs-6 col-md-3">
							<input type="file" data-plugin="dropify" data-default-file="" name="files[]"/>
						</div>
						<div class="col-xs-6 col-md-3">
							<input type="file" data-plugin="dropify" data-default-file="" name="files[]"/>
						</div>
					</div>							
				</div>
				<div class="row">
					<div class="col-6"><a href="{{ $returnurl }}" class="btn  btn-default">돌아가기</a></div>
					<div class="col-6 text-right"><button type="submit" class="btn  btn-success">등록하기</button></div>
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

<script src="/front/js/jquery.fancybox.js"></script>

<script>

jQuery(document).ready(function(){
  jQuery(".fancybox").fancybox();
});


(function(document, window, $) {
'use strict';
var Site = window.Site;
$(document).ready(function() {
  Site.run();
});
})(document, window, jQuery);


function r_writeCheck(f) {

		if (f.message && f.message.value == '') {
			alert("내용을 입력해 주세요. ");
			f.message.focus();
			return false;
		}

		if (confirm('정말 수정 하시겠습니까    '))
		{
			return true;
		}
		return false;
	}

	function fnMessageDel(id) {

	if (confirm('정말 삭제 하시겠습니까    '))
	{
		var url  = "/del/inquiry-message?id="+ id + "&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";
		location.href = url;
	}
	return false;
}

</script>

@stop