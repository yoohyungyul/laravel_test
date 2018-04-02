<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">시술 배너 등록</h4>
</div>
<div class="modal-body">
  <form autocomplete="off" name="form_add" method="POST" action="/dbmon/add/procedure_banner"  enctype="multipart/form-data" onsubmit="return b_writeCheck(this);">
  <input type="hidden" name="area" value="{{ $area }}" />
  <input type="hidden" name="gubun" value="{{ $gubun }}" />
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="returnurl" value="{{ $returnurl }}">  
	<div class="row">
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">1차 시술</h4>
		<select class="form-control" onchange="fnProcedureView(this.value)">
			<option value="">선택</option>
			@foreach($procedureData as $data)
			<option value="{{$data->id}}">{{$data->name}}</option>
			@endforeach
		</select>
	  </div>
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">2차 시술</h4>
		<select id="sub_procedure" class="form-control" name="b_id">
		<option value="">선택</option>
		</select>
		
	  </div>
	 @if($area == "1")
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">배너 이미지</h4>
		<input type="file" class="form-control" name="b_img"/>
	  </div>
	  @endif
	  <div class="col-xl-12 form-group text-center">
		<button type="submit" class="btn btn-danger">등록하기</button>
	  </div>
	</div>
  </form>
</div>
<script>
function fnProcedureView(id) {

	$('#sub_procedure').html('');

	$.ajax({
		url: '/ajax/procedure_info_sub',
		data: 'id=' + id,
		type: 'get',
		dataType: 'json',
		beforeSend: function (xhr) {
			xhr.setRequestHeader("Accept", "application/json");
		}
	}).done(function (data) {

		$('#sub_procedure').html('');

		
		var optionStr = '<option value="">선택</option>'
		$.each(data, function(k, v) {
			optionStr += '<option value="'+ v.id  +'">'+ v.name +'</option>';			
		});

		$("#sub_procedure").html(optionStr);
		
	});
}

function b_writeCheck(f) {

	if (f.b_id && f.b_id.value == '') {
		alert("2차 시술을 선택해 주세요 ");
		f.b_id.focus();
		return false;
	}

	@if($area == "1")

		if (f.b_img && f.b_img.value == '') {
			alert("배너 이미지를 선택해 주세요 ");
			f.b_img.focus();
			return false;
		}
	@endif

	if (confirm('정말 등록 하시겠습니까?    '))
	{
		return true;
	}	

	return false;
}
</script>