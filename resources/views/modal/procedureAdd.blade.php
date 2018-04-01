<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">시술정보 등록</h4>
</div>
<div class="modal-body">
	<form autocomplete="off" name="form_add" method="POST" action="/dbmon/add/procedure"  >
	<input type="hidden" name="id" value="{{ $id }}" />
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="returnurl" value="{{ $returnurl }}"> 
	<div class="row">
		<div class="col-xl-6 form-group">
			<h4 class="example-title">1차 시술 타입</h4>
			<select  class="form-control "  onchange="fnProcedure('2',this.value)" >
				<option value="">선택</option>
				@foreach($procedureData as $Data) 
				<option value="{{$Data->id}}" >{{$Data->name}}</option>
				@endforeach
			</select>
			
		</div>
		<div class="col-xl-6 form-group">
			<h4 class="example-title">2차 시술 부위</h4>
			<div id="second"></div>			
		</div>
		<div class="col-xl-12 form-group">
			<h4 class="example-title">3차 시술명</h4>
			<div id="third">
						
			</div>			
		</div>
		<div class="col-xl-12 form-group text-center">
			<button type="submit" class="btn btn-danger">등록하기</button>
		</div>
	</div>
	</form>
</div>
<script>
	function fnProcedure(depth,value) {	

		if(value) {

			url_str = "/ajax/procedure?depth="+depth+"&value="+value;
			$.ajax({
				url:url_str,
				type:'get',
				success:function(data){	
					if(depth == "2") {
						$('#second').html('');
						$('#third').html('');
						$('#second').html(data);

						
					} else {
						$('#third').html('');
						$('#third').html(data);
					}
				},
				complete : function(data) {
					
			   },
				error:function(request,status,error){
					
			   }
			});	
		} 


	}
	
</script>
 