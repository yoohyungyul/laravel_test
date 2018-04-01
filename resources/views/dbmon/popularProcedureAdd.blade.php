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
		<h1 class="page-title">대표 시술 등록</h1>
	</div>
	<div class="page-content container-fluid" >
		<form autocomplete="off" name="form_add"  method="POST" onsubmit="return r_writeCheck(this);" action="/dbmon/mod/clinic"  enctype="multipart/form-data" >
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="returnurl" value="{{ $returnurl }}">
		<div class="panel">
			<div class="panel-body container-fluid">
							
				<div class="row row-lg">
					<div class="col-xl-12 pt-20">  
						<div class="form-group " >
							<label class="form-control-label" for="inputText">제목</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
                                        <input name="name" type="text" class="form-control"  placeholder="대표 시술 제목" value="">   
										
                                    </div>
								</div>
							</div>
						</div>
						<div class="form-group " >
							<label class="form-control-label" for="inputText">이미지</label>
							<div class="row">
								<div class="col-xl-12">
									<div class="form-group  " >
                                       <div id="summernote" data-plugin="summernote"></div>
										
                                    </div>
								</div>
							</div>
						</div>
						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">병원사진</label>
							<div class="form-group  row">                                
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="img[]"/>
                                </div>
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="img[]"/>
                                </div>
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="img[]"/>
                                </div>
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="img[]"/>
                                </div>
                            </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6"><button type="submit" class="btn  btn-success">등록하기</button></div>
					<div class="col-6 text-right"><a class="btn  btn-default" href="{{ $returnurl}}">돌아가기</a></div>
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

<script src="/global/vendor/summernote/summernote.min.js"></script>
<script src="/global/js/Plugin/summernote.js"></script>
<script>
(function(document, window, $) {
'use strict';
var Site = window.Site;
$(document).ready(function() {
  Site.run();
});
})(document, window, jQuery);


</script>

@stop