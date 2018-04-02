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

class MemberController extends Controller
{
	// 로그인 후 접속 가능
	public function __construct()
    {
        $this->middleware('auth');
    }

    // 마이 페이지
	public function mypage() {

		$CountryData = DB::table('kmh_code')->where('group_code', 'C0003')->where('group_value','>','0')->orderBy('group_str', 'asc')->get();		
		$MessengerData = DB::table('kmh_code')->where('group_code', 'C0004')->where('group_value','>','0')->orderBy('group_ord', 'asc')->get();		

		return view('member.mypage',compact('CountryData','MessengerData'));
	}

	// 자기 정보 수정
	public function user_mod() {

		$photo				= Input::file('photo');						//받는 이미지

		$name			= Input::get('name');
		$gender			= Input::get('gender');
		$birthday		= Input::get('birthday');
		$country		= Input::get('country');
		$tel			= Input::get('tel');
		$messenger		= Input::get('messenger');
		$messenger_id	= Input::get('messenger_id');

		//echo $photo;

		// 이미지 등록	
		
		$forder = "/upload/users/profile/".date('Y-m-d');
		$image_path = public_path().$forder;
		if (!is_dir($image_path)) {			
			@mkdir($image_path, 0777); 
		} 

		$photo_str = "";

		if (!is_null($photo))
		{
			
			$file_name = date("YmdHis",time()).Auth::user()->id."_profile.".$photo->getClientOriginalExtension();
			$img = Image::make($photo->getRealPath())->orientate()->save($image_path."/".$file_name);	

			$photo_str =  $forder."/".$file_name;
		} else {
			$photo_str =  Auth::user()->photo;
		}

		// 회원 정보 수정
		DB::table('users')
			->where('id', Auth::user()->id)
			->update(array(		
				'photo' => $photo_str,
				'name' => $name,
				'gender' => $gender,
				'birthday' => $birthday,
				'country' => $country,
				'tel' => $tel,
				'messenger' => $messenger,
				'messenger_id' => $messenger_id,
				'updated_at' => date("Y-m-d H:i:s")
			)
		);


		// 비밀번호 변경이면
		if(Input::get('new_pass')) {

			$oldpassword = User::find(Auth::user()->id)->password;

			if(!Hash::check(Input::get('current_pass'),$oldpassword )) {
				return redirect()->back()->withInput()->with('danger', 'Your password does not match.');
			}


			$user = User::find(Auth::user()->id);
			$user->password = Hash::make(Input::get('new_pass'));
			$user->save();

			
		}

		return Redirect::to('/mypage')->withInput()->with('success', 'Your change has been saved.');
	}


	// 상담 리스트
	public function inquiry() {

		$InquiryData = DB::table('kmh_inquiry')
			->select('kmh_inquiry.id','kmh_inquiry.clinic_id','name_url','kmh_inquiry.d_regis','address_en','name_en','content','body_part_id','procedure_info_id')
			->join('kmh_clinic', 'kmh_clinic.id', '=', 'kmh_inquiry.clinic_id')
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')
			->where('user_id',Auth::user()->id)
			->whereNotNull('unique_key')
			->where('name_en','!=','')
			->where('is_del','0')
			->orderBy('kmh_inquiry.d_regis','desc')->paginate(20);

		return view('member.inquiry',compact('InquiryData'));
	}

	// 상담 뷰
	public function inquiryView() {

		$id			= Input::get('id');
		$returnurl	= Input::get('returnurl'); 

		$InquiryData = DB::table('kmh_inquiry')
			->select('kmh_inquiry.id','kmh_inquiry.clinic_id','name_url','kmh_inquiry.d_regis','address_en','name_en','title','content','body_part_id','procedure_info_id','kmh_inquiry.name','kmh_inquiry.email','gender','birthday')
			->join('kmh_clinic', 'kmh_clinic.id', '=', 'kmh_inquiry.clinic_id')
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')
			->where('kmh_inquiry.id',$id)->first();


		$messageData = DB::table('kmh_inquiry_message')->where('inquiry_id',$InquiryData->id)->orderBy('id','desc')->get();


		return view('member.inquiryView',compact('id','InquiryData','messageData','returnurl'));

		
	}

	

	// 병원 즐겨찾기
	public function favorite_clinics() {

		$FavoriteData = DB::table('user_favorite_clinic')->join('kmh_clinic', 'kmh_clinic.id', '=', 'user_favorite_clinic.clinic_id')->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id');
		$FavoriteData = $FavoriteData->select('kmh_clinic.id','unique_key','name_en','address_en','type_id','established','name_url');
		$FavoriteData = $FavoriteData->where('user_id',Auth::user()->id);
		$FavoriteData = $FavoriteData->orderBy('user_favorite_clinic.d_regis','desc')->paginate(20);


	
		return view('member.favorite_clinics',compact('FavoriteData'));
	}

	// 병원 즐겨찾기 삭제
	public function favorite_del() {
		$id			= Input::get('id');

		DB::table('user_favorite_clinic')->where('id', $id)->delete();

		return $id;
	}


	// 멀티 상담
	public function send_multiple_inquiry() {


		$returnurl = Input::get('returnurl');
		$id = Input::get('id');

		$body_part_id	=	Input::get('body_part_id');
		$procedure_info_id	= Input::get('procedure_info_id');


		$ClinicData = DB::table('kmh_clinic')->whereIn('id',$id)->get();



		return view('member.send_multiple_inquiry',compact('ClinicData','body_part_id','procedure_info_id','FavoriteData','returnurl'));


		
	}

