
<?php $__env->startSection('content'); ?>

<section class="subheader subheader-listing-sidebar" style="background:#787c8a url(/front/images/find-my-clinic-top-bg.jpg) no-repeat center;">
	<div class="container">
	<!-- <img src="/front/images/find-my-clinic-top-bg.jpg" /> -->
		<h1>FIND MY CLINIC</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/find-my-clinic" class="current">Find My Clinic</a></div>
		<div class="clear"></div>
	</div>
</section>

<section class="module">
	<div class="container">  
		<div class="row">
			<div class="col-lg-8 col-md-8">	
				<?php $__currentLoopData = $ClinicData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<?php

						$ClinicMedicalSubjectName = DB::table('kmh_clinic_medical_subject')
							->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
							->where('clinic_id',$data->id)->orderBy('kmh_clinic_medical_subject.id', 'desc')->value('name_en');

						if(!$ClinicMedicalSubjectName) $ClinicMedicalSubjectName = "all";

						$medical_subject_url = $ClinicMedicalSubjectName."/";
						$medical_subject_url = str_replace(" ","-",$medical_subject_url);

						$name_url = $data->name_en;
						$name_url = str_replace(" ","-",$name_url);					

						
						$url = "/clinic/".$medical_subject_url.$name_url."?id=".$data->id;

						$clinic_img = DB::table('kmh_media')->where('of','CLINIC')->where('of_id',$data->id)->orderBy('id', 'desc')->value('path');
						if(!$clinic_img) $clinic_img = "/front/images/1837x1206.png";


						// 병원 의사 정보
						$DoctorCount = DB::table('kmh_clinic_doctor');
						$DoctorCount = $DoctorCount->where('clinic_id',$data->id);
						$DoctorCount = $DoctorCount->orderBy('id', 'desc')->count('id');

						// 병원 병상 정보
						$ClinicBedData = DB::table('kmh_clinic_bed_count')
							->where('clinic_id',$data->id)->first();

						// 병원 병상 총합
						$Bed_total = 0;
						if($ClinicBedData) $Bed_total = $ClinicBedData->standard_bed_count + $ClinicBedData->surgery_bed_count + $ClinicBedData->physical_therapy_bed_count + $ClinicBedData->birthing_bed_count + $ClinicBedData->new_born_intensive_care_bed_count + $ClinicBedData->premium_bed_count + $ClinicBedData->emergency_bed_count + $ClinicBedData->adult_child_bed_count;

		
					?>
			
				<div class="property property-row property-row-sidebar shadow-hover">
					<a href="<?php echo e($url); ?>" class="property-img">
						<div class="img-fade"></div>
						<div class="property-tag button status">1For Sale</div>
						
						<div class="property-color-bar"></div>
						<img src="<?php echo e($clinic_img); ?>" alt="" />
					</a>
					<div class="property-content">
						<div class="property-title">
							<h4><a href="<?php echo e($url); ?>"><?php echo e($data->name_en); ?></a></h4>
							<p class="property-address" style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;"><i class="fa fa-map-marker icon"></i><?php echo e($data->address_en); ?></p>
							<div class="clear"></div>
							<p class="property-text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt...</p>
						</div>
						<table class="property-details">
							<tr>
								
								<td><i class="fa fa-user-md"></i> <?php echo e(number_format($DoctorCount)); ?> Doctors</td>
								<td><i class="fa fa-bed"></i> <?php echo e(number_format($Bed_total)); ?> Beds</td>
							</tr>
						</table>
					</div>
					<div class="property-footer">
						<span class="left"><i class="fa fa-calendar-o icon"></i> 5 days ago</span>
						<span class="right">
							<a href="#"><i class="fa fa-heart-o icon"></i></a>
							<!-- <a href="#"><i class="fa fa-share-alt"></i></a> -->
							<a href="<?php echo e($url); ?>" class="button button-icon"><i class="fa fa-angle-right"></i>Details</a>
						</span>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				
				<div class="pagination">
					<div class="center">
						<?php echo $ClinicData->appends(['procedure_info_id' => $procedure_info_id])->appends(['medical_id' => $medical_id])->links('vendor.pagination.bootstrap-4'); ?>

					</div>
					<div class="clear"></div>
				</div>
		
			</div><!-- end listing -->
		
			<div class="col-lg-4 col-md-4 sidebar">			
				<div class="widget widget-sidebar sidebar-properties advanced-search">
					<h4><span>Advanced Search</span> <img src="/front/images/divider-half-white.png" alt="" /></h4>
					<div class="widget-content box">
					<form>
						<div class="form-block border">
							<label for="property-location">Location</label>
							<select id="property-location" class="border">
								<option value="">Any</option>
								<option value="baltimore">Baltimore</option>
								<option value="ny">New York</option>
								<option value="nap">Annapolis</option>
							</select>
						</div>
						<div class="form-block border">
							<label for="property-status">Property Status</label>
							<select id="property-status" class="border">
								<option value="">Any</option>
								<option value="sale">For Sale</option>
								<option value="rent">For Rent</option>
							</select>
						</div>
						<div class="form-block border">
							<label for="property-type">Property Type</label>
							<select id="property-type" class="border">
								<option value="">Any</option>
								<option value="family">Family Home</option>
								<option value="apartment">Apartment</option>
								<option value="apartment">Condo</option>
							</select>
						</div>					  
						<div class="form-block">
							<label>Price</label>
							<div class="price-slider" id="price-slider"></div>
						</div>
						<div class="form-block border">
							<label>Beds</label>
							<select name="beds" id="property-beds" class="border">
								<option value="">Any</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>
						<div class="form-block border">
							<label>Baths</label>
							<select name="baths" id="property-baths" class="border">
								<option value="">Any</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>

						<div class="form-block">
							<label>Area</label>
							<input type="number" name="areaMin" class="area-filter border" placeholder="Min" />
							<input type="number" name="areaMax" class="area-filter border" placeholder="Max" />
							<div class="clear"></div>
						</div>

						<div class="form-block">
							<input type="submit" class="button" value="Find Properties" />
						</div>
					</form>
					</div><!-- end widget content -->
				</div><!-- end widget -->


			</div><!-- end sidebar -->		
		</div><!-- end row -->
	</div><!-- end container -->
</section>

<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>


</script>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>