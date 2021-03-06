<div class="modal-header ">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">대표시술 수정</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_add" method="POST" action="/member/mod/popularprocedur"  enctype="multipart/form-data" onsubmit="return writeCheck(this);"  >
	<input type="hidden" name="popular_procedure_id" value="{{ $popular_procedure_id }}" />
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="returnurl" value="{{ $returnurl }}">  

	<div class="row">
		<div class="col-lg-12">
			<div class="form-block border">
				<label for="property-location">제목</label>
				<input type="text" class="border" name="title" placeholder="제목" value="{{ $clinicPopularProcedure->title }}">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-block border">
				<label for="property-location">내용</label>
				<textarea class="border" rows="10" placeholder="내용 입력" name="description">{{ $clinicPopularProcedure->description}}</textarea>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-block border">
				<label for="property-location">이미지</label>
				<input type="file" class="border" name="p_img[]"/>
				<input type="file" class="border" name="p_img[]"/>
				<input type="file" class="border" name="p_img[]"/>
				<input type="file" class="border" name="p_img[]"/>
				<ul>
					@foreach($MediaData as $data) 
					<li><input type="hidden" name="media_uid[]" value="{{$data->id}}" /><a href="{{$data->path}}" target="_blank">{{$data->name}}</a> <button type="button" class="btn btn-xs btn-danger specialty_removebutton"  >삭제</button></li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-12 text-right">
			<button type="submit" class="btn btn-primary">수정하기</button>
		</div>
	</div>
	</form>
</div>
<script>

function writeCheck(f) {

	if (f.title && f.title.value == '') {
		alert("제목을 입력해 주세요. ");
		f.title.focus();
		return false;
	}

	if (f.description && f.description.value == '') {
		alert("내용을 입력해 주세요. ");
		f.description.focus();
		return false;
	}



	if (confirm('정말 수정 하시겠습니까?    '))
	{
		return true;	
	}
	return false;
}

$(document).on('click', 'button.specialty_removebutton', function () { // <-- changes
	$(this).closest('li').remove();
    return false;
});
</script>