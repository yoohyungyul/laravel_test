<div class="modal-header ">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title" id="myModalLabel">시술 {{$procedure}} 수정</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_add" method="POST" action="/member/mod/procedure"   onsubmit="return writeCheck(this);"  >
	<input type="hidden" name="procedure_id" value="{{ $procedure_id }}" />
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="returnurl" value="{{ $returnurl }}"> 

	<div class="row">
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">평가</label>
				<select  class="border" name="score_slug"  >
					<option value="0">선택</option>
					<option value="5" @if($clinicProcedure->score_slug == "5") selected="selected" @endif>★★★★★</option>
					<option value="4" @if($clinicProcedure->score_slug == "4") selected="selected" @endif>★★★★</option>
					<option value="3" @if($clinicProcedure->score_slug == "3") selected="selected" @endif>★★★</option>
					<option value="2" @if($clinicProcedure->score_slug == "2") selected="selected" @endif>★★</option>
					<option value="1" @if($clinicProcedure->score_slug == "1") selected="selected" @endif>★</option>
				</select>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-block border">
				<label for="property-location">수가</label>
				<input type="text" class="form-control" name="expense" placeholder="수가" value="{{$clinicProcedure->expense}}">
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-lg-12 text-right">
			<button type="submit" class="btn btn-primary">수정</button>
		</div>
	</div>
	</form>
</div>
<script>

function writeCheck(f) {

	

	if (confirm('정말 수정 하시겠습니까?    '))
	{
		return true;	
	}
	return false;
}
</script>