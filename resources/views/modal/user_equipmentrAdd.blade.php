<div class="modal-header ">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">장비 등록</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_add" method="POST" action="/member/add/equipmentr"  enctype="multipart/form-data" onsubmit="return writeCheck(this);"  >
	<input type="hidden" name="id" value="{{ $id }}" />
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="returnurl" value="{{ $returnurl }}">

	<div class="row">
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">장비</label>
				<select  class="border" name="equipment_id" >
					<option value="">선택</option>
					@foreach($equipmentData as $Data) 
					<option value="{{$Data->id}}" >{{$Data->gov_name}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">갯수</label>
				<input type="text" class="border" name="count" placeholder="갯수" maxlength="2">
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

	if (f.equipment_id && f.equipment_id.value == '') {
		alert("장비를 선택해 주세요. ");
		f.equipment_id.focus();
		return false;
	}

	if (f.count && f.count.value == '') {
		alert("갯수를 입력해 주세요. ");
		f.count.focus();
		return false;
	}


	if (confirm('정말 등록 하시겠습니까?    '))
	{
		return true;	
	}
	return false;
}
</script>