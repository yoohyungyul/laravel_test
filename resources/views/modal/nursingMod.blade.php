<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">간호등급 수정</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_mod" method="POST" action="/dbmon/mod/nursing"  >
	<input type="hidden" name="nursing_id" value="{{ $nursing_id }}" />
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="returnurl" value="{{ $returnurl }}"> 
	<div class="row">
		<div class="col-xl-6 form-group">
			<h4 class="example-title">간호 등급</h4>
			
			<select  class="form-control " name="nursing_grade_id" >
				<option value="">선택</option>
				@foreach($nursingGradeData as $Data) 
				<option value="{{$Data->id}}" @if($Data->id == $clinicNursingGrade->nursing_grade_id) selected = "selected" @endif>{{$Data->gov_name}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-xl-6 form-group">
			<h4 class="example-title">등급</h4>
			<select  class="form-control " name="grade" >
				<option value="">선택</option>
				@for ($i = 1 ; $i <= 7; $i++)
				<option value="{{$i}}" @if($i == $clinicNursingGrade->grade) selected = "selected" @endif>{{$i}}</option>
				@endfor
			</select>
		</div>
		<div class="col-xl-12 form-group text-center">
			<button type="submit" class="btn btn-danger">수정하기</button>
		</div>
	</div>
	</form>
</div>
 