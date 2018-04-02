<div class="modal-header ">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">의사 등록</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_add" method="POST" action="/member/add/doctor"  enctype="multipart/form-data" onsubmit="return writeCheck(this);"  >
	<input type="hidden" name="id" value="{{ $id }}" />
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="returnurl" value="{{ $returnurl }}">

	<div class="row">
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">한글 성</label>
				<input type="text" class="border" placeholder="한글 성" name="first_name_kr" value=""/>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">한글 이름</label>
				<input type="text" class="border" placeholder="한글 이름" name="last_name_kr" value=""/>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">영문 성</label>
				<input type="text" class="border" placeholder="영문 성" name="first_name_en" value=""/>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">영문 이름</label>
				<input type="text" class="border" placeholder="영문 이름" name="last_name_en" value=""/>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">전화번호</label>
				<input type="text" class="border" placeholder="전화번호" name="phone" value=""/>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">이메일</label>
				<input type="email" class="border" placeholder="이메일" name="email" value=""/>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-block border">
				<label for="property-location">학력</label>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-block border">
				<select  class="border" name="education_id" id="educationSelect">
					<option value="">선택</option>
					@foreach($educationData as $Data) 
						<option value="{{$Data->id}}" >{{$Data->school_name}}</option>
					@endforeach
				</select>
				<input type="text" class="border"  id="educationAdd" name="newEducation" placeholder="최종 학력 직접입력" style="display: none;">
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-block border">
				<div class="checkbox-custom">
					<input type="checkbox" name="addNewEducation" 
						   id="thereIsNoEducation">
					<label for="thereIsNoEducation">학력을 직접 입력하시겠습니까?</label>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">전문의 <button type="button" class="btn btn-default btn-xs" id="doctor-specialty-add-btn">+ 추가</button></label>
				<div id="specialty-form-group">				
					<select class="border" name="specialty_id[]" style="margin-bottom:5px">
						<option value="">선택</option>	
						@foreach($specialtyData as $Data) 
							<option value="{{$Data->id}}" >{{$Data->name}}</option>
						@endforeach
					</select>
				</div>
			</div>
			
		</div>
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">진료과목 <button type="button" class="btn btn-default btn-xs" id="doctor-medical-subject-add-btn"> + 추가</button></label>
				<div id="medical-subject-form-group">		
					<select class="border" name="medical_subject_id[]" style="margin-bottom:5px">
						<option value="">선택</option>	
						@foreach($medicalSubjectData as $Data) 
							<option value="{{$Data->id}}" >{{$Data->gov_name}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-block border">
				<label for="property-location">의사사진</label>
				<input type="file" class="border" name="d_img[]"/>
				<input type="file" class="border" name="d_img[]"/>
				<input type="file" class="border" name="d_img[]"/>
				<input type="file" class="border" name="d_img[]"/>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-12 text-right">
			<button type="submit" class="btn btn-primary">등록하기</button>
		</div>
	</div>
	</form>
</div>
<script>
$('#thereIsNoEducation').change(function () {
    if ($('#thereIsNoEducation').is(':checked')) {
        $('#educationAdd').show();
        $('#educationSelect').hide();
    } else {
        $('#educationSelect').show();
        $('#educationAdd').hide();
    }
});

$('#doctor-specialty-add-btn').click(function () {
	var data = '<select  class="border" name="specialty_id[]" style="margin-bottom:5px">'
		+ '<option value="">선택</option>	'
		+ '@foreach($specialtyData as $Data)'
		+ '<option value="{{$Data->id}}" >{{$Data->name}}</option>'
		+ '@endforeach'
		+ '</select>';
	$("#specialty-form-group").append(data);

});

$('#doctor-medical-subject-add-btn').click(function () {
	var data = '<select class="border" name="medical_subject_id[]" style="margin-bottom:5px">'
		+ '<option value="">선택</option>	'
		+ '@foreach($medicalSubjectData as $Data)'
		+ '<option value="{{$Data->id}}" >{{$Data->gov_name}}</option>'
		+ '@endforeach'
		+ '</select>';
	 $("#medical-subject-form-group").append(data);

})

function writeCheck(f) {

	if (f.first_name_kr && f.first_name_kr.value == '') {
		alert("한글 성을 입력해 주세요. ");
		f.first_name_kr.focus();
		return false;
	}

	if (f.last_name_kr && f.last_name_kr.value == '') {
		alert("한글 이름을 입력해 주세요. ");
		f.last_name_kr.focus();
		return false;
	}

	if (f.first_name_en && f.first_name_en.value == '') {
		alert("영문 성을 입력해 주세요. ");
		f.first_name_en.focus();
		return false;
	}

	if (f.last_name_en && f.last_name_en.value == '') {
		alert("영문 이름을 입력해 주세요. ");
		f.last_name_en.focus();
		return false;
	}


	if (confirm('정말 등록 하시겠습니까?    '))
	{
		return true;	
	}
	return false;
}
</script>