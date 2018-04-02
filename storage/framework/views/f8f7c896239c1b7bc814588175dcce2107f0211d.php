
<?php $__env->startSection('content'); ?>


<style>
.highlight{color:#f37a6f;font-weight:600}
</style>

<section class="subheader">
	<div class="container">
		<h1>"<?php echo e($keyword); ?>"</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> Search</div>
		<div class="clear"></div>
	</div>
</section>

<section class="module">
	<div class="container"> 
		<?php if(count($DoctorData) > 0 ): ?>
		<div class="row">
			<div class="col-lg-12">
				<h3>Doctor</h3>
				<ul >
				<?php $__currentLoopData = $DoctorData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php
				$clinic_name = DB::table('kmh_clinic')->where('id', $data->clinic_id)->value('name_en');

				// 학력 정보
				$education_name = DB::table('kmh_education')->where('id', $data->education_id)->value('school_name_en');


				// 전문의
				$SpecialtyData = DB::table('kmh_clinic_doctor_specialty')		
					->select('name_en')
					->join('kmh_specialty', 'kmh_specialty.id', '=', 'kmh_clinic_doctor_specialty.specialty_id')		
					->where('doctor_id',$data->id)->get();

				$specialty = "";
				foreach($SpecialtyData as $s_data) {
					$specialty .= $s_data->name_en.", ";
				}
				if($specialty) $specialty = mb_substr($specialty,1,(mb_strlen($specialty) - 3) );


				$ClinicMedicalSubjectName = DB::table('kmh_clinic_medical_subject')
					->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
					->where('clinic_id',$data->clinic_id)->orderBy('kmh_clinic_medical_subject.id', 'desc')->value('name_en');

				if(!$ClinicMedicalSubjectName) $ClinicMedicalSubjectName = "all";

				$medical_subject_url = $ClinicMedicalSubjectName."/";
				$medical_subject_url = str_replace(" ","-",$medical_subject_url);
				
				$url = "/clinic/".$medical_subject_url.$data->name_url."#doctor".$data->id;
				?>
					<li style="border-bottom:1px solid #e5e5e5;margin-bottom:10px;">
						<h5 class="search_box"><a href="<?php echo e($url); ?>">Dr. <?php echo e(ucwords($data->first_name_en)); ?> <?php echo e(ucwords($data->last_name_en)); ?></a></h5>
						<p><?php echo e($clinic_name); ?>, 
						<?php if($specialty): ?><?php echo e($specialty); ?> ,<?php endif; ?>
						<?php if($education_name): ?><?php echo e($education_name); ?> ,<?php endif; ?>
						</p>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>				
				<div class="divider"></div>
			</div>
		</div>
		<div class="pagination">
			<div class="center">
				<?php echo $DoctorData->appends(['keyword' => $keyword])->links('vendor.pagination.bootstrap-4'); ?>

			</div>
			<div class="clear"></div>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
jQuery(document).ready(function(){
	//// onload시 읽어드리는 스크립트에 다음과 같이 사용
	var sKey1 = "<?php echo e(urldecode($keyword)); ?>"; // 해당 검색어
	if(sKey1 != ''){		
		$('.search_box').highlight(sKey1); // 하이라이트(여러개의 검색어라면 단순하게 여러번 사용
		<?php if(count($keyword_arry) > 1): ?>
			<?php $__currentLoopData = $keyword_arry; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			$('.search_box').highlight("<?php echo e($value); ?>"); // 하이라이트(여러개의 검색어라면 단순하게 여러번 사용
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	}
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>