	// 멀티 상담 등록
	public function send_multiple_inquiry_add() {

		$returnurl			= Input::get('returnurl');					//받는 returnurl


		$body_part_id		= Input::get('body_part_id');
		$procedure_info_id	= Input::get('procedure_info_id');

		$clinic_id			= Input::get('clinic_id');

		$user_id			= Input::get('user_id');	
		$name				= Input::get('name');	
		$email				= Input::get('email');	
		$gender				= Input::get('gender');	
		$birthday			= Input::get('birthday');	
		$content			= Input::get('content');	

		$files				= Input::file('files');					// 상담 이미지


	

		$i_id =  array();

		$clinic_str = "";

		foreach($clinic_id as $value) {
			

			$id = DB::table('kmh_inquiry')->insertGetId(
				array(	
					'user_id' => $user_id,
					'clinic_id' => $value,
					'body_part_id' => $body_part_id,
					'procedure_info_id' => $procedure_info_id,
					'name' => $name,
					'email' => $email,
					'content' => $content,
					'birthday' => $birthday,
					'gender' => $gender
				)
			);

			$clinic_str .= DB::table('kmh_clinic')->where('id',$value)->value('name').", ";

			$i_id[] = $id;
		}


		$folder = "/upload/inquiry/".date('Y-m-d');
		$image_path = public_path().$folder;
		if (!is_dir($image_path)) {		
			
			@mkdir($image_path, 0777); 
		} 	

		if(count($files) > 0) {				
			$_i = 1;
			foreach($files as $file) {
				
				if (!is_null($file))
				{
					
					$file_name = date("YmdHis",time()).$_i.".".$file->getClientOriginalExtension();
					$img = Image::make($file->getRealPath())->orientate()->save($image_path."/".$file_name);	
					
					foreach($i_id as $value) {
						DB::table('kmh_media')->insert(
							array(
								'of' => 'INQUIRY', 
								'of_id' => $value,
								'path' => $folder."/".$file_name,
								'name' => $file->getClientOriginalName(),
								'd_regis' => date("Y-m-d H:i:s"),
								'size' => $file->getSize(),
								'extension' => $file->getClientOriginalExtension()
							)
						);					
					}

					$_i++;
					
				}
			}
		}


		// 이메일 구성
		if($gender == "1") {
			$gender_str = "남자";
		} else {
			$gender_str = "여자";
		}

		$body_part_name = "";
		if($body_part_id) {
			$body_part_name = DB::table('kmh_procedure_info')->where('id',$body_part_id)->value('name_en');
		}

		$procedure_info_name = "";
		if($procedure_info_id) {
			$procedure_info_name = DB::table('kmh_procedure_info')->where('id',$procedure_info_id)->value('name_en');
		}
		$procedure_str = $body_part_name." > " .$procedure_info_name;

		$data = array();
		$data['content'] = $content;	  
		$data['clinic'] = $clinic_str;	  
		$data['procedure'] = $procedure_info_name;	 

		$data['user_id'] = $user_id;	 
		$data['name'] = $name;	 
		$data['email'] = $email;	 
		$data['gender'] = $gender_str;	 
		$data['birthday'] = $birthday;	 
		$data['d_regis'] = date("Y-m-d H:i:s");			
			
			

		Mail::send('emails.send', ['data' => $data], function ($m)  {
			$m->from('hello@clinicinsite.com', 'clinicInsite');

			$m->to('hello@clinicinsite.com', 'hello@clinicinsite.com')->subject('Clinic insite 병원 상담 도착');
		});


		return Redirect::to($returnurl)->withInput()->with('success', 'Your inquiry has been successfully submitted. To see details of your inquiry, please go to <a href="/mypage/inquiry"> My Page.</a>');
	}

	// 상담 메시지 등록
	public function inquiry_message_add() {
		$id			= Input::get('id');
		$returnurl	= Input::get('returnurl'); 
		$clinic_id	= Input::get('clinic_id');
		$message	= Input::get('message'); 

		$files				= Input::file('files');					// 상담 이미지


		$i_id = DB::table('kmh_inquiry_message')->insertGetId(
			array(	
				'inquiry_id' => $id,
				'clinic_id' => $clinic_id,
				'user_id' => Auth::user()->id,
				'message' => $message
			)
		);

		if($i_id) {

			$folder = "/upload/inquiry/".date('Y-m-d');
			$image_path = public_path().$folder;
			if (!is_dir($image_path)) {		
				
				@mkdir($image_path, 0777); 
			} 	

			if(count($files) > 0) {				
				$_i = 1;
				foreach($files as $file) {
					
					if (!is_null($file))
					{
						
						$file_name = date("YmdHis",time()).$_i.".".$file->getClientOriginalExtension();
						$img = Image::make($file->getRealPath())->orientate()->save($image_path."/".$file_name);					
				
						DB::table('kmh_media')->insert(
							array(
								'of' => 'INQUIRY_MESSAGE', 
								'of_id' => $i_id,
								'path' => $folder."/".$file_name,
								'name' => $file->getClientOriginalName(),
								'd_regis' => date("Y-m-d H:i:s"),
								'size' => $file->getSize(),
								'extension' => $file->getClientOriginalExtension()
							)
						);

						$_i++;
						
					}
				}
			}
		}

		return Redirect::to($returnurl)->withInput()->with('success', 'Your inquiry has been submitted.');


	}

	// 병원 즐겨찾기 등록
	public function favoriteAdd() {

		$id		= Input::get('id');							//받는 id

		$favoritecount = DB::table('user_favorite_clinic')->where('user_id',Auth::user()->id)->where('clinic_id',$id)->count('id');

		// 없으면 등록
		if(!$favoritecount) {
			DB::table('user_favorite_clinic')->insert(
				array(
					'user_id' => Auth::user()->id,
					'clinic_id' => $id
				)	
			);
			return "1";

		// 있으면 삭제
		} else {
			DB::table('user_favorite_clinic')->where('user_id',Auth::user()->id)->where('clinic_id',$id)->delete();
			return "2";
		}
	}

	// 상담 삭제
	public function inquiry_del() {
		$id		= Input::get('id');	
		$returnurl	= Input::get('returnurl'); 


		DB::table('kmh_inquiry')->where('user_id',Auth::user()->id)->where('id',$id)->delete();

		DB::table('kmh_inquiry_message')->where('inquiry_id',$id)->delete();

		return Redirect::to($returnurl)->withInput()->with('danger', 'Your inquiry has been deleted.');

	}

	// 병원 회원 병원 뷰
	public function clinic_view() {

		// 관리자 아니면 차단 //
		if(Auth::user()->level != "3") return redirect('/');
		// 관리자 아니면 차단 //


		$RegionData = DB::table('kmh_region')->where('gov_depth', '1')->orderBy('id', 'asc')->get();
		$LangTypeData = DB::table('kmh_code')->where('group_code', 'C0001')->where('group_value','>','0')->orderBy('group_ord', 'asc')->get();
		$ClinicTypeData = DB::table('kmh_clinic_type')->orderBy('gov_id', 'asc')->get();
		$medicalSubjectData  = DB::table('kmh_medical_subject')->orderBy('gov_name', 'asc')->get();



		// 병원 기본 정보
		$ClinicData = DB::table('kmh_clinic')
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')		
			->select('kmh_clinic.id','name','name_en','representative','representative_en','type_id','established','postcode','address','detail','address_en','floor','foreign_patient_attraction_clinic','business_registration_certificate_number','memo','x_pos','y_pos')
			->where('kmh_clinic.id',Auth::user()->clinic_id)			
			->first();	


		// 병원 진료 정보
		$ClinicMedicalSubjectData = DB::table('kmh_clinic_medical_subject')->where('clinic_id',$ClinicData->id)->orderBy('id', 'asc')->get();
		
		// 병원 홈페이지 정보
		$HOMEPAGEData = DB::table('kmh_contact_info')->where('of','CLINIC')->where('of_id',$ClinicData->id)->where('sub_type_slug','OFFICE')->where('type_slug','HOMEPAGE')->orderBy('id', 'desc')->get();

		// 병원 상담자 정보
		$MANAGERData = DB::table('kmh_manager')->where('clinic_id',$ClinicData->id)->orderBy('id', 'desc')->get();

		// 병원 이미지 정보
		$IMAGEData = DB::table('kmh_media')->where('of','CLINIC')->where('of_id',$ClinicData->id)->orderBy('id', 'desc')->get();

		// 병원 사업자 등록증 파일 정보
		$clinicBizFileDaty = DB::table('kmh_media')->where('of','CLINIC_BIZ_FILE')->where('of_id',$ClinicData->id)->orderBy('id','desc')->first();

		// 병원 병상 정보
		$ClinicBedData = DB::table('kmh_clinic_bed_count')->where('clinic_id',$ClinicData->id)->first();

		$MonHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','1')->first();	
		$TueHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','2')->first();	
		$WedHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','3')->first();	
		$ThuHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','4')->first();	
		$FriHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','5')->first();	
		$SatHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','6')->first();	
		$SunHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','7')->first();	
		$LunHourData = DB::table('kmh_business_hour')->where('clinic_id',$ClinicData->id)->where('day_id','8')->first();
		

		return view('member.clinic_view',compact('RegionData','LangTypeData','ClinicTypeData','medicalSubjectData','ClinicData','ClinicMedicalSubjectData','HOMEPAGEData','MANAGERData','IMAGEData','clinicBizFileDaty','ClinicBedData','MonHourData','TueHourData','WedHourData','ThuHourData','FriHourData','SatHourData','SunHourData','LunHourData'));

	}

