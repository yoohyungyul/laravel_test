<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use App\User;
use DB;
use Cookie;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Mail;

class FrontController extends Controller
{
  
	// 메인 화면
    public function index()
    {

		$procedureData	= DB::table('kmh_procedure_info')->where('depth',2)->where('parent_id',1)->orderBy('id', 'asc')->get();

		$medicalData	= DB::table('kmh_medical_subject')->orderBy('name_en', 'asc')->get();

		$TreatmentsBannerData = DB::table('kmh_banner')
			->join('kmh_procedure_info', 'kmh_procedure_info.id', '=', 'kmh_banner.b_id')	
			->select('b_id','b_img','name_en','name_url')
			->where('area','1')->where('gubun','1')->orderBy('b_ord','asc')->take(5)->get();


		$ClinicsBannerData = DB::table('kmh_banner')
			->join('kmh_clinic', 'kmh_clinic.id', '=', 'kmh_banner.b_id')		
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')
			->select('kmh_clinic.id','unique_key','name_en','address_en','type_id','established','name_url')
			->where('area','1')->where('gubun','2')->orderBy('b_ord','asc')->take(6)->get();


		$DoctorsBannerData = DB::table('kmh_banner')
			->join('kmh_clinic_doctor', 'kmh_clinic_doctor.id', '=', 'kmh_banner.b_id')
			->join('kmh_clinic', 'kmh_clinic.id', '=', 'kmh_clinic_doctor.clinic_id')		
			->select('kmh_clinic_doctor.id','first_name_en','last_name_en','education_id','kmh_clinic_doctor.memo','name_url','kmh_clinic_doctor.clinic_id')
			->where('area','1')->where('gubun','3')->orderBy('b_ord','asc')->take(4)->get();

		
		$TreatmentsBannerArry = array();
		$_i = 0;
		foreach($TreatmentsBannerData as $data) {
			$TreatmentsBannerArry[$_i]['b_img'] = $data->b_img;
			$TreatmentsBannerArry[$_i]['name_url'] = $data->name_url;
			$TreatmentsBannerArry[$_i]['name'] = $data->name_en;
			$_i++;
		}
			


       	return view('front.main',compact('procedureData','medicalData','TreatmentsBannerArry','ClinicsBannerData','DoctorsBannerData'));     
    }

	// 전체 검색
	public function search() {

		$keyword = Input::get('keyword');

		$keyword_arry = explode(" ",$keyword);

		$ClinicData = DB::table('kmh_clinic')->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id');		
		$ClinicData = $ClinicData->select('kmh_clinic.id','unique_key','name_en','address_en','type_id','established','name_url');
		$ClinicData = $ClinicData->whereNotNull('unique_key');	
		$ClinicData = $ClinicData->where('name_en','!=','');	
		$ClinicData = $ClinicData->where('is_del','0');
		

		
		$ClinicData = $ClinicData->Where(function($query) use ($keyword,$keyword_arry)
		{
			$query->orwhere('name_en','like','%'.$keyword.'%');
			if(count($keyword_arry) > 1) {
				foreach($keyword_arry as $value) {
					$query->orwhere('name_en', 'like', '%'.$value.'%' );
				}
			}
		});


		$ClinicData = $ClinicData->orderBy('kmh_clinic.id', 'desc')->take(5)->get();	


		$DoctorData = DB::table('kmh_clinic_doctor');
		$DoctorData = $DoctorData->join('kmh_clinic', 'kmh_clinic.id', '=', 'kmh_clinic_doctor.clinic_id');
		$DoctorData = $DoctorData->select('kmh_clinic_doctor.id','clinic_id','education_id','first_name_en','last_name_en','kmh_clinic_doctor.memo','name_url');
		$DoctorData = $DoctorData->where('first_name_en','!=','');
		$DoctorData = $DoctorData->whereNotNull('unique_key');	
		$DoctorData = $DoctorData->where('name_en','!=','');	
		$DoctorData = $DoctorData->where('is_del','0');	
		$DoctorData = $DoctorData->Where(function($query) use ($keyword,$keyword_arry)
		{
			$query->orwhere('first_name_en', 'like', '%'.$keyword.'%' );
			$query->orwhere('last_name_en', 'like', '%'.$keyword.'%' );
			if(count($keyword_arry) > 1) {
				foreach($keyword_arry as $value) {
					$query->orwhere('first_name_en', 'like', '%'.$value.'%' );
					$query->orwhere('last_name_en', 'like', '%'.$value.'%' );
				}
			}

		});
		$DoctorData = $DoctorData->orderBy('kmh_clinic_doctor.id', 'desc')->take(5)->get();	


		$procedureData= DB::table('kmh_procedure_info');
		$procedureData = $procedureData->where('depth',3);

		$procedureData = $procedureData->Where(function($query) use ($keyword,$keyword_arry)
		{
			$query->orwhere('name_en','like','%'.$keyword.'%');
			if(count($keyword_arry) > 1) {
				foreach($keyword_arry as $value) {
					$query->orwhere('name_en', 'like', '%'.$value.'%' );
				}
			}
		});
		$procedureData = $procedureData->orderBy('name_en', 'asc')->get();



		return view('front.search',compact('keyword','keyword_arry','ClinicData','DoctorData','procedureData'));
	}

