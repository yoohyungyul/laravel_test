
<?php $__env->startSection('content'); ?>


<section class="subheader subheader-slider subheader-slider-with-filter" style="color:#000;">
	<div class="slider-wrap">
		

		<div class="slider slider-simple">     
			<div class="slide">
				<div class="img-overlay black"></div>
				<div class="container">
					<h1>Find the best clinic and doctor in Korea</h1>								
					<form  action="/find-my-clinic" >
					<div style="margin-top:50px;">
						<div class="filter-item text-left">
							<label  style="color:#fff;">Select a body part</label>
							<select name="body_part_id" id="body-part-select" >
								<option value="">Any</option>
								<?php $__currentLoopData = $procedureData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($data->id); ?>"  ><?php echo e($data->name_en); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>

						<div class="filter-item text-left">
							<label style="color:#fff;">Select a treatment</label>
							<select name="procedure_info_id" id="procedure-info-select">
								<option value="">Any</option>
							</select>
						</div>						

						<div class="filter-item">
							<label class="label-submit">&nbsp;</label>
							<input type="submit" class="button " value="Find" />
							<div class="text-right"><a href="#medical_subject" style="color:#fff;text-decoration: underline;">Find a clinic by Medical Department</a></div>
						</div>						

						<div class="clear"></div>
					</div>
					</form>
				</div>
			</div> 
		</div>
	</div>
</section>



<section class="module property-categories">
	<div class="container">
		<div class="module-header">
			<h2>Popular <strong>Treatments</strong></h2>
			<img src="/front/images/divider.png" alt="" />
		</div>

		<div class="row">
			<div class="col-lg-8 col-md-8">

				<a href="/treatment/<?php echo e($TreatmentsBannerArry[0]['name_url']); ?>" class="property-cat property-cat-apartments" style="background-image: url( <?php if($TreatmentsBannerArry[0]['b_img']): ?> <?php echo e($TreatmentsBannerArry[0]['b_img']); ?> <?php else: ?> /front/images/1000x560.png <?php endif; ?> );}">
					<h3><?php echo e($TreatmentsBannerArry[0]['name']); ?></h3>
					<div class="color-bar"></div>
				</a>
			</div>
			<div class="col-lg-4 col-md-4">
				<a href="/treatment/<?php echo e($TreatmentsBannerArry[1]['name_url']); ?>" class="property-cat property-cat-houses" style="background-image: url( <?php if($TreatmentsBannerArry[1]['b_img']): ?> <?php echo e($TreatmentsBannerArry[1]['b_img']); ?> <?php else: ?> /front/images/1000x560.png <?php endif; ?> );}">
					<h3><?php echo e($TreatmentsBannerArry[1]['name']); ?></h3>
					<div class="color-bar"></div>
				</a>
			</div>
		</div><!-- end row -->

		<div class="row">
			<div class="col-lg-4 col-md-4">
				<a href="/treatment/<?php echo e($TreatmentsBannerArry[2]['name_url']); ?>" class="property-cat property-cat-condos" style="background-image: url( <?php if($TreatmentsBannerArry[2]['b_img']): ?> <?php echo e($TreatmentsBannerArry[2]['b_img']); ?> <?php else: ?> /front/images/1000x560.png <?php endif; ?> );}">
					<h3><?php echo e($TreatmentsBannerArry[2]['name']); ?></h3>
					<div class="color-bar"></div>
				</a>
			</div>
			<div class="col-lg-4 col-md-4">
				<a href="/treatment/<?php echo e($TreatmentsBannerArry[3]['name_url']); ?>" class="property-cat property-cat-waterfront" style="background-image: url( <?php if($TreatmentsBannerArry[3]['b_img']): ?> <?php echo e($TreatmentsBannerArry[3]['b_img']); ?> <?php else: ?> /front/images/1000x560.png <?php endif; ?> );}">
					<h3><?php echo e($TreatmentsBannerArry[3]['name']); ?></h3>
					<div class="color-bar"></div>
				</a>
			</div>
			<div class="col-lg-4 col-md-4">
				<a href="/treatment/<?php echo e($TreatmentsBannerArry[4]['name_url']); ?>" class="property-cat property-cat-cozy" style="background-image: url( <?php if($TreatmentsBannerArry[4]['b_img']): ?> <?php echo e($TreatmentsBannerArry[4]['b_img']); ?> <?php else: ?> /front/images/1000x560.png <?php endif; ?> );}">
					<h3><?php echo e($TreatmentsBannerArry[4]['name']); ?></h3>
					<div class="color-bar"></div>
				</a>
			</div>
		</div>
	</div>
