<?php
	
	$SiteData = DB::table('kmh_site_setting')->first();

	$meta_title	=	$SiteData->meta_title;
	$meta_description	=	$SiteData->meta_description;
	$meta_keywords	=	$SiteData->meta_keywords;
	$meta_image	=	"";
	$meta_url	=	"http://clinicinsite.com";


	// 병원 리스트
	if(strpos("#".$_SERVER['REQUEST_URI'],"/find-my-clinic") == "1" ) {
		$meta_title = "Find My Clinic - ".$meta_title;
	}

	// 의사 리스트
	if(strpos("#".$_SERVER['REQUEST_URI'],"/doctors") == "1" ) {
		$meta_title = "Doctor - ".$meta_title;
	}

	// 시술 리스트
	if(strpos("#".$_SERVER['REQUEST_URI'],"/treatments") == "1" ) {
		$meta_title = "Treatments - ".$meta_title;
	}

	// 검색 리스트
	if(strpos("#".$_SERVER['REQUEST_URI'],"/search") == "1" ) {
		$meta_title = "Search - ".$meta_title;
	}


	// 병원 뷰
	if(strpos("#".$_SERVER['REQUEST_URI'],"/clinic") == "1" ) {
		$meta_url_arry = explode("/",$_SERVER['REQUEST_URI']);


		$MetaClinicData = DB::table('kmh_clinic')
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')		
			->select('kmh_clinic.id','name','name_en','representative','representative_en','type_id','established','postcode','address','detail','address_en','floor','foreign_patient_attraction_clinic','business_registration_certificate_number','memo','x_pos','y_pos','name_url')
			->where('kmh_clinic.name_url',$meta_url_arry[3])			
			->first();	

		if(count($MetaClinicData) > 0) {

			$meta_title = $MetaClinicData->name_en." - ".$meta_title;

			$ClinicMedicalSubjectName = DB::table('kmh_clinic_medical_subject')
				->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
				->where('clinic_id',$MetaClinicData->id)->orderBy('kmh_clinic_medical_subject.id', 'desc')->value('name_en');

			if(!$ClinicMedicalSubjectName) $ClinicMedicalSubjectName = "all";

			$medical_subject_url = $ClinicMedicalSubjectName."/";
			$medical_subject_url = str_replace(" ","-",$medical_subject_url);
			
			$meta_url = "http://www.".$_SERVER['HTTP_HOST']."/clinic/".$medical_subject_url.$MetaClinicData->name_url;

			$meta_image = "http://www.".$_SERVER['HTTP_HOST'].DB::table('kmh_media')->where('of','CLINIC')->where('of_id',$MetaClinicData->id)->orderBy('id', 'desc')->value('path');
			if(!$meta_image) $meta_image = "http://www.".$_SERVER['HTTP_HOST']."/front/images/1837x1206.png";

			// 병원 의사 정보
			$DoctorCount = DB::table('kmh_clinic_doctor');
			$DoctorCount = $DoctorCount->where('clinic_id',$MetaClinicData->id);
			$DoctorCount = $DoctorCount->orderBy('id', 'desc')->count('id');

		
			
			$addr_arry = explode(",",$MetaClinicData->address_en);
			$addr = $MetaClinicData->address_en;
			if(count($addr_arry) > 3 ) $addr = $addr_arry[count($addr_arry)-2].", ".$addr_arry[count($addr_arry)-1];

			$type_name = DB::table('kmh_clinic_type')->where('id',$MetaClinicData->type_id)->value('name_en');

			// 병원 진료 정보
			$ClinicMedicalSubjectData = DB::table('kmh_clinic_medical_subject')
				->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
				->where('clinic_id',$MetaClinicData->id)->orderBy('kmh_clinic_medical_subject.id', 'asc')->get();


			$meta_description = $type_name;

			$meta_description .= ", ".number_format($DoctorCount)." Doctor";
			if($DoctorCount > 1 ) $meta_description .= "s";

			$meta_description .= ", Since : ".substr($MetaClinicData->established,0,4);

			$meta_description .= ", address : ".$addr;

			$meta_description .= ", Department : ";

			foreach($ClinicMedicalSubjectData as $m_data) {
				$meta_description .= $m_data->name_en.", ";
			}

			$meta_keywords = $meta_description;
		}


		//echo "d";
	}

	// 시술 정보
	if(strpos("#".$_SERVER['REQUEST_URI'],"/treatment/") == "1" ) {

		$meta_url_arry = explode("/",$_SERVER['REQUEST_URI']);

		$MetaProcedureInfoData = DB::table('kmh_procedure_info')->where('name_url', $meta_url_arry[2])->first();
		if(count($MetaProcedureInfoData) > 0 ) {
			$meta_title = $MetaProcedureInfoData->name_en." - ".$meta_title;
			$meta_url = "http://www.".$_SERVER['HTTP_HOST']."/treatment/".$MetaProcedureInfoData->name_url;

			$meta_image = "http://www.".$_SERVER['HTTP_HOST'].$MetaProcedureInfoData->img;

			$meta_description = mb_substr($MetaProcedureInfoData->description, 0, 30, "UTF-8");
			$meta_keywords = mb_substr($MetaProcedureInfoData->description, 0, 30, "UTF-8");
		}

	}

	// 마이 페이지
	if(strpos("#".$_SERVER['REQUEST_URI'],"/mypage") == "1" ) {
		$meta_title = "My Page - ".$meta_title;

	}

?>

<title>{{$meta_title}}</title>   

<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="{{$meta_description}}">
<meta name=keywords content="{{$meta_keywords}}">
<meta property="og:type" content="website">
<meta property="og:title" content="{{$meta_title}}">
<meta property="og:description" content="{{$meta_description}}">
<meta property="og:image" content="{{$meta_image}}">
<meta property="og:url" content="{{$meta_url}}">	
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="shortcut icon" href="/front/images/favicon_clinicinsite.ico">
<link rel="canonical" href="{{$meta_url}}">