	public function search_clinic() {

		$keyword = Input::get('keyword');
		$keyword_arry = explode(" ",$keyword);

		$ClinicData = DB::table('kmh_clinic')->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id');		
		$ClinicData = $ClinicData->select('kmh_clinic.id','unique_key','name_en','address_en','type_id','established','name_url');
		$ClinicData = $ClinicData->whereNotNull('unique_key');	
		$ClinicData = $ClinicData->where('name_en','!=','');	
		$ClinicData = $ClinicData->where('is_del','0');

		$ClinicData = $ClinicData->Where(function($query) use ($keyword,$keyword_arry)
		{
			$query->orwhere('name_en','like','%'.$keyword.'%');
			if(count($keyword_arry) > 1) {
				foreach($keyword_arry as $value) {
					$query->orwhere('name_en', 'like', '%'.$value.'%' );
				}
			}
		});

		$ClinicData = $ClinicData->orderBy('kmh_clinic.id', 'desc')->paginate(20);	

		return view('front.search_clinic',compact('keyword','keyword_arry','ClinicData'));
	}

	public function search_doctor() {

		$keyword = Input::get('keyword');
		$keyword_arry = explode(" ",$keyword);

		$DoctorData = DB::table('kmh_clinic_doctor');
		$DoctorData = $DoctorData->join('kmh_clinic', 'kmh_clinic.id', '=', 'kmh_clinic_doctor.clinic_id');
		$DoctorData = $DoctorData->select('kmh_clinic_doctor.id','clinic_id','education_id','first_name_en','last_name_en','kmh_clinic_doctor.memo','name_url');
		$DoctorData = $DoctorData->where('first_name_en','!=','');
		$DoctorData = $DoctorData->whereNotNull('unique_key');	
		$DoctorData = $DoctorData->where('name_en','!=','');	
		$DoctorData = $DoctorData->where('is_del','0');	
		$DoctorData = $DoctorData->Where(function($query) use ($keyword,$keyword_arry)
		{
			$query->orwhere('first_name_en', 'like', '%'.$keyword.'%' );
			$query->orwhere('last_name_en', 'like', '%'.$keyword.'%' );
			if(count($keyword_arry) > 1) {
				foreach($keyword_arry as $value) {
					$query->orwhere('first_name_en', 'like', '%'.$value.'%' );
					$query->orwhere('last_name_en', 'like', '%'.$value.'%' );
				}
			}

		});
		$DoctorData = $DoctorData->orderBy('kmh_clinic_doctor.id', 'desc')->paginate(20);	

		return view('front.search_doctor',compact('keyword','keyword_arry','DoctorData'));
	}

