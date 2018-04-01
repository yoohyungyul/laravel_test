
<?php $__env->startSection('content'); ?>


<section class="subheader">
  <div class="container">
    <h1><?php echo e($ClinicData->name_en); ?></h1>
    <div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/mypage/clinic/view" class="current">Clinic</a></div>
    <div class="clear"></div>
  </div>
</section>

<section class="module favorited-properties">
  <div class="container">
	
  
	<div class="row">
		<div class="col-lg-3 col-md-3 sidebar-left">
			<?php echo $__env->make('member.left_menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>		
			
		</div>

		<div class="col-lg-9 col-md-9">

			 <?php if(Session::has('success')): ?>			
			 <div class="row">
				<div class="col-lg-12">
					<div class="alert-box success"><i class="fa fa-check icon"></i> <?php echo e(Session::get('success')); ?></div>
				</div>
			</div>
			<?php endif; ?>
			<?php if(Session::has('danger')): ?>
			
			 <div class="row">
				<div class="col-lg-12">
					<div class="alert-box error"><i class="fa fa-close icon"></i> <?php echo e(Session::get('danger')); ?></div>
				</div>
			</div>
			<?php endif; ?>

			<?php echo $__env->make('member.clinic_top', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>	

			<div class="widget  ">
				<div class="widget-content box">		
					<form name="form_list"  method="get" >	
					<input type="hidden" name="returnurl" value="<?php echo e($_SERVER['REQUEST_URI']); ?>" />
					<table class="table table-hover">
						<thead>
						<tr>
							<th><input type="checkbox" id="checkall" /></th>
							<th>#</th>
							<th>사진</th>
							<th>이름</th>
							<th>전문의</th>
							<th>진료과목</th>
							<th>학교</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody style="font-size:12px">
						<?php $_i=0; ?>
						<?php $__currentLoopData = $ClinicDoctorData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

						<?php
						// 의사 사진 첫번째
						$ImgData = DB::table('kmh_media')->where('of','DOCTOR')->where('of_id', $data->id)->orderBy('id','desc')->first();
						$img = "";
						if($ImgData) $img = $ImgData->path;

						// 전문의
						$SpecialtyData = DB::table('kmh_clinic_doctor_specialty')		
							->select('name')
							->join('kmh_specialty', 'kmh_specialty.id', '=', 'kmh_clinic_doctor_specialty.specialty_id')		
							->where('doctor_id',$data->id)->get();

						$specialty = "";
						foreach($SpecialtyData as $s_data) {
							$specialty .= $s_data->name.", ";
						}
						if($specialty) $specialty = mb_substr($specialty,1,(mb_strlen($specialty) - 3) );


						// 진료과목
						$MedicalData = DB::table('kmh_clinic_doctor_medical_subject')		
							->select('gov_name')
							->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_doctor_medical_subject.medical_subject_id')		
							->where('doctor_id',$data->id)->get();

						$medical = "";
						foreach($MedicalData as $m_data) {
							$medical .= $m_data->gov_name.", ";
						}
						if($medical) $medical = mb_substr($medical,1,(mb_strlen($medical) - 3) );


						$education_name = DB::table('kmh_education')->where('id', $data->education_id)->value('school_name');


					?>
						<tr>
							<td><input type="checkbox"  class="chk" name="id[]" value="<?php echo e($data->id); ?>"/></td>
							<td><?php echo e($ClinicDoctorData->total() - ( ( ($ClinicDoctorData->currentPage() - 1) * $ClinicDoctorData->perPage()) + $_i )); ?></td>
							<td><img src="<?php echo e($img); ?>" width="50" /></td>
							<td><?php echo e($data->first_name_kr); ?> <?php echo e($data->last_name_kr); ?></td>
							<td><?php echo e($specialty); ?></td>
							<td><?php echo e($medical); ?></td>
							<td><?php echo e($education_name); ?></td>
							<td>
								<button type="button" class="btn btn-info btn-xs" onclick="fuDoctorMod(<?php echo e($data->id); ?>)">수정</button>
							</td>
						</tr>
						<?php $_i++; ?>

					
				
				
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</tbody>
					</table>
					<div class="row ">
						<div class="col-lg-12t">
							<?php echo $ClinicDoctorData->render(); ?>

						</div>
					</div>
					<div class="row row-lg">
						<div class="col-lg-12 ">						
							<button type="button" class="btn btn-danger" onclick="fuDoctorDel('id[]')">삭제</button>
							<button type="button" class="btn btn-info" onclick="fuDoctorAdd()">+ 등록</buttoN>	
						
						</div>
					</div>

					</form>
				</div>
			</div>

		</div><!-- end col -->
	</div><!-- end row -->

  </div><!-- end container -->
</section>





<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script>
$(document).ready(function() {


	//최상단 체크박스 클릭
    $("#checkall").click(function(){
        //클릭되었으면
        if($("#checkall").prop("checked")){
            //input태그의 name이 chk인 태그들을 찾아서 checked옵션을 true로 정의
            $(".chk").prop("checked",true);
            //클릭이 안되있으면
        }else{
            //input태그의 name이 chk인 태그들을 찾아서 checked옵션을 false로 정의
            $(".chk").prop("checked",false);
        }
    })


});


function fuDoctorAdd() {

  url = "/modal/user_doctor/add?id=<?php echo e(Auth::user()->clinic_id); ?>&returnurl=<?php echo e(urlencode($_SERVER['REQUEST_URI'])); ?>";

  
	
	$("#Modal .modal-content").load(url, function() { 
		 $("#Modal").modal("show"); 
	});
}



function fuDoctorMod(doctor_id) {	

    url = "/modal/user_doctor/mod?doctor_id="+doctor_id+"&returnurl=<?php echo e(urlencode($_SERVER['REQUEST_URI'])); ?>";
	
	$("#Modal .modal-content").load(url, function() { 
		 $("#Modal").modal("show"); 
	});
}

function fuDoctorDel(obj) {
	var i, sum=0, tag=[], str="";
    var chk = document.getElementsByName(obj);
    var tot = chk.length;
    for (i = 0; i < tot; i++) {
        if (chk[i].checked == true) {
            tag[sum] = chk[i].value;
            sum++;
        }
    }

	

    if(tag.length == 0)  {
		alert("삭제 할 의사를 선택해 주세요");
		return false;
	}

	if (confirm('정말 삭제 하시겠습니까?    '))
	{
		document.form_list.action="/member/del/doctor";
		document.form_list.submit();
	}	
}

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>