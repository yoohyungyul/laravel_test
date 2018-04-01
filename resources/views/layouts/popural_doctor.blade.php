<?php
$DoctorsBannerData = DB::table('kmh_banner')
	->join('kmh_clinic_doctor', 'kmh_clinic_doctor.id', '=', 'kmh_banner.b_id')
	->join('kmh_clinic', 'kmh_clinic.id', '=', 'kmh_clinic_doctor.clinic_id')		
	->select('kmh_clinic_doctor.id','first_name_en','last_name_en','education_id','kmh_clinic_doctor.memo','name_url','kmh_clinic_doctor.clinic_id')
	->where('area','2')->where('gubun','3')->orderBy('b_ord','asc')->take(5)->get();
?>
<div class="widget widget-sidebar recent-properties">
	<h4><span>Popural Doctor</span> <img src="/front/images/divider-half.png" alt="" /></h4>
	<div class="widget-content">

		<div class="recent-property">
			@foreach($DoctorsBannerData as $data)
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


				// 진료과목
				$MedicalData = DB::table('kmh_clinic_doctor_medical_subject')		
					->select('name_en')
					->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_doctor_medical_subject.medical_subject_id')		
					->where('doctor_id',$data->id)->get();

				$medical = "";
				foreach($MedicalData as $m_data) {
					$medical .= $m_data->name_en.", ";
				}
				if($medical) $medical = mb_substr($medical,0,(mb_strlen($medical) - 2) );

				$ClinicMedicalSubjectName = DB::table('kmh_clinic_medical_subject')
					->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
					->where('clinic_id',$data->clinic_id)->orderBy('kmh_clinic_medical_subject.id', 'desc')->value('name_en');

				if(!$ClinicMedicalSubjectName) $ClinicMedicalSubjectName = "all";

				$medical_subject_url = $ClinicMedicalSubjectName."/";
				$medical_subject_url = str_replace(" ","-",$medical_subject_url);
				
				$url = "/clinic/".$medical_subject_url.$data->name_url."#doctor".$data->id;
			?>
			<div class="row" style="margin-bottom:10px;">
				<div class="col-lg-4 col-md-4 col-sm-4 text-center" ><a href="{{$url}}"><img src="{{$doctor_img}}" alt="" style="width: auto;  height: 100px;" /></a></div>
				<div class="col-lg-8 col-md-8 col-sm-8">
					<h5><a href="{{$url}}">Dr. {{ucwords($data->first_name_en)}} {{ucwords($data->last_name_en)}}</a></h5>
					@if($education_name)<p style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;margin-bottom:3px"><i class="fa fa-graduation-cap icon"></i>{{ $education_name }}</p>@endif
					@if($specialty)<p style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;margin-bottom:3px"><i class="fa fa-stethoscope icon"></i>{{ $specialty }}</p>@endif
					@if($medical)<p style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;margin-bottom:3px"><i class="fa fa-stethoscope icon"></i>{{ $medical }}</p>@endif
				</div>
			</div>
			@endforeach
		</div>
	</div><!-- end widget content -->
</div><!-- end widget -->