	// 병원 검색 
	public function find_my_clinic() {

		

		$body_part_id =  Input::get('body_part_id');
		$procedure_info_id = Input::get('procedure_info_id');
		$medical_id = Input::get('medical_id');
		$area = Input::get('area');

		$ClinicData = DB::table('kmh_clinic')->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id');		
		$ClinicData = $ClinicData->select('kmh_clinic.id','unique_key','name_en','address_en','type_id','established','name_url','is_inquiry');
		$ClinicData = $ClinicData->whereNotNull('unique_key');	
		$ClinicData = $ClinicData->where('name_en','!=','');	
		$ClinicData = $ClinicData->where('is_del','0');	

		// 시술 선택
		if($procedure_info_id) {

			$ClinicData = $ClinicData->where(DB::raw("(SELECT count(id) from kmh_clinic_procedure where procedure_info_id = ".$procedure_info_id." and clinic_id = kmh_clinic.id  )"),'!=','0');

		}

		// 진료 선택
		if($medical_id) {
			$ClinicData = $ClinicData->where(DB::raw("(SELECT count(id) from kmh_clinic_medical_subject where medical_subject_id = ".$medical_id." and clinic_id = kmh_clinic.id  )"),'!=','0');
		}

		// 지역 선택
		if($area) {
			$ClinicData = $ClinicData->where('address_en','like','%'.$area);	
		}



		$ClinicData = $ClinicData->orderBy('kmh_clinic.clinic_rank', 'desc')->orderBy('kmh_clinic.id', 'desc')->paginate(20);



		return view('front.find_my_clinic',compact('ClinicData','body_part_id','procedure_info_id','medical_id','area'));     


		

//		$PopuralDoctorData



		//echo $procedure_info_id."<br>".$medical_id;

		//kmh_clinic_procedure

//		return $procedure_info_id;
	}

	// 병원 정보
	public function clinic_view($medical_subject,$name_url) {



		// 병원 기본 정보
		$ClinicData = DB::table('kmh_clinic')
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')		
			->select('kmh_clinic.id','name','name_en','representative','representative_en','type_id','established','postcode','address','detail','address_en','floor','foreign_patient_attraction_clinic','business_registration_certificate_number','memo','x_pos','y_pos','is_inquiry')
			->where('kmh_clinic.name_url',$name_url)			
			->first();	

		if(count($ClinicData) == 0 ) return Redirect::to('/');

		// 병원 의사 정보
		$ClinicDoctorData = DB::table('kmh_clinic_doctor');
		$ClinicDoctorData = $ClinicDoctorData->where('clinic_id',$ClinicData->id);
		$ClinicDoctorData = $ClinicDoctorData->orderBy('id', 'desc')->get();

		// 병원 상세 정보
		$ClinicDetailData = DB::table('kmh_clinic_detail')->where('clinic_id',$ClinicData->id)->first();	

		// 병원 병상 정보
		$ClinicBedData = DB::table('kmh_clinic_bed_count')
			->where('clinic_id',$ClinicData->id)->first();

		// 병원 병상 총합
		$Bed_total = 0;
		if($ClinicBedData) $Bed_total = $ClinicBedData->standard_bed_count + $ClinicBedData->surgery_bed_count + $ClinicBedData->physical_therapy_bed_count + $ClinicBedData->birthing_bed_count + $ClinicBedData->new_born_intensive_care_bed_count + $ClinicBedData->premium_bed_count + $ClinicBedData->emergency_bed_count + $ClinicBedData->adult_child_bed_count;

		
		// 병원 이미지 정보
		$IMAGEData = DB::table('kmh_media')->where('of','CLINIC')->where('of_id',$ClinicData->id)->orderBy('id', 'desc')->get();

		
		// 병원 진료 정보
		$ClinicMedicalSubjectData = DB::table('kmh_clinic_medical_subject')
			->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
			->where('clinic_id',$ClinicData->id)->orderBy('kmh_clinic_medical_subject.id', 'asc')->get();

		// 전문 병원
		$SpecialHospitalData = DB::table('kmh_clinic_special_hospital')
			->join('kmh_special_hospital', 'kmh_special_hospital.id', '=', 'kmh_clinic_special_hospital.special_hospital_id')
			->where('clinic_id',$ClinicData->id)->orderBy('kmh_clinic_special_hospital.id', 'desc')->get();


		// 전문 진료
		$SpecialProcedureData = DB::table('kmh_clinic_special_procedure')
			->join('kmh_special_procedure', 'kmh_special_procedure.id', '=', 'kmh_clinic_special_procedure.special_procedure_id')
			->where('clinic_id',$ClinicData->id)->orderBy('kmh_clinic_special_procedure.id', 'desc')->get();

		// 병원 장비
		$EquipmentData = DB::table('kmh_clinic_equipment')
			->join('kmh_equipment', 'kmh_equipment.id', '=', 'kmh_clinic_equipment.equipment_id')
			->where('clinic_id',$ClinicData->id)->orderBy('kmh_clinic_equipment.id', 'desc')->get();


		// 병원 시술 정보
		$ClinicProcedureData = DB::table('kmh_clinic_procedure');
		$ClinicProcedureData = $ClinicProcedureData->join('kmh_procedure_info','kmh_procedure_info.id','=','kmh_clinic_procedure.procedure_info_id');
		
		$ClinicProcedureData = $ClinicProcedureData->where('clinic_id',$ClinicData->id);
		$ClinicProcedureData = $ClinicProcedureData->orderBy('kmh_clinic_procedure.id', 'desc')->get();

		// 진료 시간 정보
		$MonHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','1')->first();	
		$TueHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','2')->first();	
		$WedHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','3')->first();	
		$ThuHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','4')->first();	
		$FriHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','5')->first();	
		$SatHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','6')->first();	
		$SunHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','7')->first();	
		$LunHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','8')->first();

		// 병원 즐겨 찾기
		$favoriteCount = DB::table('user_favorite_clinic')->where('clinic_id',$ClinicData->id)->count('id');


		$ClinicPopularProcedureData = DB::table('kmh_clinic_popular_procedure');
		$ClinicPopularProcedureData = $ClinicPopularProcedureData->where('clinic_id',$ClinicData->id);
		$ClinicPopularProcedureData = $ClinicPopularProcedureData->orderBy('id', 'desc')->get();


		// 병원 전후 사진
		$ClinicBeforeAfterData = DB::table('kmh_clinic_before_after');
		$ClinicBeforeAfterData = $ClinicBeforeAfterData->where('clinic_id',$ClinicData->id);
		$ClinicBeforeAfterData = $ClinicBeforeAfterData->orderBy('id', 'desc')->get();

	

		return view('front.clinic_view',compact('id','ClinicData','ClinicDetailData','ClinicDoctorData','ClinicBedData','IMAGEData','ClinicMedicalSubjectData','SpecialHospitalData','SpecialProcedureData','EquipmentData','ClinicProcedureData','MonHourData','TueHourData','WedHourData','ThuHourData','FriHourData','SatHourData','SunHourData','LunHourData','Bed_total','favoriteCount','ClinicPopularProcedureData','ClinicBeforeAfterData'));


	}

