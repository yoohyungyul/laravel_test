<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">간호등급 등록</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_add" method="POST" action="/dbmon/add/special"  >
	<input type="hidden" name="id" value="{{ $id }}" />
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="returnurl" value="{{ $returnurl }}"> 
	<div class="row">
		<div class="col-12 form-group">
			<h4 class="example-title">특수진료</h4>
			<select  class="form-control " name="special_procedure_id" >
				<option value="">선택</option>
				@foreach($specialProcedureData as $Data) 
				<option value="{{$Data->id}}" >{{$Data->gov_name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-xl-12 form-group text-center">
			<button type="submit" class="btn btn-danger">등록하기</button>
		</div>
	</div>
	</form>
</div>
 