	// 병원 정보 수정 처리
	public function clinic_mod() {

		$name						= Input::get('name');
		$name_en					= Input::get('name_en');

		$name_url = $name_en;
		$name_url = str_replace(" ","-",$name_url);		
		
		$name_url = str_replace("---","-",$name_url);		
		$name_url = str_replace("--","-",$name_url);	

		$urlChackCount = DB::table('kmh_clinic')->where('name_url',$name_url)->where('id','!=',Auth::user()->clinic_id)->count('id');

		if($urlChackCount) {
			for($i = 1 ; $i < 100 ; ++$i){

				$name_url = $name_url."-".$i;
        
				$urlChackCount = DB::table('kmh_clinic')->where('name_url',$name_url."-".$i)->where('id','!=',Auth::user()->clinic_id)->count('id');

				if(!$urlChackCount) break;
				
			}
		}

		$representative				= Input::get('representative');
		$representative_en			= Input::get('representative_en');
		$type_id					= Input::get('type_id');
		$established				= Input::get('established');

		$postcode					= Input::get('postcode');
		$address					= Input::get('address');
		$detail						= Input::get('detail');
		$address_en					= Input::get('address_en');
		$floor						= Input::get('floor');

		$s_id						= Input::get('s_id');
		$medical_subject_id			= Input::get('medical_subject_id');
		$special_doctor_count		= Input::get('special_doctor_count');
		$standard_doctor_count		= Input::get('standard_doctor_count');

		$h_id						= Input::get('h_id');
		$h_language_slug			= Input::get('h_language_slug');
		$h_value					= Input::get('h_value');

		$m_id						= Input::get('m_id');
		$m_language_slug			= Input::get('m_language_slug');
		$m_name						= Input::get('m_name');
		$m_tel						= Input::get('m_tel');
		$m_phone					= Input::get('m_phone');
		$m_email					= Input::get('m_email');


		$img						= Input::file('img');
		$i_id						= Input::get('i_id');

		$business_registration_certificate_number	= Input::get('business_registration_certificate_number');
		$biz_file					= Input::file('biz_file');
		$b_id						= Input::get('b_id');

		$standard_bed_count						= Input::get('standard_bed_count');
		$surgery_bed_count						= Input::get('surgery_bed_count');
		$physical_therapy_bed_count				= Input::get('physical_therapy_bed_count');
		$birthing_bed_count						= Input::get('birthing_bed_count');
		$new_born_intensive_care_bed_count		= Input::get('new_born_intensive_care_bed_count');
		$premium_bed_count						= Input::get('premium_bed_count');
		$emergency_bed_count					= Input::get('emergency_bed_count');
		$adult_child_bed_count					= Input::get('adult_child_bed_count');

		$hour_id					= Input::get('hour_id');
		$day_id						= Input::get('day_id');
		$day_slug					= Input::get('day_slug');
		$start						= Input::get('start');
		$end						= Input::get('end');


		// 기본정보 수정
		DB::table('kmh_clinic')
			->where('id', Auth::user()->clinic_id)
			->update(array(			
				'name' => $name,
				'name_en' => $name_en,
				'name_url' => $name_url,
				'representative' => $representative,
				'representative_en' => $representative_en,
				'type_id' => $type_id,
				'established' => $established,				
				'business_registration_certificate_number' => $business_registration_certificate_number,		
				'd_upis' => date("Y-m-d H:i:s")
			)
		);


		// 주소 정보
		DB::table('kmh_address_info')
			->where('clinic_id', Auth::user()->clinic_id)
			->update(array(	
				'postcode' => $postcode,
				'address' => $address,
				'detail' => $detail,
				'address_en' => $address_en,
				'floor' => $floor,
				'd_upis' => date("Y-m-d H:i:s")
			)
		);

		//진료과목 삭제 처리한건 지우기
		if(is_array($s_id)) {
			DB::table('kmh_clinic_medical_subject')->where('clinic_id',Auth::user()->clinic_id)->whereNotIn('id',$s_id)->delete();
		} else {
			DB::table('kmh_clinic_medical_subject')->where('clinic_id',Auth::user()->clinic_id)->delete();
		}

		for($_i=0;$_i< count($s_id);$_i++) {
			if($s_id[$_i] == "0") {
			
				DB::table('kmh_clinic_medical_subject')->insertGetId(
					array(
						'clinic_id' => Auth::user()->clinic_id,
						'medical_subject_id' => $medical_subject_id[$_i],
						'special_doctor_count' => $special_doctor_count[$_i],
						'standard_doctor_count' => $standard_doctor_count[$_i]
					)
				);
			} else {

				DB::table('kmh_clinic_medical_subject')
					->where('id', $s_id[$_i])
					->update(array(			
						'medical_subject_id' => $medical_subject_id[$_i],
						'special_doctor_count' => $special_doctor_count[$_i],
						'standard_doctor_count' => $standard_doctor_count[$_i]
					)
				);	
			}
		}


		// 홈페이지 등록
		// 지운건 삭제
		if(is_array($h_id)) {
			DB::table('kmh_contact_info')->where('of','CLINIC')->where('of_id',Auth::user()->clinic_id)->where('sub_type_slug','OFFICE')->where('type_slug','HOMEPAGE')->whereNotIn('id',$h_id)->delete(); 
		} else {
			DB::table('kmh_contact_info')->where('of','CLINIC')->where('of_id',Auth::user()->clinic_id)->where('sub_type_slug','OFFICE')->where('type_slug','HOMEPAGE')->delete(); 
		}

		for($_i=0;$_i< count($h_id);$_i++) {
			if($h_id[$_i] == "0") {
			
				DB::table('kmh_contact_info')->insertGetId(
					array(
						'of' => 'CLINIC', 
						'of_id' => Auth::user()->clinic_id,
						'sub_type_slug' => 'OFFICE',
						'type_slug' => 'HOMEPAGE',
						'value' => $h_value[$_i],
						'language_slug' => $h_language_slug[$_i]
					)
				);
			} else {

				DB::table('kmh_contact_info')
					->where('id', $h_id[$_i])
					->update(array(			
						'of_id' => Auth::user()->clinic_id,
						'value' => $h_value[$_i],
						'language_slug' => $h_language_slug[$_i]
					)
				);	
			}
		}

		// 상담자 수정
		if(is_array($m_id)) {
			DB::table('kmh_manager')->where('clinic_id',Auth::user()->clinic_id)->whereNotIn('id',$m_id)->delete(); 
		} else {
			DB::table('kmh_manager')->where('clinic_id',Auth::user()->clinic_id)->delete(); 
		}

		for($_i=0;$_i< count($m_id);$_i++) {
			if($m_id[$_i] == "0") {
			
				DB::table('kmh_manager')->insertGetId(
					array(
						'clinic_id' => Auth::user()->clinic_id,
						'name' => $m_name[$_i],
						'tel' => $m_tel[$_i],
						'email' => $m_email[$_i],
						'language_slug' => $m_language_slug[$_i],
						'phone' =>  $m_phone[$_i]
						
					)
				);
			} else {
				DB::table('kmh_manager')
					->where('id', $m_id[$_i])
					->update(array(			
						'name' => $m_name[$_i],
						'tel' => $m_tel[$_i],
						'email' => $m_email[$_i],
						'language_slug' => $m_language_slug[$_i],
						'phone' =>  $m_phone[$_i]
					)
				);
			}
		}

		// 이미지 삭제 처리한건 지우기
		if(is_array($i_id)) {
			DB::table('kmh_media')->where('of','CLINIC')->where('of_id',Auth::user()->clinic_id)->whereNotIn('id',$i_id)->delete();
		} else {
			DB::table('kmh_media')->where('of','CLINIC')->where('of_id',Auth::user()->clinic_id)->delete();
		}

		// 등록된 이미지 등록		
		$folder = "/upload/clinic/image/".date('Y-m-d');
		$image_path = public_path().$folder;
		if (!is_dir($image_path)) {		
			@mkdir($image_path, 0777); 
		} 	


		if(count($img) > 0) {				
			$_i = 1;
			foreach($img as $file) {
				
				if (!is_null($file))
				{

					
					
					$file_name = date("YmdHis",time()).Auth::user()->clinic_id.$_i.".".$file->getClientOriginalExtension();

					

					$img = Image::make($file->getRealPath())->orientate()->save($image_path."/".$file_name);	
					

					DB::table('kmh_media')->insert(
						array(
							'of' => 'CLINIC', 
							'of_id' => Auth::user()->clinic_id,
							'path' => $folder."/".$file_name,
							'name' => $file->getClientOriginalName(),
							'd_regis' => date("Y-m-d H:i:s"),
							'size' => $file->getSize(),
							'extension' => $file->getClientOriginalExtension()
						)
					);						

					$_i++;
					
				}
			}
		}

		$file_path = "/upload/clinic/files/".date('Y-m-d');
		if (!is_dir(public_path().$file_path)) {
			
			@mkdir(public_path().$file_path, 0777); 
		} 	

		// 사업자번호 파일으 삭제 했다면
		if(!$b_id) DB::table('kmh_media')->where('of','CLINIC_BIZ_FILE')->where('of_id',Auth::user()->clinic_id)->delete();

		// 사업자등록증
		if (!is_null($biz_file)) {

			$file_name = date("YmdHis",time()).Auth::user()->clinic_id.".".$biz_file->getClientOriginalExtension();
			$biz_file->move(public_path().$file_path,$file_name);		
			
			DB::table('kmh_media')->insertGetId(
				array(
					'of' => 'CLINIC_BIZ_FILE', 
					'of_id' => Auth::user()->clinic_id,
					'path' => $file_path."/".$file_name,
					'name' => $biz_file->getClientOriginalName(),
					'd_regis' => date("Y-m-d H:i:s"),
					'size' => $biz_file->getSize(),
					'extension' => $biz_file->getClientOriginalExtension()
				)
			);
		}


		// 병상 정보
		DB::table('kmh_clinic_bed_count')
			->where('clinic_id', Auth::user()->clinic_id)
			->update(array(		
				'standard_bed_count' => $standard_bed_count,
				'birthing_bed_count' => $birthing_bed_count,
				'physical_therapy_bed_count' => $physical_therapy_bed_count,
				'new_born_intensive_care_bed_count' => $new_born_intensive_care_bed_count,
				'premium_bed_count' => $premium_bed_count,
				'adult_child_bed_count' => $adult_child_bed_count,
				'surgery_bed_count' => $surgery_bed_count,
				'emergency_bed_count' => $emergency_bed_count,
				'd_upis' => date("Y-m-d H:i:s")				
			)
		);


		// 진료시간
		for($_i=0;$_i< count($hour_id);$_i++) {

			// 있을 경우 수정
			if($hour_id[$_i]) {

				// 둘다 안적을 경우 삭제
				if( !trim($start[$_i])  and !trim($end[$_i]) ) {
					DB::table('kmh_business_hour')->where('id',$hour_id[$_i])->delete();
				} else {
					DB::table('kmh_business_hour')
						->where('id', $hour_id[$_i])
						->update(array(			
							'start' => $start[$_i],
							'end' => $end[$_i]
						)
					);
					
				}				

			// 없을 경우 등록
			} else {
				DB::table('kmh_business_hour')->insertGetId(
					array(
						'clinic_id' => Auth::user()->clinic_id,
						'day_id'  => $day_id[$_i],
						'day_slug' => $day_slug[$_i],
						'start' => $start[$_i],
						'end' => $end[$_i]
					)
				);
			}
		}


		

		

		return Redirect::to('/mypage/clinic/view')->withInput()->with('success', 'Your clinic information has been changed. ');
	}

