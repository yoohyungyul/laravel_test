<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">간호등급 등록</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_add" method="POST" action="/dbmon/add/equipmentr"  >
	<input type="hidden" name="id" value="{{ $id }}" />
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="returnurl" value="{{ $returnurl }}"> 
	<div class="row">
		<div class="col-xl-6 form-group">
			<h4 class="example-title">장비</h4>
			<select  class="form-control " name="equipment_id" >
				<option value="">선택</option>
				@foreach($equipmentData as $Data) 
				<option value="{{$Data->id}}" >{{$Data->gov_name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-xl-6 form-group">
			<h4 class="example-title">갯수</h4>
			<input type="text" class="form-control" name="count" placeholder="갯수">
		</div>
		<div class="col-xl-12 form-group text-center">
			<button type="submit" class="btn btn-danger">등록하기</button>
		</div>
	</div>
	</form>
</div>
 