
<?php $__env->startSection('content'); ?>

<!-- Page -->
<div class="page">
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/dbmon">관리자홈</a></li>
			<li class="breadcrumb-item"><a href="/dbmon/clinic">병원리스트</a></li>
			<li class="breadcrumb-item active"><?php echo e($ClinicData->name); ?></li>
		</ol>
		<h1 class="page-title">병원 정보</h1>
	</div>
	<div class="page-content container-fluid" >
		<form autocomplete="off" name="form_add"  method="POST" onsubmit="return r_writeCheck(this);" action="/dbmon/mod/clinic"  enctype="multipart/form-data" >
		<input type="hidden" name="id" value="<?php echo e($id); ?>">
		<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
		<input type="hidden" name="returnurl" value="<?php echo e($returnurl); ?>">
		<div class="panel">
			<div class="panel-body container-fluid">
				<div class="row row-lg">
					<div class="col-xl-12">      
						<?php echo $__env->make('dbmon.clinicTop', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>		                
					</div>
				</div>				
				<div class="row row-lg">
					<div class="col-xl-12 pt-20">  
						<div class="form-group " >
							<label class="form-control-label" for="inputText">병원 노출 순위</label>
							<div class="row">
								<div class="col-xl-2">
									<div class="form-group  " >
										<select class="form-control" name="clinic_rank">
											<?php for($_i = 100; $_i>0; $_i--): ?>
											<option <?php if($_i == $ClinicData->clinic_rank): ?> selected="selected" <?php endif; ?>><?php echo e($_i); ?></option>
											<?php endfor; ?>
										</select>
                                        
										<p class="text-help">- 높을수록 상단</p>
                                    </div>
								</div>								
							</div>
						</div>
						<div class="form-group " >
							<label class="form-control-label" for="inputText">병원 이름</label>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group  " >
                                        <input name="name" type="text" class="form-control"  placeholder="한글 이름" value="<?php echo e($ClinicData->name); ?>">   
										<p class="text-help">- 한글이름</p>
                                    </div>
								</div>
								<div class="col-xl-6">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="name_en" placeholder="영문 이름" value="<?php echo e($ClinicData->name_en); ?>"/>
										<p class="text-help">- 영문이름</p>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group " >
							<label class="form-control-label" for="inputText">대표자</label>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="representative" placeholder="한글 이름" value="<?php echo e($ClinicData->representative); ?>"/>
										<p class="text-help">- 한글이름</p>
									</div>
								</div>
								<div class="col-xl-6">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="representative_en" placeholder="영문 이름" value="<?php echo e($ClinicData->representative_en); ?>"/>
										<p class="text-help">- 영문이름</p>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group " >
							<div class="row">
								<div class="col-xl-4">
									<label class="form-control-label" for="inputText">전문병원 <button type="button" id="SpecialHospitalAdd" class="btn btn-default btn-xs waves-effect">+ 추가</button></label><br>	
									<div class=" table-responsive">
										<table class="table table-bordered" id="mytable0">
											<thead>
												<tr>
													<th>전문병원</th>													
													<th class="col-1 text-nowrap">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php $__currentLoopData = $clinicSpecialHospitalData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<tr>
													<input type="hidden" name="sh_id[]" value="<?php echo e($Data->id); ?>"/>
													<td>
														<select class="form-control" name="special_hospital_id[]">
															<option>선택</option>
															<?php $__currentLoopData = $specialHospitalData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $SpecialHospitalData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
																<option value="<?php echo e($SpecialHospitalData->id); ?>" <?php if( $SpecialHospitalData->id ==   $Data->special_hospital_id): ?> selected="selected" <?php endif; ?>><?php echo e($SpecialHospitalData->gov_name); ?></option>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														</select>													
													</td>												
													<td><button type="button" class="btn btn-sm btn-icon btn-flat btn-default removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></td>
												</tr>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</tbody>
										</table>
									</div>
															
								</div>
								<div class="col-xl-4">
									<label class="form-control-label" for="inputText">병원규모</label><br>													
									<select data-plugin="selectpicker" data-live-search="true" name="type_id">
									<option value="">선택</option>
									
									<?php $__currentLoopData = $ClinicTypeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option value="<?php echo e($Data->id); ?>" <?php if($Data->id == $ClinicData->type_id): ?> selected="selected" <?php endif; ?> ><?php echo e($Data->gov_name); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>									
								</div>
								<div class="col-xl-4">									
									<label class="form-control-label" for="inputText">설립일</label>
															
									<div class="input-group">
										<span class="input-group-addon">
										  <i class="icon wb-calendar" aria-hidden="true"></i>
										</span>
										<input type="text" name="established" class="form-control" data-plugin="datepicker" value="<?php echo e($ClinicData->established); ?>">
									 </div>
									 <p class="text-help">- MM/DD/YYYY</p>								
								</div>
							</div>
						</div>
						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">주소 <button type="button" class="btn btn-xs btn-info" id="postcodify_search_button">검색</button></label>
							<div class="row">
								<div class="col-xl-2">
									<div class="form-group  " >
										<input type="text" class="form-control postcodify_postcode5"  name="postcode" placeholder="우편번호" value="<?php echo e($ClinicData->postcode); ?>"/>									
										<p class="text-help">- 우편번호</p>
									</div>
								</div>
								<div class="col-xl-5">
									<div class="form-group  " >
										<input type="text" class="form-control postcodify_address"  name="address" placeholder="도로명주소" value="<?php echo e($ClinicData->address); ?>"/>
										<p class="text-help">- 도로명주소</p>
									</div>
								</div>
								<div class="col-xl-5">
									<div class="form-group  " >
										<input type="text" class="form-control postcodify_details"  name="detail" placeholder="상세주소" value="<?php echo e($ClinicData->detail); ?>"/>
										<p class="text-help">- 상세주소</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-2">
									&nbsp;
								</div>
								<div class="col-xl-5">
									<div class="form-group  " >
										<input type="text" class="form-control postcodify_english_address"  name="address_en" placeholder="영문 도로명주소" value="<?php echo e($ClinicData->address_en); ?>"/>
										<p class="text-help">- 영문 도로명주소</p>
									</div>
								</div>
								<div class="col-xl-5">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="floor" placeholder="층수 상세주소" value="<?php echo e($ClinicData->floor); ?>"/>
										<p class="text-help">- 층수 상세주소</p>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group " >
							<div class="row">
								<div class="col-xl-6">
									<label class="form-control-label" for="inputText">진료과목 <button type="button" id="clinicMedicalAdd" class="btn btn-default btn-xs waves-effect">+ 추가</button></label>
									<div class=" table-responsive">
										<table class="table table-bordered" id="mytable3">
											<thead>
												<tr>
													<th>진료과목</th>
													<th>전문의수</th>
													<th>일반의수</th>
													<th class="col-1 text-nowrap">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php $__currentLoopData = $ClinicMedicalSubjectData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<tr>
													<input type="hidden" name="s_id[]" value="<?php echo e($Data->id); ?>"/>
													<td>
														<select class="form-control" name="medical_subject_id[]">
															<option>선택</option>
															<?php $__currentLoopData = $medicalSubjectData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $MedicalSubjectData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
																<option value="<?php echo e($MedicalSubjectData->id); ?>" <?php if( $MedicalSubjectData->id ==   $Data->medical_subject_id): ?> selected="selected" <?php endif; ?>><?php echo e($MedicalSubjectData->gov_name); ?></option>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														</select>													
													</td>
													<td><input type="text" class="form-control" name="special_doctor_count[]" placeholder="전문의수를 입력해주세요" value="<?php echo e($Data->special_doctor_count); ?>"/></td>
													<td><input type="text" class="form-control" name="standard_doctor_count[]" placeholder="일반의수를 입력해주세요" value="<?php echo e($Data->standard_doctor_count); ?>"/></td>
													<td><button type="button" class="btn btn-sm btn-icon btn-flat btn-default removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></td>
												</tr>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-xl-6">
									<label class="form-control-label" for="inputText">홈페이지 <button type="button" id="clinicHomepageAdd" class="btn btn-default btn-xs waves-effect">+ 추가</button></label>
									<div class=" table-responsive">
										<table class="table table-bordered" id="mytable">
											<thead>
												<tr>
													<th>언어권</th>
													<th>URL</th>
													<th class="col-1 text-nowrap">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php $__currentLoopData = $HOMEPAGEData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<tr>
													<input type="hidden" name="h_id[]" value="<?php echo e($Data->id); ?>"/>
													<td>
														<select class="form-control" name="h_language_slug[]">
															<option>선택</option>
															<?php $__currentLoopData = $LangTypeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langtypedata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
																<option value="<?php echo e($langtypedata->group_value); ?>" <?php if( $langtypedata->group_value ==   $Data->language_slug): ?> selected="selected" <?php endif; ?>><?php echo e($langtypedata->group_str); ?></option>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														</select>
													</td>
													<td><input type="text" class="form-control" name="h_value[]" placeholder="URL을 입력해주세요" value="<?php echo e($Data->value); ?>"/></td>
													<td><button type="button" class="btn btn-sm btn-icon btn-flat btn-default removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></td>
												</tr>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>


						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">상담자 <button type="button" id="clinicManagerAdd" class="btn btn-default btn-xs waves-effect">+ 추가</button></label>
							<div class=" table-responsive">
								<table class="table table-bordered" id="mytable2">
									<thead>
										<tr>
											<th>언어권</th>
											<th>이름</th>
											<th>전화번호</th>
											<th>휴대폰번호</th>
											<th>이메일</th>
											<th class="col-1 text-nowrap">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php $__currentLoopData = $MANAGERData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $Data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr>
											<input type="hidden" name="m_id[]" value="<?php echo e($Data->id); ?>"/>
											<td>
												<select class="form-control" name="m_language_slug[]">
													<option>선택</option>
													<?php $__currentLoopData = $LangTypeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langtypedata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
														<option value="<?php echo e($langtypedata->group_value); ?>" <?php if( $langtypedata->group_value ==   $Data->language_slug): ?> selected="selected" <?php endif; ?>><?php echo e($langtypedata->group_str); ?></option>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</select>
											</td>
											<td><input type="text" class="form-control" name="m_name[]" placeholder="이름을 입력해주세요" value="<?php echo e($Data->name); ?>"/></td>
											<td><input type="text" class="form-control" name="m_tel[]" placeholder="전화번호를 입력해주세요" value="<?php echo e($Data->tel); ?>"/></td>
											<td><input type="text" class="form-control" name="m_phone[]" placeholder="휴대폰번호를 입력해주세요" value="<?php echo e($Data->phone); ?>"/></td>
											<td><input type="text" class="form-control" name="m_email[]" placeholder="이메일을 입력해주세요" value="<?php echo e($Data->email); ?>"/></td>
											<td><button type="button" class="btn btn-sm btn-icon btn-flat btn-default removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></td>
										</tr>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</tbody>
								</table>
							</div>							
						</div>

						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">병원사진</label>
							<div class="form-group  row">                                
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="img[]"/>
                                </div>
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="img[]"/>
                                </div>
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="img[]"/>
                                </div>
								<div class="col-xs-6 col-md-3">
									<input type="file" data-plugin="dropify" data-default-file="" name="img[]"/>
                                </div>
                            </div>
							<label class="form-control-label" for="inputText">등록된 사진 </label>
							<ul>
								<?php $__currentLoopData = $IMAGEData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
								<li><input type="hidden" name="i_id[]" value="<?php echo e($data->id); ?>" /><a href="<?php echo e($data->path); ?>" target="_blank"><?php echo e($data->name); ?></a> <button type="button" class="btn btn-sm btn-icon btn-flat btn-default removeImgbutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></li>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</ul>
						</div>
						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">외국인환자 유치의료기관</label>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group  " >
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="foreign_patient_attraction_clinic" type="radio" value="1" <?php if($ClinicData->foreign_patient_attraction_clinic): ?> checked="checked" <?php endif; ?>>
                                            <label>등록</label>
                                        </div>
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="foreign_patient_attraction_clinic" type="radio" value="0" <?php if(!$ClinicData->foreign_patient_attraction_clinic): ?> checked="checked" <?php endif; ?>>
                                            <label>미등록</label>
                                        </div>
                                    </div>
								</div>
								<div class="col-xl-6">
									<div class="form-group  " >
										<input type="file" name="clinic_file" class="form-control" />		
										<p class="text-help">- 등록증첨부</p>
										<?php if($clinicFileData): ?>
										<ul>										
											<li><input type="hidden" name="c_id" value="<?php echo e($clinicFileData->id); ?>" /><a href="<?php echo e($clinicFileData->path); ?>" target="_blank"><?php echo e($clinicFileData->name); ?></a> <button type="button" class="btn btn-sm btn-icon btn-flat btn-default removeImgbutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></li>										
										</ul>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">사업자 등록증</label>
							<div class="row">
								<div class="col-xl-6">
									<div class="col-md-9"><!-- data-plugin="formatter" -->
										<input type="text" class="form-control"  data-pattern="[[999]]-[[99]]-[[99999]]" name="business_registration_certificate_number" value="<?php echo e($ClinicData->business_registration_certificate_number); ?>" />
										<p class="text-help">사업자 번호</p>
									  </div>
								</div>
								<div class="col-xl-6">
									<div class="form-group  " >										
										<input type="file" name="biz_file" class="form-control"  />	
										<p class="text-help">- 등록증첨부</p>
										<?php if($clinicBizFileDaty): ?>
										<ul>										
											<li><input type="hidden" name="b_id" value="<?php echo e($clinicBizFileDaty->id); ?>" /><a href="<?php echo e($clinicBizFileDaty->path); ?>" target="_blank"><?php echo e($clinicBizFileDaty->name); ?></a> <button type="button" class="btn btn-sm btn-icon btn-flat btn-default removeImgbutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></li>										
										</ul>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">공공장소 거리</label>
							<div class="row">
								<div class="col-xl-4">
									<div class="form-group  " >
                                        <input type="text" class="form-control" name="public_place_name"  placeholder="공공장소명" value="<?php echo e($ClinicDetailData->public_place_name); ?>">   
										<p class="text-help">- 공공장소명</p>
                                    </div>
								</div>
								<div class="col-xl-4">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="public_place_direction" placeholder="공공장소에서의 방향" value="<?php echo e($ClinicDetailData->public_place_direction); ?>"/>
										<p class="text-help">- 공공장소에서의 방향</p>
									</div>
								</div>
								<div class="col-xl-4">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="public_place_distance" placeholder="공공장소에서의 거리" value="<?php echo e($ClinicDetailData->public_place_distance); ?>"/>
										<p class="text-help">- 공공장소에서의 거리</p>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">주차</label>
							<div class="row">
								<div class="col-xl-6">
									<div class="form-group  " > 
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="provide_parking_area" type="radio" value="1"  <?php if($ClinicDetailData->provide_parking_area == "1"): ?> checked="checked" <?php endif; ?> >
                                            <label>장소제공</label>
                                        </div>
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="provide_parking_area" type="radio" value="0" <?php if($ClinicDetailData->provide_parking_area == "0"): ?> checked="checked" <?php endif; ?>>
                                            <label>장소미제공</label>
                                        </div>
                                    </div>
								</div>
								<div class="col-xl-6">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="parking_quantity" placeholder="주차 가능대수 방향" value="<?php echo e($ClinicDetailData->parking_quantity); ?>"/>							
										<p class="text-help">- 주차 가능대수</p>
									</div>
								</div>
								<div class="col-xl-12">
									<div class="form-group  " >
										<textarea class="form-control" name="parking_guide"><?php echo e($ClinicDetailData->parking_guide); ?></textarea>					
										<p class="text-help">- 주차안내</p>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">일요일/주말근무</label>
							<div class="row">								
								<div class="col-xl-12">
									<div class="form-group  " >
										<textarea class="form-control" placeholder="일요일 근무 안내" name="sunday_treatment_guide"><?php echo e($ClinicDetailData->sunday_treatment_guide); ?></textarea>					
										<p class="text-help">- 일요일 근무 안내</p>
									</div>
								</div>
							</div>
							<div class="row">								
								<div class="col-xl-12">
									<div class="form-group  " >
										<textarea class="form-control" placeholder="공휴일 근무 안내" name="holiday_treatment_guide"><?php echo e($ClinicDetailData->holiday_treatment_guide); ?></textarea>					
										<p class="text-help">- 공휴일 근무 안내</p>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">주간 응급실</label>
							<div class="row">
								<div class="col-xl-4">
									<div class="form-group  " >
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="provide_day_emergency_room" type="radio" value="1" <?php if($ClinicDetailData->provide_day_emergency_room): ?> checked="checked" <?php endif; ?>>
                                            <label>운영</label>
                                        </div>
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="provide_day_emergency_room" type="radio" value="0" <?php if(!$ClinicDetailData->provide_day_emergency_room): ?> checked="checked" <?php endif; ?>>
                                            <label>미운영</label>
                                        </div>
                                    </div>
								</div>
								<div class="col-xl-4">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="day_emergency_contact_one" placeholder="전화번호1" value="<?php echo e($ClinicDetailData->day_emergency_contact_one); ?>"/>							
										<p class="text-help">- 전화번호1</p>
									</div>
								</div>
								<div class="col-xl-4">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="day_emergency_contact_two" placeholder="전화번호2" value="<?php echo e($ClinicDetailData->day_emergency_contact_two); ?>"/>							
										<p class="text-help">- 전화번호2</p>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">야간 응급실</label>
							<div class="row">
								<div class="col-xl-4">
									<div class="form-group  " >
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="provide_night_emergency_room" type="radio" value="1" <?php if($ClinicDetailData->provide_night_emergency_room): ?> checked="checked" <?php endif; ?>>
                                            <label>운영</label>
                                        </div>
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="provide_night_emergency_room" type="radio" value="0" <?php if(!$ClinicDetailData->provide_night_emergency_room): ?> checked="checked" <?php endif; ?>>
                                            <label>미운영</label>
                                        </div>
                                    </div>
								</div>
								<div class="col-xl-4">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="night_emergency_contact_one" placeholder="전화번호1" value="<?php echo e($ClinicDetailData->night_emergency_contact_one); ?>"/>							
										<p class="text-help">- 전화번호1</p>
									</div>
								</div>
								<div class="col-xl-4">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="night_emergency_contact_two" placeholder="전화번호2" value="<?php echo e($ClinicDetailData->night_emergency_contact_two); ?>"/>							
										<p class="text-help">- 전화번호2</p>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">병상수</label>
							<div class="row">								
								<div class="col-xl-3">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="standard_bed_count" placeholder="일반 입원실(병상)수" value="<?php echo e($ClinicBedData->standard_bed_count); ?>"/>							
										<p class="text-help">- 일반 입원실(병상)수</p>
									</div>
								</div>
								<div class="col-xl-3">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="surgery_bed_count" placeholder="수술실(병상)수" value="<?php echo e($ClinicBedData->surgery_bed_count); ?>"/>							
										<p class="text-help">- 수술실(병상)수</p>
									</div>
								</div>
								<div class="col-xl-3">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="physical_therapy_bed_count" placeholder="물리치료실(병상)수" value="<?php echo e($ClinicBedData->physical_therapy_bed_count); ?>"/>							
										<p class="text-help">- 물리치료실(병상)수</p>
									</div>
								</div>
								<div class="col-xl-3">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="birthing_bed_count" placeholder="분만실(병상)수" value="<?php echo e($ClinicBedData->birthing_bed_count); ?>"/>							
										<p class="text-help">- 분만실(병상)수</p>
									</div>
								</div>
								<div class="col-xl-3">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="new_born_intensive_care_bed_count" placeholder="신생아 중환자실(병상실)수" value="<?php echo e($ClinicBedData->new_born_intensive_care_bed_count); ?>"/>							
										<p class="text-help">- 신생아 중환자실(병상실)수</p>
									</div>
								</div>
								<div class="col-xl-3">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="premium_bed_count" placeholder="상급 입원실(병상실)수" value="<?php echo e($ClinicBedData->premium_bed_count); ?>"/>							
										<p class="text-help">- 상급 입원실(병상실)수</p>
									</div>
								</div>
								<div class="col-xl-3">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="emergency_bed_count" placeholder="응급실(병상실)수" value="<?php echo e($ClinicBedData->emergency_bed_count); ?>"/>							
										<p class="text-help">- 응급실(병상실)수</p>
									</div>
								</div>
								<div class="col-xl-3">
									<div class="form-group  " >
										<input type="text" class="form-control"  name="adult_child_bed_count" placeholder="성인/소아(병상실)수" value="<?php echo e($ClinicBedData->adult_child_bed_count); ?>"/>							
										<p class="text-help">- 성인/소아(병상실)수</p>
									</div>
								</div>

							</div>
						</div>
						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">진료시간</label>
							<div class="row">
								<?php 
									$mon_id = "0";
									$mon_s = "";
									$mon_e = "";
									if($MonHourData) {
										$mon_id = $MonHourData->id;
										$mon_s = $MonHourData->start;
										$mon_e = $MonHourData->end;
									}

									$tue_id = "0";
									$tue_s = "";
									$tue_e = "";
									if($TueHourData) {
										$tue_id = $TueHourData->id;
										$tue_s = $TueHourData->start;
										$tue_e = $TueHourData->end;
									}

									$wed_id = "0";
									$wed_s = "";
									$wed_e = "";
									if($WedHourData) {
										$wed_id = $WedHourData->id;
										$wed_s = $WedHourData->start;
										$wed_e = $WedHourData->end;
									}

									$thu_id = "0";
									$thu_s = "";
									$thu_e = "";
									if($ThuHourData) {
										$thu_id = $ThuHourData->id;
										$thu_s = $ThuHourData->start;
										$thu_e = $ThuHourData->end;
									}

									$fri_id = "0";
									$fri_s = "";
									$fri_e = "";
									if($FriHourData) {
										$fri_id = $FriHourData->id;
										$fri_s = $FriHourData->start;
										$fri_e = $FriHourData->end;
									}

									$sat_id = "0";
									$sat_s = "";
									$sat_e = "";
									if($SatHourData) {
										$sat_id = $SatHourData->id;
										$sat_s = $SatHourData->start;
										$sat_e = $SatHourData->end;
									}

									$sun_id = "0";
									$sun_s = "";
									$sun_e = "";
									if($SunHourData) {
										$sun_id = $SunHourData->id;
										$sun_s = $SunHourData->start;
										$sun_e = $SunHourData->end;
									}

									$lun_id = "0";
									$lun_s = "";
									$lun_e = "";
									if($LunHourData) {
										$lun_id = $LunHourData->id;
										$lun_s = $LunHourData->start;
										$lun_e = $LunHourData->end;
									}
								?>
								
								<div class="col-xl-3">
									<input type="hidden" name="hour_id[]" value="<?php echo e($mon_id); ?>" />
									<input type="hidden" name="day_id[]" value="1" />
									<input type="hidden" name="day_slug[]" value="월" />
									<div class="form-group  " >
										<div class="input-group input-large" >
											<input type="text" class="form-control " name="start[]" maxlength="5" value="<?php echo e($mon_s); ?>" >
											<span class="input-group-addon">~</span>											
											<input type="text" class="form-control " name="end[]" maxlength="5" value="<?php echo e($mon_e); ?>">													  
										</div>
										<p class="text-help">- 월요일 진료시작(0900) ~ 진료종료(1800)</p>
									</div>
								</div>
								
								<div class="col-xl-3">
									<input type="hidden" name="hour_id[]" value="<?php echo e($tue_id); ?>" />
									<input type="hidden" name="day_id[]" value="2" />
									<input type="hidden" name="day_slug[]" value="화" />
									<div class="form-group  " >
										<div class="input-group input-large" >
											<input type="text" class="form-control " name="start[]" maxlength="5" value="<?php echo e($tue_s); ?>" >
											<span class="input-group-addon">~</span>											
											<input type="text" class="form-control " name="end[]" maxlength="5" value="<?php echo e($tue_e); ?>">						  
										</div>
										<p class="text-help">- 화요일 진료시작(0900) ~ 진료종료(1800)</p>
									</div>
								</div>
								<div class="col-xl-3">
									<input type="hidden" name="hour_id[]" value="<?php echo e($wed_id); ?>" />
									<input type="hidden" name="day_id[]" value="3" />
									<input type="hidden" name="day_slug[]" value="수" />
									<div class="form-group  " >
										<div class="input-group input-large" >
											<input type="text" class="form-control " name="start[]" maxlength="5" value="<?php echo e($wed_s); ?>" >
											<span class="input-group-addon">~</span>											
											<input type="text" class="form-control " name="end[]" maxlength="5" value="<?php echo e($wed_e); ?>">									  
										</div>
										<p class="text-help">- 수요일 진료시작(0900) ~ 진료종료(1800)</p>
									</div>
								</div>
								<div class="col-xl-3">
									<input type="hidden" name="hour_id[]" value="<?php echo e($thu_id); ?>" />
									<input type="hidden" name="day_id[]" value="4" />
									<input type="hidden" name="day_slug[]" value="목" />
									<div class="form-group  " >
										<div class="input-group input-large" >
											<input type="text" class="form-control " name="start[]" maxlength="5" value="<?php echo e($thu_s); ?>" >
											<span class="input-group-addon">~</span>											
											<input type="text" class="form-control " name="end[]" maxlength="5" value="<?php echo e($thu_e); ?>">												  
										</div>
										<p class="text-help">- 목요일 진료시작(0900) ~ 진료종료(1800)</p>
									</div>
								</div>
								<div class="col-xl-3">
									<input type="hidden" name="hour_id[]" value="<?php echo e($fri_id); ?>" />
									<input type="hidden" name="day_id[]" value="5" />
									<input type="hidden" name="day_slug[]" value="금" />
									<div class="form-group  " >
										<div class="input-group input-large" >
											<input type="text" class="form-control " name="start[]" maxlength="5" value="<?php echo e($fri_s); ?>" >
											<span class="input-group-addon">~</span>											
											<input type="text" class="form-control " name="end[]" maxlength="5" value="<?php echo e($fri_e); ?>">							  
										</div>
										<p class="text-help">- 금요일 진료시작(0900) ~ 진료종료(1800)</p>
									</div>
								</div>
								<div class="col-xl-3">
									<input type="hidden" name="hour_id[]" value="<?php echo e($sat_id); ?>" />
									<input type="hidden" name="day_id[]" value="6" />
									<input type="hidden" name="day_slug[]" value="토" />
									<div class="form-group  " >
										<div class="input-group input-large" >
											<input type="text" class="form-control " name="start[]" maxlength="5" value="<?php echo e($sat_s); ?>" >
											<span class="input-group-addon">~</span>											
											<input type="text" class="form-control " name="end[]" maxlength="5" value="<?php echo e($sat_e); ?>">												  
										</div>
										<p class="text-help">- 토요일 진료시작(0900) ~ 진료종료(1800)</p>
									</div>
								</div>
								<div class="col-xl-3">
									<input type="hidden" name="hour_id[]" value="<?php echo e($sun_id); ?>" />
									<input type="hidden" name="day_id[]" value="7" />
									<input type="hidden" name="day_slug[]" value="일" />
									<div class="form-group  " >
										<div class="input-group input-large" >
											<input type="text" class="form-control " name="start[]" maxlength="5" value="<?php echo e($sun_s); ?>" >
											<span class="input-group-addon">~</span>											
											<input type="text" class="form-control " name="end[]" maxlength="5" value="<?php echo e($sun_e); ?>">												  
										</div>
										<p class="text-help">- 일요일 진료시작(0900) ~ 진료종료(1800)</p>
									</div>
								</div>
								<div class="col-xl-3">
									<input type="hidden" name="hour_id[]" value="<?php echo e($lun_id); ?>" />
									<input type="hidden" name="day_id[]" value="8" />
									<input type="hidden" name="day_slug[]" value="점심" />
									<div class="form-group  " >
										<div class="input-group input-large" >
											<input type="text" class="form-control " name="start[]" maxlength="5" value="<?php echo e($lun_s); ?>" >
											<span class="input-group-addon">~</span>											
											<input type="text" class="form-control " name="end[]" maxlength="5" value="<?php echo e($lun_e); ?>">								  
										</div>
										<p class="text-help">- 점시시작(0900) ~ 점심종료(1800)</p>
									</div>
								</div>
								
							</div>
						</div>

						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">메모</label>
							<div class="row">								
								<div class="col-xl-12">
									<textarea class="form-control" name="memo"><?php echo e($ClinicData->memo); ?></textarea>					
									<p class="text-help">- 특이사항</p>
								</div>
							</div>
						</div>

						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">상담여부</label>
							<div class="row">								
								<div class="col-xl-4">
									<div class="form-group  " >
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="is_inquiry" type="radio" value="1" <?php if($ClinicData->is_inquiry): ?> checked="checked" <?php endif; ?>>
                                            <label>가능</label>
                                        </div>
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="is_inquiry" type="radio" value="0" <?php if(!$ClinicData->is_inquiry): ?> checked="checked" <?php endif; ?>>
                                            <label>불가능</label>
                                        </div>
                                    </div>
								</div>
							</div>
						</div>

						<div class="form-group  pt-30" >
							<label class="form-control-label" for="inputText">숨김</label>
							<div class="row">								
								<div class="col-xl-4">
									<div class="form-group  " >
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="is_del" type="radio" value="0" <?php if(!$ClinicData->is_del): ?> checked="checked" <?php endif; ?>>
                                            <label>오픈</label>
                                        </div>
                                        <div class="radio-custom radio-default radio-inline">
                                            <input name="is_del" type="radio" value="1" <?php if($ClinicData->is_del): ?> checked="checked" <?php endif; ?>>
                                            <label>숨김</label>
                                        </div>
                                    </div>
								</div>
							</div>
						</div>


					</div>
				</div>
				<div class="row">
					<div class="col-6"><a class="btn  btn-default" href="<?php echo e($returnurl); ?>">돌아가기</a></div>
					<div class="col-6 text-right"><button type="submit" class="btn  btn-success">수정하기</button></div>
				</div>
			</div>
		</div>
		
		</form>
	</div>
</div>
 <!-- End Page -->  



<!-- Footer -->  
<?php echo $__env->make('dbmon_layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- End Footer -->

<!-- Javascript -->
<?php echo $__env->make('dbmon_layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- End Javascript -->



<script src="/global/js/Plugin/formatter.js"></script>

<script src="/global/js/Plugin/bootstrap-datepicker.js"></script>

<script src="//d1p7wdleee1q2z.cloudfront.net/post/search.min.js"></script>

<script> $(function() { $("#postcodify_search_button").postcodifyPopUp(); }); </script>


<script>
(function(document, window, $) {
'use strict';
var Site = window.Site;
$(document).ready(function() {
  Site.run();
});
})(document, window, jQuery);


$('#SpecialHospitalAdd').click(function () {
	var str = '<tr>	<input type="hidden" name="sh_id[]" value="0"/>'
			+ '<td><select class="form-control" name="special_hospital_id[]"> <option>선택</option> <?php $__currentLoopData = $specialHospitalData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $SpecialHospitalData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($SpecialHospitalData->id); ?>" ><?php echo e($SpecialHospitalData->gov_name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	 </select></td>'
			+ '<td><button type="button" class="btn btn-sm btn-icon btn-flat btn-default removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></td>'
			+ '</tr>';
	$('#mytable0 tr:last').after(str);
});

$('#clinicHomepageAdd').click(function () {
	var str = '<tr><input type="hidden" name="h_id[]" value="0"/>'
		+ '<td><select class="form-control" name="h_language_slug[]"><option>선택</option> <?php $__currentLoopData = $LangTypeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langtypedata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($langtypedata->group_value); ?>"><?php echo e($langtypedata->group_str); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select></td>'
		+ '<td><input type="text" class="form-control" name="h_value[]"placeholder="URL을 입력해주세요" value=""/></td>'
		+ '<td><button type="button" class="btn btn-sm btn-icon btn-flat btn-default removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></td>'
		+ '</tr>';

	$('#mytable tr:last').after(str);

   
});

$('#clinicManagerAdd').click(function () {


	var str = '<tr><input type="hidden" name="m_id[]" value="0"/>'
		+ '<td><select class="form-control" value="m_language_slug[]"><option>선택</option> <?php $__currentLoopData = $LangTypeData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $langtypedata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($langtypedata->group_value); ?>" ><?php echo e($langtypedata->group_str); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select></td>'
		+ '<td><input type="text" class="form-control" name="m_name[]" placeholder="이름을 입력해주세요" value=""/></td>'
		+ '<td><input type="text" class="form-control" name="m_tel[]" placeholder="전화번호를 입력해주세요" value=""/></td>'
		+ '<td><input type="text" class="form-control" name="m_phone[]" placeholder="휴대폰번호를 입력해주세요" value=""/></td>'
		+ '<td><input type="text" class="form-control" name="m_email[]" placeholder="이메일을 입력해주세요" value=""/></td>'
		+ '<td><button type="button" class="btn btn-sm btn-icon btn-flat btn-default removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></td>'
		+ '</tr>';

	$('#mytable2 tr:last').after(str);

   
});

$('#clinicMedicalAdd').click(function () {


	var str = '<tr><input type="hidden" name="s_id[]" value="0"/>'
		+ '<td><select class="form-control" name="medical_subject_id[]"><option>선택</option> <?php $__currentLoopData = $medicalSubjectData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $MedicalSubjectData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <option value="<?php echo e($MedicalSubjectData->id); ?>" ><?php echo e($MedicalSubjectData->gov_name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select></td>'
		+ '<td><input type="text" class="form-control" name="special_doctor_count[]" placeholder="전문의수를 입력해주세요" value=""/></td>'
		+ '<td><input type="text" class="form-control" name="standard_doctor_count[]" placeholder="일반의수를 입력해주세요" value=""/></td>'
		+ '<td><button type="button" class="btn btn-sm btn-icon btn-flat btn-default removebutton"  ><i class="icon wb-close" aria-hidden="true"></i></button></td>'
		+ '</tr>';

	$('#mytable3 tr:last').after(str);
   
});









$(document).on('click', 'button.removeImgbutton', function () { // <-- changes
	$(this).closest('li').remove();
    return false;
});


$(document).on('click', 'button.removebutton', function () { // <-- changes
	$(this).closest('tr').remove();
    return false;
});


function r_writeCheck(f) {

	//alert("dd");
	//return false;
}

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('dbmon_layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>