	// 병원 회원 의사 리스트
	public function clinic_doctor() {

		// 병원 기본 정보
		$ClinicData = DB::table('kmh_clinic')
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')		
			->select('kmh_clinic.id','name','name_en','representative','representative_en','type_id','established','postcode','address','detail','address_en','floor','foreign_patient_attraction_clinic','business_registration_certificate_number','memo','x_pos','y_pos')
			->where('kmh_clinic.id',Auth::user()->clinic_id)			
			->first();	


		$ClinicDoctorData = DB::table('kmh_clinic_doctor');
		$ClinicDoctorData = $ClinicDoctorData->where('clinic_id',$ClinicData->id);
		$ClinicDoctorData = $ClinicDoctorData->orderBy('id', 'desc')->paginate(50);

		return view('member.clinic_doctor',compact('ClinicData','ClinicDoctorData'));
	}

	// 병원 회원 장비 리스트
	public function clinic_equipment() {

		// 병원 기본 정보
		$ClinicData = DB::table('kmh_clinic')
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')		
			->select('kmh_clinic.id','name','name_en','representative','representative_en','type_id','established','postcode','address','detail','address_en','floor','foreign_patient_attraction_clinic','business_registration_certificate_number','memo','x_pos','y_pos')
			->where('kmh_clinic.id',Auth::user()->clinic_id)			
			->first();

		$ClinicEquipmentData = DB::table('kmh_clinic_equipment');
		$ClinicEquipmentData = $ClinicEquipmentData->where('clinic_id',$ClinicData->id);
		$ClinicEquipmentData = $ClinicEquipmentData->orderBy('id', 'desc')->paginate(50);

		return view('member.clinic_equipment',compact('ClinicData','ClinicEquipmentData'));


	}