	// 의사 리스트
	public function doctors() {

		$DoctorData = DB::table('kmh_clinic_doctor');
		$DoctorData = $DoctorData->join('kmh_clinic', 'kmh_clinic.id', '=', 'kmh_clinic_doctor.clinic_id');
		$DoctorData = $DoctorData->select('kmh_clinic_doctor.id','clinic_id','education_id','first_name_en','last_name_en','kmh_clinic_doctor.memo','name_url');
		$DoctorData = $DoctorData->where('first_name_en','!=','');
		$DoctorData = $DoctorData->whereNotNull('unique_key');	
		$DoctorData = $DoctorData->where('name_en','!=','');	
		$DoctorData = $DoctorData->where('is_del','0');	
		$DoctorData = $DoctorData->orderBy('kmh_clinic_doctor.id', 'desc')->paginate(20);

		return view('front.doctors',compact('DoctorData'));
	}

	// 의사 뷰
	public function doctor_view() {

		$id					= Input::get('id');							//받는 id


		$DoctorData = DB::table('kmh_clinic_doctor')->where('id',$id)->first();
		return view('front.doctor_view',compact('DoctorData'));
	}

	// 상담
	public function contact() {
		return view('front.contact');
	}

	// 상담 등록
	public function contact_add() {

		$name = Input::get('name');
		$email = Input::get('email');
		$subject = Input::get('subject');
		$message = Input::get('message');
		$phone = Input::get('phone');

		$quick_contact_id = DB::table('kmh_quick_contact')->insertGetId(
			array(	
				'name' => $name,
				'email' => $email,
				'subject' => $subject,
				'message' => $message,
				'phone' => $phone
			)
		);

		$data = array();
		$data['name'] = $name;	  
		$data['email'] = $email;	  
		$data['subject'] = $subject;	 
		$data['phone'] = $phone;	 
		$data['message'] = $message;
		$data['d_regis'] = date("Y-m-d H:i:s");			
			
			

		Mail::send('emails.contact', ['data' => $data], function ($m)  {
			$m->from('hello@clinicinsite.com', 'clinicInsite');

			$m->to('hello@clinicinsite.com', 'hello@clinicinsite.com')->subject('Clinic insite contact us 상담 도착');
		});

		return $quick_contact_id; 

		//return Redirect::to('/contact')->withInput()->with('success', '상담 등록 완료.');
	}

	


