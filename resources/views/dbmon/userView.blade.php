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
		<h1 class="page-title">회원 정보</h1>
	</div>
	<div class="page-content container-fluid" >
		<form autocomplete="off" name="form_add"  method="POST" onsubmit="return r_writeCheck(this);" action="/dbmon/mod/user"  enctype="multipart/form-data" >
		<input type="hidden" name="id" value="{{ $id }}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="returnurl" value="{{ $returnurl }}">
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
				<div class="row row-lg">
					<div class="col-xl-12 pt-20">  
						<div class="form-group" >
							<label class="form-control-label" for="inputText">시술 사진</label>
							<div class="form-group  row">                                
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="photo"/>
                                </div>
                            </div>
							<ul>
								@if($userData->photo)
								<li><a href="{{$userData->photo}}" target="_blank">{{$userData->photo}}</a> </li>
								@endif
							</ul>
						</div>
						<div class="form-group pt-30" >
							<label class="form-control-label" for="inputText">회원 등급 <small>(1: 관리자, 2:부관리자, 3:병원관리자, 4:일반회원)</small></label>
							<div class="row">
								<div class="col-xl-2">
									<div class="form-group  " >
										<select class="form-control" name="level">
											<option value="1" @if($userData->level == "1") selected="selected" @endif >관리자</option>
											<option value="2" @if($userData->level == "2") selected="selected" @endif >부관리자</option>
											<option value="3" @if($userData->level == "3") selected="selected" @endif >병원관리자</option>
											<option value="4" @if($userData->level == "4") selected="selected" @endif >일반회원</option>
										</select>                                        
										
                                    </div>
								</div>								
							</div>
						</div>
						<div class="form-group " >
							
							<div class="row">
								
								<div class="col-xl-6">
									<label class="form-control-label" for="inputText">이메일</label>
									<div class="form-group  " >										
										<input type="email" class="form-control"  name="email" placeholder="이메일" value="{{$userData->email}}" readonly/>
									</div>
								</div>
								<div class="col-xl-6">			
									<label class="form-control-label" for="inputText">이름</label>
									<div class="form-group  " >										
                                        <input name="name" type="text" class="form-control"  placeholder="이름" value="{{$userData->name}}">   										
                                    </div>
								</div>
							</div>
						</div>
						<div class="form-group " >						
							<div class="row">
								<div class="col-xl-6">									
									<label class="form-control-label" for="inputText">성별</label>
									<div class="form-group  " >										
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="gender" type="radio" value="1" @if($userData->gender == "1") checked="checked" @endif>
                                            <label>남자</label>
                                        </div>
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="gender" type="radio" value="2" @if($userData->gender == "2") checked="checked" @endif>
                                            <label>여자</label>
                                        </div>							
                                    </div>
								</div>
								<div class="col-xl-6">
									<label class="form-control-label" for="inputText">생일</label>
									<div class="form-group  " >										
										<div class="input-group">
											<span class="input-group-addon">
											  <i class="icon wb-calendar" aria-hidden="true"></i>
											</span>
											<input type="text" name="birthday" class="form-control" data-plugin="datepicker" value="{{$userData->birthday}}">
										 </div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group " >						
							<div class="row">
								<div class="col-xl-6">									
									<label class="form-control-label" for="inputText">전화번호</label>
									<div class="form-group  " >										
                                        <input type="name" class="form-control"  name="tel" placeholder="전화번호" value="{{$userData->tel}}"/>	
                                    </div>
								</div>
								<div class="col-xl-6">
									<label class="form-control-label" for="inputText">국가</label>
									<div class="form-group  " >	
										<select class="form-control" name="country">
												<option value="">선택</option>
											@foreach($CountryData as $data)
												<option value="{{$data->group_value}}" @if($userData->country == $data->group_value) selected="selected" @endif>{{$data->group_str}}</option>
											@endforeach
										</select> 
										
									</div>
								</div>
							</div>
						</div>
						<div class="form-group " >						
							<div class="row">								
								<div class="col-xl-6">
									<label class="form-control-label" for="inputText">메신져</label>
									<div class="form-group  " >	
										<select class="form-control" name="messenger">
											<option value="">선택</option>
											@foreach($MessengerData as $data)
												<option value="{{$data->group_value}}" @if($userData->messenger == $data->group_value) selected="selected" @endif >{{$data->group_str}}</option>
											@endforeach
										</select> 
										
									</div>
								</div>
								<div class="col-xl-6">									
									<label class="form-control-label" for="inputText">아이디</label>
									<div class="form-group  " >										
                                        <input type="name" class="form-control"  name="messenger_id" placeholder="아이디" value="{{$userData->messenger_id}}"/>	
                                    </div>
								</div>
							</div>
						</div>
						<div class="form-group " >						
							<div class="row">
								<div class="col-xl-12">
									<label class="form-control-label" for="inputText">메모</label>
									<div class="form-group  " >
										<textarea class="form-control" name="memo">{{ $userData->memo }}</textarea>					
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-6"><a class="btn  btn-default" href="{{ $returnurl }}">돌아가기</a></div>
					<div class="col-6 text-right"><button type="submit" class="btn  btn-success">수정하기</button></div>
				</div>
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
<script src="/global/js/Plugin/bootstrap-datepicker.js"></script>
<script>
(function(document, window, $) {
'use strict';
var Site = window.Site;
$(document).ready(function() {
  Site.run();
});
})(document, window, jQuery);



function r_writeCheck(f) {

	if (f.name && f.name.value == '') {
		alert("이름을 입력해 주세요. ");
		f.name.focus();
		return false;
	}

	if (confirm('정말 수정 하시겠습니까    '))
	{
		return true;
	}
	return false;
}


</script>

@stop