	// 병원 회원 시술 리스트
	public function clinic_procedure() {

		// 병원 기본 정보
		$ClinicData = DB::table('kmh_clinic')
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')		
			->select('kmh_clinic.id','name','name_en','representative','representative_en','type_id','established','postcode','address','detail','address_en','floor','foreign_patient_attraction_clinic','business_registration_certificate_number','memo','x_pos','y_pos')
			->where('kmh_clinic.id',Auth::user()->clinic_id)			
			->first();

		$ClinicProcedureData = DB::table('kmh_clinic_procedure');
		$ClinicProcedureData = $ClinicProcedureData->where('clinic_id',$ClinicData->id);
		$ClinicProcedureData = $ClinicProcedureData->orderBy('id', 'desc')->paginate(50);

		return view('member.clinic_procedure',compact('ClinicData','ClinicProcedureData'));


	}

	// 병원 회원 대표 시술 리스트
	public function clinic_popularProcedure() {


		// 병원 기본 정보
		$ClinicData = DB::table('kmh_clinic')
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')		
			->select('kmh_clinic.id','name','name_en','representative','representative_en','type_id','established','postcode','address','detail','address_en','floor','foreign_patient_attraction_clinic','business_registration_certificate_number','memo','x_pos','y_pos')
			->where('kmh_clinic.id',Auth::user()->clinic_id)			
			->first();

		$ClinicPopularProcedureData = DB::table('kmh_clinic_popular_procedure');
		$ClinicPopularProcedureData = $ClinicPopularProcedureData->where('clinic_id',$ClinicData->id);
		$ClinicPopularProcedureData = $ClinicPopularProcedureData->orderBy('id', 'desc')->paginate(50);

		return view('member.clinic_popularProcedure',compact('ClinicData','ClinicPopularProcedureData'));
		
		
	}


	// 병원 회원 전후 사진 리스트
	public function clinic_beforeAfter() {
		// 병원 기본 정보
		$ClinicData = DB::table('kmh_clinic')
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')		
			->select('kmh_clinic.id','name','name_en','representative','representative_en','type_id','established','postcode','address','detail','address_en','floor','foreign_patient_attraction_clinic','business_registration_certificate_number','memo','x_pos','y_pos')
			->where('kmh_clinic.id',Auth::user()->clinic_id)			
			->first();


		$ClinicBeforeAfterData = DB::table('kmh_clinic_before_after');
		$ClinicBeforeAfterData = $ClinicBeforeAfterData->where('clinic_id',$ClinicData->id);
		$ClinicBeforeAfterData = $ClinicBeforeAfterData->orderBy('id', 'desc')->paginate(50);

		
		return view('member.clinic_beforeAfter',compact('ClinicData','ClinicBeforeAfterData'));
	}

	// 의사 등록 처리
	public function doctor_add() {

		$id					= Input::get('id');							//받는 id
		$returnurl			= Input::get('returnurl');					//받는 returnurl

		$first_name_kr		= Input::get('first_name_kr');				//받는 한글 성
		$last_name_kr		= Input::get('last_name_kr');				//받는 한글 이름
		$first_name_en		= Input::get('first_name_en');				//받는 영문 성
		$last_name_en		= Input::get('last_name_en');				//받는 영문 이름
		$phone				= Input::get('phone');						//받는 전화번호
		$email				= Input::get('email');						//받는 이메일

		$education_id		= Input::get('education_id');				//받는 학교
		$newEducation		= Input::get('newEducation');				//받는 새로운 학교
		$addNewEducation	= Input::get('addNewEducation');			//받는 새로운 학교 유무


		$specialty_id		= Input::get('specialty_id');				//받는 전문의 배열
		$medical_subject_id	= Input::get('medical_subject_id');			//받는 진료과목 배열
		$d_img				= Input::file('d_img');						//받는 이미지 배열


		// 신규 학교이면
		if($addNewEducation == "on") {

			$temp_id = DB::table('kmh_education')->where('school_name',trim($newEducation))->value('id');
			// 있을경우
			if($temp_id) {
				$education_id = $temp_id;
			
			// 없을경우
			} else {
				$education_id = DB::table('kmh_education')->insertGetId(					
					array(
						'school_name' => trim($newEducation)
					)	
				);
			}
		}

		// 기본 정보 등록
		$doctor_id = DB::table('kmh_clinic_doctor')->insertGetId(					
			array(
				'clinic_id' => Auth::user()->clinic_id,
				'first_name_kr' => $first_name_kr, 
				'last_name_kr' => $last_name_kr,
				'first_name_en' => $first_name_en,
				'last_name_en' => $last_name_en,
				'phone' => $phone,
				'email' => $email,
				'education_id' => $education_id
			)	
		);

		if($doctor_id) {

			// 전문의 등록
			for($_i=0;$_i< count($specialty_id);$_i++) {
				if($specialty_id[$_i] != ""  ) {
					DB::table('kmh_clinic_doctor_specialty')->insert(
						array(
							'doctor_id' => $doctor_id,
							'specialty_id' => $specialty_id[$_i]
						)	
					);
				}
			}

			// 진료과목 등록
			for($_i=0;$_i< count($medical_subject_id);$_i++) {
				if($medical_subject_id[$_i] != ""  ) {
					DB::table('kmh_clinic_doctor_medical_subject')->insert(
						array(
							'doctor_id' => $doctor_id,
							'medical_subject_id' => $medical_subject_id[$_i]
						)	
					);
				}
			}

			// 이미지 등록	
			$image_path = public_path()."/upload/doctor/image/".date('Y-m-d');
			if (!is_dir($image_path)) {
				@mkdir($image_path, 0777); 
			} 
			if(count($d_img) > 0) {				
				$_i = 1;
				foreach($d_img as $file) {
					
					if (!is_null($file))
					{
						
						$file_name = date("YmdHis",time()).Auth::user()->clinic_id.$_i.".".$file->getClientOriginalExtension();
						$img = Image::make($file->getRealPath())->orientate()->save($image_path."/".$file_name);					
						DB::table('kmh_media')->insertGetId(
							array(
								'of' => 'DOCTOR', 
								'of_id' => $doctor_id,
								'path' => "/upload/doctor/image/".date('Y-m-d')."/".$file_name,
								'name' => $file->getClientOriginalName(),
								'd_regis' => date("Y-m-d H:i:s"),
								'size' => $file->getSize(),
								'type_slug' => 'IMAGE',
								'extension' => $file->getClientOriginalExtension()
							)
						);						

						$_i++;
						
					}
				}
			}

		}

		return Redirect::to($returnurl)->withInput()->with('success', 'Your doctor has been saved.');
	}

