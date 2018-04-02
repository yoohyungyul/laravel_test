@extends('dbmon_layouts.master')
@section('content')


<!-- Page -->
<div class="page">
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/dbmon">관리자홈</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/procedureInfo">시술 관리하기</a></li>
		</ol>
		<h1 class="page-title">{{$ProcedureData->name}} 시술 정보 수정</h1>
	</div>
	<div class="page-content container-fluid" >
		<form autocomplete="off" name="form_add"  method="POST" onsubmit="return r_writeCheck(this);" action="/dbmon/mod/procedure_info"  enctype="multipart/form-data" >
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="returnurl" value="{{ $returnurl }}">
		<input type="hidden" name="id" value="{{$ProcedureData->id}}">
		
		<div class="panel">
			<div class="panel-body container-fluid">
				
				<div class="row row-lg">
					<div class="col-xl-12">	
						<div class="form-group" >
							<label class="form-control-label" for="inputText">시술 사진</label>
							<div class="form-group  row">                                
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="img"/>
                                </div>
                            </div>		
							<ul>
								@if($ProcedureData->img)
								<li><input type="hidden" name="img_del" value="1" /><a href="{{$ProcedureData->img}}" target="_blank">{{$ProcedureData->img}}</a> <button type="button" class="btn btn-sm btn-icon btn-flat btn-default removeImgbutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></li>
								@endif
							</ul>
						</div>
						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">시술 이름</label>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group  " >
                                        <input name="name" type="text" class="form-control"  placeholder="한글 이름" value="{{$ProcedureData->name}}">   
										<p class="text-help">- 한글이름</p>
                                    </div>
								</div>
								<div class="col-xl-6">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="name_en" placeholder="영문 이름" value="{{$ProcedureData->name_en}}"/>
										<p class="text-help">- 영문이름</p>
									</div>
								</div>
							</div>
						</div>


						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">관련 시술</label>
							<div class="row">
								<div class="col-xl-12">
								
									<div class="form-group  " >
										<div class="select2-primary">
											<select class="form-control" multiple="multiple" data-plugin="select2"  name="relation[]">
												@foreach($ProcedureSubData as $data)
											  <option value="{{$data->id}}" @if( strpos('#'.$ProcedureData->relation,'[['.$data->id.']]') > 0) selected @endif >												
											   {{$data->name}}</option>
												@endforeach
											</select>
										  </div>                                        
									</div>
								</div>
							</div>
						</div>


					
						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">내용</label>
							<div class="row">								
								<div class="col-xl-12">
									<div class="form-group  " >
										<textarea class="form-control" placeholder="내용 입력" name="description"rows="10">{{$ProcedureData->description}}</textarea>					

									</div>
								</div>
							</div>							
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-6"><a href="{{ $returnurl }}" class="btn  btn-default">돌아가기</a></div>
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



<script>
(function(document, window, $) {
'use strict';
var Site = window.Site;
$(document).ready(function() {
  Site.run();
});
})(document, window, jQuery);


$(document).on('click', 'button.removeImgbutton', function () { // <-- changes
	$(this).closest('li').remove();
    return false;
});
</script>

@stop