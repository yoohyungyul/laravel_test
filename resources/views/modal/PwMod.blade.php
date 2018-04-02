<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h4 class="modal-title" style="color:#fff">비밀번호 변경</h4>
</div>
<div class="modal-body " >				
	<form  role="form" method="POST" action="#"  name="form_pw">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input type="hidden" name="id" value="{{ $id }}">
	<div class="form-group">
		<label for="name"><font color="red">*</font> 변경할 비밀번호 입력</label>
		<input type="password" class="form-control" id="n_pwd" name="n_pwd" placeholder="">
	</div>
	<div class="form-group">
		<label for="name"><font color="red">*</font> 다시한번 비밀번호 입력 </label>
		<input type="password" class="form-control" id="rt_pwd" name="rt_pwd" placeholder="">
	</div>
	<div class="form-group text-right">
		<button type="button" class="btn btn-default " onclick="fnPw_mod()">변경</button>
	</div>
	
	</form>
</div>
<script type="text/javascript">
<!--

	function fnPw_mod() {

		var f = document.form_pw;
		
		if (f.n_pwd && f.n_pwd.value == '') {
			alert("새로운 비밀번호를 입력해 주세요. ");
			f.n_pwd.focus();
			return false;
		}

		if (f.n_pwd.value.length < 6) {
			alert("6자 이상 입력해 주세요. ");
			f.n_pwd.focus();
			return false;
		}

		if (f.rt_pwd && f.rt_pwd.value == '') {
			alert("다시한번 새로운 비밀번호를 입력해 주세요. ");
			f.rt_pwd.focus();
			return false;
		}

		if (f.rt_pwd.value.length < 6) {
			alert("6자 이상 입력해 주세요. ");
			f.rt_pwd.focus();
			return false;
		}

		if (f.n_pwd.value != f.rt_pwd.value ) {
			alert("새로운 비밀번호를 정확히 두번 입력해 주세요. ");
			f.n_pwd.focus();
			return false;
		}

		 var param = $("form[name=form_pw]").serialize();	

		 $.ajax({
			url:'/dbmon/mod/pw',
			type:'post',
			data:param,
			success:function(data){	
				alert("변경 완료");
				$('#Modal_sm').modal('hide');
			
			},
			complete : function(data) {
				 flag = true;
		   },
			error:function(request,status,error){

			   alert("발송 에러");
			   $('#Modal_sm').modal('hide');
			 
		   }
		})
	}
//-->
</script>