	// 병원 회원 의사 수정
	public function doctor_mod() {

		$doctor_id			= Input::get('doctor_id');							//받는 doctor_id
		$returnurl			= Input::get('returnurl');					//받는 returnurl

		$first_name_kr		= Input::get('first_name_kr');				//받는 한글 성
		$last_name_kr		= Input::get('last_name_kr');				//받는 한글 이름
		$first_name_en		= Input::get('first_name_en');				//받는 영문 성
		$last_name_en		= Input::get('last_name_en');				//받는 영문 이름
		$phone				= Input::get('phone');						//받는 전화번호
		$email				= Input::get('email');						//받는 이메일

		$education_id		= Input::get('education_id');				//받는 학교
		$newEducation		= Input::get('newEducation');				//받는 새로운 학교
		$addNewEducation	= Input::get('addNewEducation');			//받는 새로운 학교 유무


		$specialty_id		= Input::get('specialty_id');				//받는 전문의 배열
		$medical_subject_id	= Input::get('medical_subject_id');			//받는 진료과목 배열
		$d_img				= Input::file('d_img');						//받는 이미지 배열

		$doctor_specialty_uid			= Input::get('doctor_specialty_uid');			//받는 등록된 전문의 배열
		$doctor_medical_subject_uid		= Input::get('doctor_medical_subject_uid');		//받는 등록된 진료과목 배열
		$media_uid						= Input::get('media_uid');						//받는 등록된 이미지 배열


	
	
		// 기본 정보 수정
		DB::table('kmh_clinic_doctor')
		 ->where('id', $doctor_id)
		 ->update(array(
				'first_name_kr' => $first_name_kr, 
				'last_name_kr' => $last_name_kr,
				'first_name_en' => $first_name_en,
				'last_name_en' => $last_name_en,
				'phone' => $phone,
				'email' => $email,
				'education_id' => $education_id
			)	
		);

		// 삭제한 전문의 
		if(is_array($doctor_specialty_uid)) {
			DB::table('kmh_clinic_doctor_specialty')->where('doctor_id',$doctor_id)->whereNotIn('id',$doctor_specialty_uid)->delete();
			
		} else {
			DB::table('kmh_clinic_doctor_specialty')->where('doctor_id',$doctor_id)->delete();
		}

		// 삭제한 진료과목 배열 
		if(is_array($doctor_medical_subject_uid)) {
			DB::table('kmh_clinic_doctor_medical_subject')->where('doctor_id',$doctor_id)->whereNotIn('id',$doctor_medical_subject_uid)->delete();
		} else {
			DB::table('kmh_clinic_doctor_medical_subject')->where('doctor_id',$doctor_id)->delete();
		}

		// 삭제한 이미지 배열
		if(is_array($media_uid)) {
			DB::table('kmh_media')->where('of','DOCTOR')->where('of_id',$doctor_id)->whereNotIn('id',$media_uid)->delete();
		} else {
			DB::table('kmh_media')->where('of','DOCTOR')->where('of_id',$doctor_id)->delete();
		}

		return Redirect::to($returnurl)->withInput()->with('success', 'Your doctor information has been changed.');


	}

	// 병원 회원 의사 삭제
	public function doctor_del() {
		$id					= Input::get('id');							//받는 uid
		$returnurl			= Input::get('returnurl');					//받는 리턴url


		foreach ($id as $value) {
			DB::table('kmh_clinic_doctor')->where('id',$value)->delete();
			DB::table('kmh_clinic_doctor_specialty')->where('doctor_id',$value)->delete();
			DB::table('kmh_clinic_doctor_medical_subject')->where('doctor_id',$value)->delete();
			DB::table('kmh_media')->where('of','DOCTOR')->where('of_id',$value)->delete();

			
		}

		return Redirect::to($returnurl)->withInput()->with('danger', 'Your doctor has been deleted.');
	}

	// 병원 회원 장비 등록
	public function equipmentr_add() {

		$id							= Input::get('id');							//받는 id
		$returnurl					= Input::get('returnurl');					//받는 returnurl

		$equipment_id				= Input::get('equipment_id');				//받는 equipment_id
		$count						= Input::get('count');						//받는 count

		DB::table('kmh_clinic_equipment')->insertGetId(
			array(
				'clinic_id' => $id, 
				'equipment_id' => $equipment_id, 
				'count' => $count
			)
		);

		return Redirect::to($returnurl)->withInput()->with('success', 'Medical equipment information has been saved.');
	}

	// 병원 회원 장비 수정
	public function equipmentr_mod() {
		$equipmentr_id				= Input::get('equipmentr_id');				//받는 equipmentr_id
		$returnurl					= Input::get('returnurl');					//받는 returnurl

		$equipment_id				= Input::get('equipment_id');				//받는 facility
		$count						= Input::get('count');						//받는 line_number

		DB::table('kmh_clinic_equipment')
			->where('id', $equipmentr_id)
			 ->update(array(
					'equipment_id' => $equipment_id,
					'count' => $count
				)	
		);

		return Redirect::to($returnurl)->withInput()->with('success', 'Medical equipment information has been changed.');
	}

	// 병원 회원 장비 삭제
	public function equipmentr_del() {

		$id					= Input::get('id');							//받는 uid
		$returnurl			= Input::get('returnurl');					//받는 리턴url


		foreach ($id as $value) {
			DB::table('kmh_clinic_equipment')->where('id',$value)->delete();
			
		}

		return Redirect::to($returnurl)->withInput()->with('danger', 'Medical equipment information has been deleted.');
	}

	// 병원 회원 시술 등록
	public function procedure_add() {

		$id							= Input::get('id');							//받는 id
		$returnurl					= Input::get('returnurl');					//받는 returnurl

		$procedure_info_id			= Input::get('procedure_info_id');			// 시술 id 배열
		$score_slug					= Input::get('score_slug');					// 평점 배열
		$expense					= Input::get('expense');					// 수가 배열

		for($_i=0;count($procedure_info_id) > $_i; $_i++) {

			if($procedure_info_id[$_i]) {

				$procedureData = DB::table('kmh_clinic_procedure')->where('procedure_info_id',$procedure_info_id[$_i])->where('clinic_id', $id)->first();
				// 등록된것이 없으면
				if(count($procedureData) == 0) {
					DB::table('kmh_clinic_procedure')->insertGetId(
						array(
							'procedure_info_id' => $procedure_info_id[$_i],
							'clinic_id' => $id ,
							'score_slug' => $score_slug[$_i],
							'expense' =>  $expense[$_i]
						)
					);
				// 있으면
				} else {
					DB::table('kmh_clinic_procedure')
						->where('id', $procedureData->id)
						->update(array(			
							'score_slug' => $score_slug[$_i],
							'expense' =>  $expense[$_i]
						)
					);
				}
			}

		}

		return Redirect::to($returnurl)->withInput()->with('success', 'Treatment information has been saved.');
	}