	// 진료
	public function treatments() {

		$procedureData	= DB::table('kmh_procedure_info')->where('depth',2)->where('parent_id',1)->orderBy('name_en', 'asc')->get();

		$color_array = array('green','gold','red','purple');

		return view('front.treatments',compact('procedureData','color_array'));
	}

	// 진료 상세 정보
	public function treatmentView($treatment) {

		

		// 시술 정보
		$ProcedureInfoData = DB::table('kmh_procedure_info')->where('name_url',$treatment)->first();	

		$color_array = array('green','gold','red','purple');

		return view('front.treatment_view',compact('ProcedureInfoData','color_array'));
	}

	// newsletter 등록
	public function newsletter_add() {

		$email = Input::get('email');

		$n_id = DB::table('kmh_newsletter')->insertGetId(
			array(
				'email' => $email
			)
		);

		return $n_id; 
	}

	// privacy
	public function privacy() {


		return view('front.privacy');
	}

	// terms
	public function terms() {


		return view('front.terms');
	}

	// 블로그 뷰 
	public function blog() {


		// 블로그 정보
		$blogData = DB::table('kmh_blog')->orderBy('d_upis','desc')->paginate(20);

		return view('front.blog',compact('blogData'));
	}

	// 블로그 뷰 
	public function blogView() {

		$id					= Input::get('id');							//받는 id
		$returnurl			= Input::get('returnurl');					//받는 returnurl

		// 블로그 정보
		$blogData = DB::table('kmh_blog')->where('id',$id)->first();	

		DB::table('kmh_blog')
			 ->where('id', $id)
			 ->update(array(
				'hit' => $blogData->hit + 1
			)	
		);

		return view('front.blogView',compact('blogData','returnurl'));
	}

	// about
	public function about() {
		return view('front.about');
		
	}

	// 병원 관리자 신청
	public function apply_clinic() {

		return view('front.apply_clinic');
	}

	// 병원 관리자 신청 등록
	public function apply_clinic_add() {

		$clinic_name		= Input::get('clinic_name');
		$clinic_addr		= Input::get('clinic_addr');
		$name				= Input::get('name');
		$email				= Input::get('email');
		$hp					= Input::get('hp');
		$tel				= Input::get('tel');



		$clinic_reg_id = DB::table('kmh_clinic_reg_apply')->insertGetId(
			array(	
				'clinic_name' => $clinic_name,
				'clinic_addr' => $clinic_addr,
				'name' => $name,
				'email' => $email,
				'hp' => $hp,
				'tel' => $tel
			)
		);

		if($clinic_reg_id) {

			$data = array();
			$data['clinic_name'] = $clinic_name;	  
			$data['clinic_addr'] = $clinic_addr;	  
			$data['name'] = $name;	 
			$data['email'] = $email;	 
			$data['hp'] = $hp;
			$data['tel'] = $tel;
			$data['d_regis'] = date("Y-m-d H:i:s");			
				
				

			Mail::send('emails.clinic_reg_app', ['data' => $data], function ($m)  {
				$m->from('hello@clinicinsite.com', 'clinicInsite');

				$m->to('hello@clinicinsite.com', 'hello@clinicinsite.com')->subject('Clinic insite 병원 등록 신청 도착');
			});
		}

		return Redirect::to("/apply/clinic")->withInput()->with('success', '병원 신청 완료');


	}
}