</section>

<section class="module no-padding properties featured">
	<div class="container">
		<div class="module-header">
			<h2>Featured <strong>Clinics</strong></h2>
			<img src="/front/images/divider.png" alt="" />
		</div>
	</div>

	<div class="slider-nav slider-nav-properties-featured">
		<span class="slider-prev"><i class="fa fa-angle-left"></i></span>
		<span class="slider-next"><i class="fa fa-angle-right"></i></span>
	</div>
	
	<div class="slider-wrap">
		<div class="slider slider-featured">    
			<?php $__currentLoopData = $ClinicsBannerData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

			<?php

				$ClinicMedicalSubjectName = DB::table('kmh_clinic_medical_subject')
					->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
					->where('clinic_id',$data->id)->orderBy('kmh_clinic_medical_subject.id', 'desc')->value('name_en');

				if(!$ClinicMedicalSubjectName) $ClinicMedicalSubjectName = "all";

				$medical_subject_url = $ClinicMedicalSubjectName."/";
				$medical_subject_url = str_replace(" ","-",$medical_subject_url);

				
				$url = "/clinic/".$medical_subject_url.$data->name_url;



				$clinic_img = DB::table('kmh_media')->where('of','CLINIC')->where('of_id',$data->id)->orderBy('id', 'desc')->value('path');
				if(!$clinic_img) $clinic_img = "/front/images/1837x1206.png";

				$addr_arry = explode(",",$data->address_en);
				$addr = $data->address_en;
				if(count($addr_arry) > 3 ) $addr = $addr_arry[count($addr_arry)-2].", ".$addr_arry[count($addr_arry)-1];

				$type_name = DB::table('kmh_clinic_type')->where('id',$data->type_id)->value('name_en');

				// 병원 의사 정보
				$DoctorCount = DB::table('kmh_clinic_doctor');
				$DoctorCount = $DoctorCount->where('clinic_id',$data->id);
				$DoctorCount = $DoctorCount->orderBy('id', 'desc')->count('id');


				// 병원 진료 정보
					$ClinicMedicalSubjectData = DB::table('kmh_clinic_medical_subject')
						->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
						->where('clinic_id',$data->id)->orderBy('kmh_clinic_medical_subject.id', 'asc')->get();

			?>
			<div class="property property-hidden-content slide">
				<a href="<?php echo e($url); ?>" class="property-content">
					<div class="property-title">
						<p class="property-address"><i class="fa fa-map-marker icon"></i><?php echo e($addr); ?></p>
						<p class="property-text" style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;margin-bottom:0px;">Type: <?php echo e($type_name); ?></p>
						<p class="property-text" style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;margin-top:0px;">Department : 
							<?php if(count($ClinicMedicalSubjectData) > 0 ): ?>
								<?php $index = 1; ?>
								<?php $__currentLoopData = $ClinicMedicalSubjectData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php echo e($m_data->name_en); ?>

									<?php if( $index != count($ClinicMedicalSubjectData)): ?>, <?php endif; ?>
									<?php $index++ ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?> 
								information unavailable
							<?php endif; ?>								
						</p>
						
					</div>
					<table class="property-details">
						<tr>
							<td><i class="fa fa-user-md"></i> <?php echo e(number_format($DoctorCount)); ?> Doctor<?php if($DoctorCount > 1 ) echo "s" ?></td>
							<td><i class="fa fa-anchor"></i> Since <?php echo e(substr($data->established,0,4)); ?></td>							
						</tr>
					</table>
				</a>
				<a href="<?php echo e($url); ?>" class="property-img">
					<div class="img-fade"></div>
					
					<div class="property-price"><?php echo e($data->name_en); ?></div>
					<div class="property-color-bar"></div>
					<img src="<?php echo e($clinic_img); ?>" alt="" />
				</a>
			</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
		</div>
	</div>
