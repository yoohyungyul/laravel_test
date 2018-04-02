<div class="modal-header ">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">대표시술 등록</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_add" method="POST" action="/member/add/popularprocedur"  enctype="multipart/form-data" onsubmit="return writeCheck(this);"  >
	<input type="hidden" name="id" value="<?php echo e($id); ?>" />
	<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
	<input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>">

	<div class="row">
		<div class="col-lg-12">
			<div class="form-block border">
				<label for="property-location">제목</label>
				<input type="text" class="border" name="title" placeholder="제목">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-block border">
				<label for="property-location">내용</label>
				<textarea class="border" rows="10" placeholder="내용 입력" name="description"></textarea>
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



	if (confirm('정말 등록 하시겠습니까?    '))
	{
		return true;	
	}
	return false;
}
</script>