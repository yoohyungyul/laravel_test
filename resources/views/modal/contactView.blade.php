<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  <h4 class="modal-title" id="exampleFillInModalTitle">{{$quickContactData->subject}}</h4>
</div>
<div class="modal-body">
	<div class="row">
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">이름</h4>
		<p>{{$quickContactData->name}}</p>
	  </div>
	 </div>
	 <div class="row">
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">Email</h4>
		<p><a href="mailto:{{$quickContactData->email}}">{{$quickContactData->email}}</a></p>
	  </div>
	 </div>
	 <div class="row">
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">전화번호</h4>
		<p>{{$quickContactData->phone}}</p>
	  </div>
	 </div>
	 <div class="row">
	  <div class="col-xl-6 form-group">
		<h4 class="example-title">내용</h4>
		<p><?php echo str_replace(chr(13),'<br />',$quickContactData->message) ?></p>
	  </div>
	 </div>
  
</div>