</section>

<section class="module agents-featured">
	<div class="container">
		<div class="module-header">
			<h2>Best <strong>Doctors</strong></h2>
			<img src="/front/images/divider.png" alt="" />
		</div>

		<div class="row">
			<?php $__currentLoopData = $DoctorsBannerData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php
				$doctor_img = "";

				$ImgData = DB::table('kmh_media')->where('of','DOCTOR')->where('of_id', $data->id)->orderBy('id','desc')->first();
				$doctor_img = "";
				if($ImgData) $doctor_img = $ImgData->path;

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
				if($specialty) $specialty = mb_substr($specialty,0,(mb_strlen($specialty) - 2) );

				$ClinicMedicalSubjectName = DB::table('kmh_clinic_medical_subject')
					->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
					->where('clinic_id',$data->clinic_id)->orderBy('kmh_clinic_medical_subject.id', 'desc')->value('name_en');

				if(!$ClinicMedicalSubjectName) $ClinicMedicalSubjectName = "all";

				$medical_subject_url = $ClinicMedicalSubjectName."/";
				$medical_subject_url = str_replace(" ","-",$medical_subject_url);
				
				$url = "/clinic/".$medical_subject_url.$data->name_url."#doctor".$data->id;



			?>
			<div class="col-lg-3 col-md-3" >
				<div class="agent shadow-hover " style="" >
					<a href="<?php echo e($url); ?>" class="agent-img text-center">
						<!-- <div class="img-fade"></div> -->
						<img src="<?php echo e($doctor_img); ?>" alt="" style="width: auto;  height: 200px;"  />
					</a>
					<div class="agent-content">
						<div class="agent-details">
							<h4><a href="<?php echo e($url); ?>">Dr. <?php echo e(ucwords($data->first_name_en)); ?> <?php echo e(ucwords($data->last_name_en)); ?></a></h4>							
							<p style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;margin-bottom:0px;"><i class="fa fa-stethoscope icon"></i><?php echo e($specialty); ?></p>
							<p style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;margin-bottom:0px;"><i class="fa fa-graduation-cap icon"></i><?php echo e($education_name); ?></p>
						</div>
						<div class="text-left">
							<p style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;">- <?php echo e($data->memo); ?></p>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
		</div>
	</div><!-- end container -->
</section>

<section class="module testimonials">

  <div class="container">
    <div class="module-header">
      <h2>Are you ready to be international? Join our FREE clinic membership.</h2>
      <img src="/front/images/divider-white.png" alt="" />
      <p><a href="/apply/clinic"><i class="fa fa-plus" ></i> List your clinic</a></p>
    </div>
  </div>

 
</section>


<a id="medical_subject"></a>
	<section class="module ">
	<div class="container">
		<div class="module-header">
			<h2>Medical <strong>Department</strong></h2>
			<img src="/front/images/divider.png" alt="" />
		</div>
		<div class="row">
			<ul class="bullet-list">
				<?php $__currentLoopData = $medicalData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	              <li class="col-lg-4" style="padding-bottom:10px;"><a href="/find-my-clinic?medical_id=<?php echo e($data->id); ?>" style="font-size:16px;"><i class="fa fa-caret-right"></i>&nbsp;&nbsp;<?php echo e($data->name_en); ?></a></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
		</div>
	</div>
</sectioN>



<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>



$("#body-part-select").change(function (event) {

	var bodyPartId = $("#body-part-select").val();	

    $.ajax({
		url: '/ajax/procedure_info_list',
        data: 'body_part_id=' + bodyPartId,
        type: 'get',
        dataType: 'json',
        beforeSend: function (xhr) {
			xhr.setRequestHeader("Accept", "application/json");       
		}
    }).done(function (data) {

		$('#procedure-info-select').children().remove().end().append('<option selected value="">Any</option>') ;

		$.each(data, function (i, item) {
			$('#procedure-info-select').append($('<option>', { 
				value: item.id,
				text : item.nameEn 
			}));
		});

		$('#procedure-info-select').chosen().trigger("chosen:updated");
     });	

	
});

</script>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>