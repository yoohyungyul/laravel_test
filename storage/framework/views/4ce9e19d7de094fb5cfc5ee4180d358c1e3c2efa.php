
<?php $__env->startSection('content'); ?>


<section class="subheader">
	<div class="container">
		<h1>Property Single</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> Find My Clinic <i class="fa fa-angle-right"></i> <a href="<?php echo e($_SERVER['REQUEST_URI']); ?>" class="current"><?php echo e($ClinicData->name_en); ?></a></div>
		<div class="clear"></div>
	</div>
</section>

<section class="module">
	<div class="container">  
		<div class="row">
			<div class="col-lg-8 col-md-8">		
				<div class="property-single-item property-main">
					<div class="property-header">
						<div class="property-title">
							<h4><?php echo e($ClinicData->name_en); ?></h4>
							<!-- <div class="property-price-single right">$255,000 <span>Per Month</span></div> -->
							<p class="property-address"><i class="fa fa-map-marker icon"></i><?php echo e($ClinicData->address_en); ?></p>
							<div class="clear"></div>
						</div>
						<!-- <div class="property-single-tags">
							<div class="property-tag button alt featured">Featured</div>
							<div class="property-tag button status">For Rent</div>
							<div class="property-type right">Property Type: <a href="#">Family Home</a></div>
						</div> -->
					</div>

					<table class="property-details-single">
						<tr>
							<td><i class="fa fa-user-md"></i> <span><?php echo e(number_format(count($ClinicDoctorData))); ?></span> Doctors</td>
							<td><i class="fa fa-calendar-check-o"></i>  Since <span><?php echo e(substr($ClinicData->established,2,2)); ?>.<?php echo e(substr($ClinicData->established,4,2)); ?>.<?php echo e(substr($ClinicData->established,6,2)); ?></span></td>
							<td><i class="fa fa-bed"></i> <span><?php echo e(number_format($Bed_total)); ?></span> Beds</td>
							<td><i class="fa fa-heart"></i> <span><?php echo e(number_format($favoriteCount)); ?></span> Favorite</td>
						</tr>
					</table>
					<div class="property-gallery">
						<div class="slider-nav slider-nav-property-gallery">
							<span class="slider-prev"><i class="fa fa-angle-left"></i></span>
							<span class="slider-next"><i class="fa fa-angle-right"></i></span>
						</div>
						<div class="slide-counter"></div>
						<div class="slider slider-property-gallery">
							<?php $__currentLoopData = $IMAGEData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="slide"><img src="<?php echo e($data->path); ?>" alt="" width="100%"/></div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
						<div class="slider property-gallery-pager">
							<?php $__currentLoopData = $IMAGEData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<a class="property-gallery-thumb"><img src="<?php echo e($data->path); ?>" alt="" width="100%"/></a>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
				</div><!-- end property title and gallery -->

				<div class="widget property-single-item property-description content">
					<h4>
						<span>Profile</span> 
						<img class="divider-hex" src="/front/images/divider-half.png" alt="" />
						<div class="divider-fade"></div>
					</h4>
					
					<div class="row" style="margin-top:10px">						
						<div class="col-md-4"><strong>Medical Department</strong></div>
						<div class="col-md-8">
							<?php if(count($ClinicMedicalSubjectData) > 0 ): ?>
								<?php $index = 1; ?>
								<?php $__currentLoopData = $ClinicMedicalSubjectData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php echo e($data->name_en); ?>

									<?php if( $index != count($ClinicMedicalSubjectData)): ?>, <?php endif; ?>
									<?php $index++ ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?> 
								information unavailable
							<?php endif; ?>								
						</div>
					</div>
					
					
					<div class="row" style="margin-top:10px">
						<div class="col-md-4"><strong>Specialty Hospital</strong></div>
						<div class="col-md-8">
							<?php if(count($SpecialHospitalData) > 0): ?>
								<?php $index = 1; ?>
								<?php $__currentLoopData = $SpecialHospitalData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php echo e($data->name_en); ?>

									<?php if( $index != count($SpecialHospitalData)): ?>, <?php endif; ?>
									<?php $index++ ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?> 
								information unavailable
							<?php endif; ?>
						</div>
					</div>

					
					<div class="row" style="margin-top:10px">
						<div class="col-md-4"><strong>Specialized Treatment</strong></div>
						<div class="col-md-8">
							<?php if(count($SpecialProcedureData) > 0 ): ?>
								<?php $index = 1; ?>
								<?php $__currentLoopData = $SpecialProcedureData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php echo e($data->name_en); ?>

									<?php if( $index != count($SpecialProcedureData)): ?>, <?php endif; ?>
									<?php $index++ ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?> 
								information unavailable
							<?php endif; ?>
						</div>
					</div>
					<div class="row" style="margin-top:10px">
						<div class="col-md-4"><strong>Medical Equipment </strong></div>
						<div class="col-md-8">
							<?php if(count($EquipmentData) > 0 ): ?>
								<?php $index = 1; ?>
								<?php $__currentLoopData = $EquipmentData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php echo e($data->name_en); ?>

									<?php if( $index != count($EquipmentData)): ?>, <?php endif; ?>
									<?php $index++ ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							<?php else: ?> 
								information unavailable
							<?php endif; ?>


							
						</div>
					</div>
					<div class="clear"></div>		
					

					<div class="tabs" style="margin-top:50px;">
						<ul>
						  <li><a href="#tabs-1"><i class="fa fa-bed icon"></i>Bed</a></li>
						  <li><a href="#tabs-2"><i class="fa fa-stethoscope icon"></i>Treatment</a></li>
						  <li><a href="#tabs-3"><i class="fa fa-clock-o icon"></i>Office Hours</a></li>
						</ul>
						<div id="tabs-1" class="ui-tabs-hide">
							<ul class="additional-details-list">
								<li>일반 입원실(병상)수: <span><?php echo e(number_format($ClinicBedData->standard_bed_count)); ?></span></li>
								<li>수술실(병상)수: <span><?php echo e(number_format($ClinicBedData->surgery_bed_count)); ?></span></li>
								<li>물리치료실(병상)수: <span><?php echo e(number_format($ClinicBedData->physical_therapy_bed_count)); ?></span></li>
								<li>분만실(병상)수: <span><?php echo e(number_format($ClinicBedData->birthing_bed_count)); ?></span></li>
								<li>신생아 중환자실(병상실)수: <span><?php echo e(number_format($ClinicBedData->new_born_intensive_care_bed_count)); ?></span></li>
								<li>상급 입원실(병상실)수: <span><?php echo e(number_format($ClinicBedData->premium_bed_count)); ?></span></li>
								<li>응급실(병상실)수: <span><?php echo e(number_format($ClinicBedData->emergency_bed_count)); ?></span></li>
								<li>성인/소아(병상실)수: <span><?php echo e(number_format($ClinicBedData->adult_child_bed_count)); ?></span></li>
							</ul>
						</div>
						<div id="tabs-2" class="ui-tabs-hide">
							<ul class="additional-details-list">
								<?php $__currentLoopData = $ClinicProcedureData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li><?php echo e($data->name_en); ?>: <span><?php echo e($data->expense); ?></span></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						
						</div>
						<div id="tabs-3" class="ui-tabs-hide">
							<ul class="additional-details-list">
							<?php 
								$mon_s = "";
								$mon_e = "";
								if($MonHourData) {								
									$mon_s = $MonHourData->start;
									$mon_e = $MonHourData->end;
								}

								$tue_s = "";
								$tue_e = "";
								if($TueHourData) {								
									$tue_s = $TueHourData->start;
									$tue_e = $TueHourData->end;
								}

								$wed_s = "";
								$wed_e = "";
								if($WedHourData) {
									$wed_s = $WedHourData->start;
									$wed_e = $WedHourData->end;
								}

								$thu_s = "";
								$thu_e = "";
								if($ThuHourData) {								
									$thu_s = $ThuHourData->start;
									$thu_e = $ThuHourData->end;
								}

								$fri_s = "";
								$fri_e = "";
								if($FriHourData) {								
									$fri_s = $FriHourData->start;
									$fri_e = $FriHourData->end;
								}

								$sat_s = "";
								$sat_e = "";
								if($SatHourData) {								
									$sat_s = $SatHourData->start;
									$sat_e = $SatHourData->end;
								}

								$sun_s = "";
								$sun_e = "";
								if($SunHourData) {
									$sun_s = $SunHourData->start;
									$sun_e = $SunHourData->end;
								}

								$lun_s = "";
								$lun_e = "";
								if($LunHourData) {
									$lun_s = $LunHourData->start;
									$lun_e = $LunHourData->end;
								}
							?>
								<li>Mon: <span><?php echo e($mon_s); ?>~ <?php echo e($mon_e); ?></span></li>
								<li>Tue: <span><?php echo e($tue_s); ?>~ <?php echo e($tue_e); ?></span></li>
								<li>Wed: <span><?php echo e($wed_s); ?>~ <?php echo e($wed_e); ?></span></li>
								<li>Thu: <span><?php echo e($thu_s); ?>~ <?php echo e($thu_e); ?></span></li>
								<li>Fri: <span><?php echo e($fri_s); ?>~ <?php echo e($fri_e); ?></span></li>
								<li>Sat: <span><?php echo e($sat_s); ?>~ <?php echo e($sat_e); ?></span></li>
								<li style="color:#cc0000"><strong>Sun</strong>: <span><?php echo e($sun_s); ?>~ <?php echo e($sun_e); ?></span></li>
								<li style="color:#ffcc00"><strong>Lunch</strong>: <span><?php echo e($lun_s); ?>~ <?php echo e($lun_e); ?></span></li>
								
							</ul>						
						</div>
					</div>
			</div><!-- end description -->

			<!-- <div class="widget property-single-item property-amenities">
				<h4>
					<span>Amenities</span> <img class="divider-hex" src="/front/images/divider-half.png" alt="" />
					<div class="divider-fade"></div>
				</h4>
				<ul class="amenities-list">
					<li><i class="fa fa-check icon"></i> Balcony</li>
					<li><i class="fa fa-check icon"></i> Cable TV</li>
					<li><i class="fa fa-check icon"></i> Deck</li>
					<li><i class="fa fa-check icon"></i> Dishwasher</li>
					<li><i class="fa fa-check icon"></i> Heating</li>
					<li><i class="fa fa-close icon"></i> Internet</li>
					<li><i class="fa fa-check icon"></i> Parking</li>
					<li><i class="fa fa-check icon"></i> Pool</li>
					<li><i class="fa fa-check icon"></i> Oven</li>
					<li><i class="fa fa-close icon"></i> Gym</li>
					<li><i class="fa fa-check icon"></i> Laundry Room</li>
				</ul>
			</div> --><!-- end amenities -->

			<div class="widget property-single-item property-agent">
				<h4>
					<span>Doctors</span> <img class="divider-hex" src="/front/images/divider-half.png" alt="" />
					<div class="divider-fade"></div>
				</h4>
				<?php $__currentLoopData = $ClinicDoctorData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
					if($specialty) $specialty = mb_substr($specialty,1,(mb_strlen($specialty) - 3) );


					// 진료과목
					$MedicalData = DB::table('kmh_clinic_doctor_medical_subject')		
						->select('name_en')
						->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_doctor_medical_subject.medical_subject_id')		
						->where('doctor_id',$data->id)->get();

					$medical = "";
					foreach($MedicalData as $m_data) {
						$medical .= $m_data->name_en.", ";
					}
					if($medical) $medical = mb_substr($medical,1,(mb_strlen($medical) - 3) );

				?>
				<div class="agent">
					<a href="#" class="agent-img">
						<div class="img-fade"></div>
						<!-- <div class="button alt agent-tag">68 Properties</div> -->
						<img src="<?php echo e($doctor_img); ?>" alt="" />
			        </a>
			        <div class="agent-content">
						<!-- <a href="#" class="button button-icon small right"><i class="fa fa-angle-right"></i>Contact Agent</a>
						<a href="#" class="button button-icon small grey right"><i class="fa fa-angle-right"></i>Agent Details</a> -->
						<div class="agent-details">
							<h4><a href="#">Dr. <?php echo e(ucwords($data->first_name_en)); ?> <?php echo e(ucwords($data->last_name_en)); ?></a></h4>
			                <?php if($education_name): ?><p><i class="fa fa-graduation-cap icon"></i><?php echo e($education_name); ?></p><?php endif; ?>
			                <?php if($specialty): ?><p><i class="fa fa-stethoscope icon"></i><?php echo e($specialty); ?></p><?php endif; ?>
							<?php if($medical): ?><p><i class="fa fa-stethoscope icon"></i><?php echo e($medical); ?></p><?php endif; ?>
			            </div>
			            <!-- <ul class="social-icons">
			                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
			                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
			                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
			                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
			                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
			            </ul> -->
			        </div>
			        <div class="clear"></div>					
			    </div>
				<hr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			</div><!-- end agent -->

			<div class="widget property-single-item property-location">
				<h4>
					<span>Location</span> <img class="divider-hex" src="/front/images/divider-half.png" alt="" />
					<div class="divider-fade"></div>
				</h4>
				<div id="map-single"></div>
				<!-- <div class="agent-details">
					<h4><a href="#">Sarah Parker</a></h4>
					<p><i class="fa fa-tag icon"></i>Title: <span>Selling Agent</span></p>
					<p><i class="fa fa-envelope icon"></i>Email: <span>sparker@homely.com</span></p>
					<p><i class="fa fa-phone icon"></i>Office: <span>(123) 456-6789</span></p>
					<p><i class="fa fa-mobile icon"></i>Mobile: <span>(123) 456-6789</span></p>
					<p><i class="fa fa-skype icon"></i>Skype: <span>sarah.parker</span></p>
				  </div> -->




			</div><!-- end location -->

			

			<!-- <div class="widget property-single-item property-related">
				<h4>
					<span>Related Properties</span> <img class="divider-hex" src="/front/images/divider-half.png" alt="" />
					<div class="divider-fade"></div>
				</h4>

				<div class="row">
					<div class="col-lg-6 col-md-6">
						<div class="property shadow-hover">
							<a href="#" class="property-img">
								<div class="img-fade"></div>
								<div class="property-tag button alt featured">Featured</div>
								<div class="property-tag button status">For Sale</div>
								<div class="property-price">$150,000</div>
								<div class="property-color-bar"></div>
								<img src="/front/images/1837x1206.png" alt="" />
							</a>
							<div class="property-content">
								<div class="property-title">
									<h4><a href="#">Modern Family Home</a></h4>
									<p class="property-address"><i class="fa fa-map-marker icon"></i>123 Smith Dr, Annapolis, MD</p>
								</div>
								<table class="property-details">
									<tr>
										<td><i class="fa fa-bed"></i> 3 Beds</td>
										<td><i class="fa fa-tint"></i> 2 Baths</td>
										<td><i class="fa fa-expand"></i> 25,000 Sq Ft</td>
									</tr>
								</table>
							</div>
							<div class="property-footer">
								<span class="left"><i class="fa fa-calendar-o icon"></i> 5 days ago</span>
								<span class="right">
									<a href="#"><i class="fa fa-heart-o icon"></i></a>
									<a href="#"><i class="fa fa-share-alt"></i></a>
								</span>
								<div class="clear"></div>
							</div>
						</div>
					</div>

			        <div class="col-lg-6 col-md-6">
						<div class="property shadow-hover">
							<a href="#" class="property-img">
								<div class="img-fade"></div>
								<div class="property-tag button alt featured">Featured</div>
								<div class="property-tag button status">For Rent</div>
								<div class="property-price">$6,500 <span>Per Month</span></div>
								<div class="property-color-bar"></div>
								<img src="/front/images/1837x1206.png" alt="" />
							</a>
							<div class="property-content">
								<div class="property-title">
									<h4><a href="#">Beautiful Waterfront Condo</a></h4>
									<p class="property-address"><i class="fa fa-map-marker icon"></i>123 Smith Dr, Annapolis, MD</p>
								</div>
								<table class="property-details">
									<tr>
										<td><i class="fa fa-bed"></i> 3 Beds</td>
										<td><i class="fa fa-tint"></i> 2 Baths</td>
										<td><i class="fa fa-expand"></i> 25,000 Sq Ft</td>
									</tr>
								</table>
							</div>
							<div class="property-footer">
								<span class="left"><i class="fa fa-calendar-o icon"></i> 1 week ago</span>
								<span class="right">
									<a href="#"><i class="fa fa-heart-o icon"></i></a>
									<a href="#"><i class="fa fa-share-alt"></i></a>
								</span>
								<div class="clear"></div>
							</div>
						</div>
					</div>
				</div>
			</div> -->
		</div><!-- end col -->
		
		<div class="col-lg-4 col-md-4 sidebar sidebar-property-single">		
			<div class="widget widget-sidebar advanced-search">
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
				
			<!-- <div class="widget widget-sidebar recent-properties">
				<h4><span>Recent Properties</span> <img src="/front/images/divider-half.png" alt="" /></h4>
					<div class="widget-content">
						<div class="recent-property">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-4"><a href="#"><img src="/front/images/1837x1206.png" alt="" /></a></div>
								<div class="col-lg-8 col-md-8 col-sm-8">
								<h5><a href="#">Beautiful Waterfront Condo</a></h5>
								<p><strong>$1,800</strong> Per Month</p>
							</div>
						</div>
					</div>

					<div class="recent-property">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4"><a href="#"><img src="/front/images/1837x1206.png" alt="" /></a></div>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<h5><a href="#">Family Home</a></h5>
								<p><strong>$500,000</strong></p>
							</div>
						</div>
					</div>

					<div class="recent-property">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4"><a href="#"><img src="/front/images/1837x1206.png" alt="" /></a></div>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<h5><a href="#">Ubran Apartment</a></h5>
								<p><strong>$1,800</strong> Per Month</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="widget widget-sidebar recent-posts">
				<h4><span>Recent Blog Posts</span> <img src="/front/images/divider-half.png" alt="" /></h4>
				<div class="widget-content">
					<div class="recent-property">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4"><a href="#"><img src="/front/images/1837x1206.png" alt="" /></a></div>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<h5><a href="#">6 Tips to help you sell your house</a></h5>
								<p><i class="fa fa-calendar-o"></i> Feb, 18th 2017</p>
							</div>
						</div>
					</div>

					<div class="recent-property">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4"><a href="#"><img src="/front/images/1837x1206.png" alt="" /></a></div>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<h5><a href="#">Common mistakes to avoid when moving </a></h5>
								<p><i class="fa fa-calendar-o"></i> Feb, 18th 2017</p>
							</div>
						</div>
					</div>

					<div class="recent-property">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4"><a href="#"><img src="/front/images/1837x1206.png" alt="" /></a></div>
							<div class="col-lg-8 col-md-8 col-sm-8">
								<h5><a href="#">How to design a minimal but productive home office </a></h5>
								<p><i class="fa fa-calendar-o"></i> Feb, 18th 2017</p>
							</div>
						</div>
					</div>
				</div>
			</div>
				
			<div class="widget widget-sidebar recent-properties">
				<h4><span>Quick Links</span> <img src="/front/images/divider-half.png" alt="" /></h4>
					<div class="widget-content box">
						<ul class="bullet-list">
							<li><a href="#">Featured Properties</a></li>
							<li><a href="#">Featured Agents</a></li>
							<li><a href="#">Terms & Conditions</a></li>
							<li><a href="#">Privacy Policy</a></li>
							<li><a href="#">Frequently Asked Questions</a></li>
							<li><a href="#">Login</a></li>
							<li><a href="#">Submit a Property</a></li>
						</ul>
					</div>
				</div>
			</div> -->


		</div><!-- end row -->
	</div><!-- end container -->
</section>

<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqb3fT3SbMSDMggMEK7fJOIkvamccLrjA&sensor=false"></script>
<script>


//intialize the map
function initialize() {
  var mapOptions = {
    zoom: 15,
    scrollwheel: false,
    center: new google.maps.LatLng("<?php echo e($ClinicData->y_pos); ?>", "<?php echo e($ClinicData->x_pos); ?>")
  };

var map = new google.maps.Map(document.getElementById('map-single'),
      mapOptions);


// MARKERS
/****************************************************************/

//add a marker1
var marker = new google.maps.Marker({
    position: map.getCenter(),
    map: map,
    icon: '/front/images/pin.png'
});


// INFO BOXES
/****************************************************************/

//show info box for marker1
var contentString = '<div class="info-box"><h4><?php echo e($ClinicData->name_en); ?></h4><p><?php echo e($ClinicData->address_en); ?></p><br/></div>';

var infowindow = new google.maps.InfoWindow({ content: contentString });

google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });

}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>