	// 병원 회원 시술 수정
	public function procedure_mod() {
		$procedure_id				= Input::get('procedure_id');				//받는 procedure_id
		$returnurl					= Input::get('returnurl');					//받는 returnurl

		$score_slug					= Input::get('score_slug');					// 평점
		$expense					= Input::get('expense');					// 수가

		DB::table('kmh_clinic_procedure')
			->where('id', $procedure_id)
			->update(array(			
				'score_slug' => $score_slug,
				'expense' =>  $expense
			)
		);

		return Redirect::to($returnurl)->withInput()->with('success', 'Treatment information has been changed.');
	}

	// 병원 회원 시술 삭제
	public function procedure_del() {


		$id					= Input::get('id');							//받는 uid
		$returnurl			= Input::get('returnurl');					//받는 리턴url


		foreach ($id as $value) {
			DB::table('kmh_clinic_procedure')->where('id',$value)->delete();
			
		}

		return Redirect::to($returnurl)->withInput()->with('danger', 'Treatment information has been deleted. ');
	}

	// 병원 회원 대표 시술 등록
	public function popularprocedur_add() {

		$id					= Input::get('id');							// 받는 id
		$returnurl			= Input::get('returnurl');					// 받는 returnurl

		$title				= Input::get('title');						// 받는 제목
		$description		= Input::get('description');				// 받는 내용
		$p_img				= Input::file('p_img');						// 이미지


		

		$popular_procedure_id = DB::table('kmh_clinic_popular_procedure')->insertGetId(	
			array(
				'clinic_id' => $id, 
				'title' => $title, 
				'description' => $description
			)
		);

		if($popular_procedure_id) {


			$forder = "/upload/popular-procedure/image/".date('Y-m-d');
			$image_path = public_path().$forder;
			if (!is_dir($image_path)) {
				@mkdir($image_path, 0777); 
			} 


			if(count($p_img) > 0) {				
				$_i = 1;
				foreach($p_img as $file) {
					
					if (!is_null($file))
					{
						
						$file_name = date("YmdHis",time()).$id.$_i.".".$file->getClientOriginalExtension();
						$img = Image::make($file->getRealPath())->orientate()->save($image_path."/".$file_name);					
						DB::table('kmh_media')->insertGetId(
							array(
								'of' => 'CLINIC_POPULAR_PROCEDURE', 
								'of_id' => $popular_procedure_id,
								'path' => $forder."/".$file_name,
								'name' => $file->getClientOriginalName(),
								'd_regis' => date("Y-m-d H:i:s"),
								'size' => $file->getSize(),
								'extension' => $file->getClientOriginalExtension()
							)
						);						

						$_i++;
						
					}
				}
			}
		}

		return Redirect::to($returnurl)->withInput()->with('success', 'Special treatment information has been saved.');
	}

	// 병원 회원 대표 시술 수정
	public function popularprocedur_mod() {

		$popular_procedure_id		= Input::get('popular_procedure_id');				//받는 popular_procedure_id
		$returnurl					= Input::get('returnurl');							//받는 returnurl


		$title				= Input::get('title');						// 받는 제목
		$description		= Input::get('description');				// 받는 내용
		$p_img				= Input::file('p_img');						// 이미지

		$media_uid			= Input::get('media_uid');					// 이전 이미지 배열

		$popularProcedureData = DB::table('kmh_clinic_popular_procedure')->where('id', $popular_procedure_id)->first();

		// 삭제한 이미지 배열
		if(is_array($media_uid)) {
			DB::table('kmh_media')->where('of','CLINIC_POPULAR_PROCEDURE')->where('of_id',$popular_procedure_id)->whereNotIn('id',$media_uid)->delete();
		} else {
			DB::table('kmh_media')->where('of','CLINIC_POPULAR_PROCEDURE')->where('of_id',$popular_procedure_id)->delete();
		}

		$forder = "/upload/popular-procedure/image/".date('Y-m-d');
		$image_path = public_path().$forder;
		if (!is_dir($image_path)) {
			@mkdir($image_path, 0777); 
		} 


		if(count($p_img) > 0) {				
			$_i = 1;
			foreach($p_img as $file) {
				
				if (!is_null($file))
				{
					
					$file_name = date("YmdHis",time()).$popularProcedureData->id.$_i.".".$file->getClientOriginalExtension();
					$img = Image::make($file->getRealPath())->orientate()->save($image_path."/".$file_name);					
					DB::table('kmh_media')->insertGetId(
						array(
							'of' => 'CLINIC_POPULAR_PROCEDURE', 
							'of_id' => $popular_procedure_id,
							'path' => $forder."/".$file_name,
							'name' => $file->getClientOriginalName(),
							'd_regis' => date("Y-m-d H:i:s"),
							'size' => $file->getSize(),
							'extension' => $file->getClientOriginalExtension()
						)
					);						

					$_i++;
					
				}
			}
		}

		DB::table('kmh_clinic_popular_procedure')
			->where('id', $popular_procedure_id)
			->update(array(							
				'title' => $title,
				'description' => $description
			)
		);

		return Redirect::to($returnurl)->withInput()->with('success', 'Special treatment information has been changed.');
	}

	// 병원 회원 대표 시술 삭제
	public function popularprocedur_del() {

		$id					= Input::get('id');							//받는 uid
		$returnurl			= Input::get('returnurl');					//받는 리턴url


		foreach ($id as $value) {

			DB::table('kmh_clinic_popular_procedure')->where('id',$value)->delete();
			DB::table('kmh_media')->where('of' , 'CLINIC_POPULAR_PROCEDURE')->where('of_id',$value)->delete();

			
		}

		return Redirect::to($returnurl)->withInput()->with('danger', 'Special treatment information has been deleted.');
	}

