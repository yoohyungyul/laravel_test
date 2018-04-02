<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">{{$procedure}} 수정</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_add" method="POST" action="/dbmon/mod/procedure"  >
	<input type="hidden" name="procedure_id" value="{{ $procedure_id }}" />
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="returnurl" value="{{ $returnurl }}"> 
	<div class="row">
		<div class="col-xl-6 form-group">
			<select  class="form-control " name="score_slug"  >
				<option value="0">선택</option>
				<option value="5" @if($clinicProcedure->score_slug == "5") selected="selected" @endif>★★★★★</option>
				<option value="4" @if($clinicProcedure->score_slug == "4") selected="selected" @endif>★★★★</option>
				<option value="3" @if($clinicProcedure->score_slug == "3") selected="selected" @endif>★★★</option>
				<option value="2" @if($clinicProcedure->score_slug == "2") selected="selected" @endif>★★</option>
				<option value="1" @if($clinicProcedure->score_slug == "1") selected="selected" @endif>★</option>
			</select>
		</div>
		<div class="col-xl-6 form-group">
			<input type="text" class="form-control" name="expense" placeholder="수가" value="{{$clinicProcedure->expense}}">
		</div>
		
		<div class="col-xl-12 form-group text-center">
			<button type="submit" class="btn btn-danger">수정하기</button>
		</div>
	</div>
	</form>
</div>