	// 병원 회원 전후 사진 등록
	public function beforeAfter_add() {
		$id					= Input::get('id');							//받는 id
		$returnurl			= Input::get('returnurl');					//받는 returnurl

		$title				= Input::get('title');						//받는 제목
	
		$b_img				= Input::file('b_img');						//받는 전 사진
		$a_img				= Input::file('a_img');						//받는 후 사진

		$forder = "/upload/beforeClinic/image/".date('Y-m-d');
		$image_path = public_path().$forder;
		if (!is_dir($image_path)) {
			@mkdir($image_path, 0777); 
		} 	

		$previous_media_id = 0;
		$after_media_id = 0;

		if (!is_null($b_img))
		{
			
			$file_name = date("YmdHis",time()).$id."_b.".$b_img->getClientOriginalExtension();
			$img = Image::make($b_img->getRealPath())->orientate()->save($image_path."/".$file_name);	
			
			$previous_media_id = DB::table('kmh_media')->insertGetId(			
				array(
					'of' => 'CLINIC_BEFORE_AFTER', 
					'of_id' => $id,
					'path' => $forder."/".$file_name,
					'name' => $b_img->getClientOriginalName(),
					'd_regis' => date("Y-m-d H:i:s"),
					'size' => $b_img->getSize(),
					'type_slug' => 'IMAGE',
					'extension' => $b_img->getClientOriginalExtension()
				)
			);			
		}

		if (!is_null($a_img))
		{
			
			$file_name = date("YmdHis",time()).$id."_a.".$a_img->getClientOriginalExtension();
			$img = Image::make($a_img->getRealPath())->orientate()->save($image_path."/".$file_name);	
			
			$after_media_id = DB::table('kmh_media')->insertGetId(			
				array(
					'of' => 'CLINIC_BEFORE_AFTER', 
					'of_id' => $id,
					'path' => $forder."/".$file_name,
					'name' => $a_img->getClientOriginalName(),
					'd_regis' => date("Y-m-d H:i:s"),
					'size' => $a_img->getSize(),
					'type_slug' => 'IMAGE',
					'extension' => $a_img->getClientOriginalExtension()
				)
			);			
		}


		DB::table('kmh_clinic_before_after')->insertGetId(
			array(
				'clinic_id' => $id, 
				'previous_media_id' => $previous_media_id, 
				'after_media_id' => $after_media_id,
				'title' => $title
			)
		);

		return Redirect::to($returnurl)->withInput()->with('success', 'Before and After photo has been saved.');
	}

	// 병원 회원 전후 사진 수정
	public function beforeAfter_mod() {

		$beforeafter_id		= Input::get('beforeafter_id');				//받는 beforeafter_id
		$returnurl			= Input::get('returnurl');					//받는 returnurl

		$title				= Input::get('title');						//받는 제목
	
		$b_img				= Input::file('b_img');						//받는 전 사진
		$a_img				= Input::file('a_img');						//받는 후 사진

		$previous_media_id	= Input::get('previous_media_id');			//받는 전 사진 id
		$after_media_id		= Input::get('after_media_id');				//받는 후 사진 id


		$beforeAfterData = DB::table('kmh_clinic_before_after')->where('id', $beforeafter_id)->first();

		// 전 사진 삭제 했을 경우 
		if(!$previous_media_id) {
			DB::table('kmh_media')->where('id',$beforeAfterData->previous_media_id)->delete();
		}

		// 후 사진 삭제 했을 경우
		if(!$after_media_id	) {
			DB::table('kmh_media')->where('id',$beforeAfterData->after_media_id)->delete();
		}

		$forder = "/upload/beforeClinic/image/".date('Y-m-d');
		$image_path = public_path().$forder;
		if (!is_dir($image_path)) {
			@mkdir($image_path, 0777); 
		} 	

		if (!is_null($b_img))
		{
			
			$file_name = date("YmdHis",time()).$beforeAfterData->clinic_id."_b.".$b_img->getClientOriginalExtension();
			$img = Image::make($b_img->getRealPath())->orientate()->save($image_path."/".$file_name);	
			
			$previous_media_id = DB::table('kmh_media')->insertGetId(			
				array(
					'of' => 'CLINIC_BEFORE_AFTER', 
					'of_id' => $beforeAfterData->clinic_id,
					'path' => $forder."/".$file_name,
					'name' => $b_img->getClientOriginalName(),
					'd_regis' => date("Y-m-d H:i:s"),
					'size' => $b_img->getSize(),
					'type_slug' => 'IMAGE',
					'extension' => $b_img->getClientOriginalExtension()
				)
			);			
		}

		if (!is_null($a_img))
		{
			
			$file_name = date("YmdHis",time()).$beforeAfterData->clinic_id."_a.".$a_img->getClientOriginalExtension();
			$img = Image::make($a_img->getRealPath())->orientate()->save($image_path."/".$file_name);	
			
			$after_media_id = DB::table('kmh_media')->insertGetId(			
				array(
					'of' => 'CLINIC_BEFORE_AFTER', 
					'of_id' => $beforeAfterData->clinic_id,
					'path' => $forder."/".$file_name,
					'name' => $a_img->getClientOriginalName(),
					'd_regis' => date("Y-m-d H:i:s"),
					'size' => $a_img->getSize(),
					'type_slug' => 'IMAGE',
					'extension' => $a_img->getClientOriginalExtension()
				)
			);			
		}

		DB::table('kmh_clinic_before_after')
			->where('id', $beforeafter_id)
			->update(array(			
				'previous_media_id' => $previous_media_id,
				'after_media_id' =>  $after_media_id,
				'title' => $title
			)
		);

		return Redirect::to($returnurl)->withInput()->with('success', 'Before and After photo has been changed.');
	}

	// 병원 회원 전후 사진 삭제
	public function beforeAfter_del() {

		$id					= Input::get('id');							//받는 uid
		$returnurl			= Input::get('returnurl');					//받는 리턴url


		foreach ($id as $value) {
			$beforeAfterData = DB::table('kmh_clinic_before_after')->where('id', $value)->first();
			DB::table('kmh_media')->where('id',$beforeAfterData->previous_media_id)->delete();
			DB::table('kmh_media')->where('id',$beforeAfterData->after_media_id)->delete();

			DB::table('kmh_clinic_before_after')->where('id',$value)->delete();


			
		}

		return Redirect::to($returnurl)->withInput()->with('danger', 'Before and After photo has been deleted.');
	}


	// 병원 회원용 상담 리스트
	public function inquiry_clinic() {

		$InquiryData = DB::table('kmh_inquiry')
			->select('kmh_inquiry.id','kmh_inquiry.clinic_id','name_url','kmh_inquiry.d_regis','address_en','name_en','content','body_part_id','procedure_info_id')
			->join('kmh_clinic', 'kmh_clinic.id', '=', 'kmh_inquiry.clinic_id')
			->join('kmh_address_info', 'kmh_address_info.clinic_id', '=', 'kmh_clinic.id')
			->where('kmh_inquiry.clinic_id',Auth::user()->clinic_id)
			->whereNotNull('unique_key')
			->where('name_en','!=','')
			->where('is_del','0')
			->orderBy('kmh_inquiry.d_regis','desc')->paginate(20);


	

		return view('member.inquiry_clinic',compact('InquiryData'));
	}


	// 병원 관리자 신청
	public function admin_app() {

		$id					= Input::get('id');							//받는 uid
		$returnurl			= Input::get('returnurl');					//받는 리턴url


		$id = DB::table('kmh_clinic_admin_app')->insertGetId(
			array(	
				'user_id' => Auth::user()->id,
				'clinic_id' => $id
			)
		);

		return "1";


		

//		return Redirect::to($returnurl)->withInput()->with('success', 'Clinic management request has been submitted.');
	}

	// 상담 메시지 삭제 
	public function inquiry_message_del() {

		$id					= Input::get('id');							//받는 uid
		$returnurl			= Input::get('returnurl');					//받는 리턴url

		DB::table('kmh_inquiry_message')->where('id', $id)->delete();

		return Redirect::to($returnurl)->withInput()->with('danger', 'Your message has been deleted.');
	}




	

	
}
