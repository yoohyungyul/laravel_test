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


class ModalController extends Controller
{
    // 의사 등록
	public function doctorAdd() {
		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');

		$specialtyData = DB::table('kmh_specialty')->orderBy('name', 'asc')->get(); 
		$medicalSubjectData = DB::table('kmh_medical_subject')->orderBy('gov_name', 'asc')->get();
		$educationData = DB::table('kmh_education')->orderBy('school_name', 'asc')->get();



		return view('modal.doctorAdd',compact('id','specialtyData','medicalSubjectData','educationData','returnurl'));
	}

	// 의사 수정
	public function doctorMod() {
		
		$doctor_id					= Input::get('doctor_id');
		$returnurl					= Input::get('returnurl');

		$specialtyData				= DB::table('kmh_specialty')->orderBy('name', 'asc')->get(); 
		$medicalSubjectData			= DB::table('kmh_medical_subject')->orderBy('gov_name', 'asc')->get();
		$educationData				= DB::table('kmh_education')->orderBy('school_name', 'asc')->get();


		$DoctorData					= DB::table('kmh_clinic_doctor')->where('id',$doctor_id)->first(); 
		$DoctorSpecialtyData		= DB::table('kmh_clinic_doctor_specialty')->select('kmh_clinic_doctor_specialty.id','name')->join('kmh_specialty', 'kmh_specialty.id', '=', 'kmh_clinic_doctor_specialty.specialty_id')->where('doctor_id',$doctor_id)->get(); 
		$DoctorMedicalSubjectData	= DB::table('kmh_clinic_doctor_medical_subject')->select('kmh_clinic_doctor_medical_subject.id','gov_name')->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_doctor_medical_subject.medical_subject_id')->where('doctor_id',$doctor_id)->get(); 
		$MediaData					= DB::table('kmh_media')->where('of','DOCTOR')->where('of_id',$doctor_id)->get(); 

		return view('modal.doctorMod',compact('doctor_id','DoctorData','DoctorSpecialtyData','DoctorMedicalSubjectData','MediaData','specialtyData','medicalSubjectData','educationData','returnurl'));


	}

	// 간호등급 등록
	public function nursingAdd() {

		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');

		$nursingGradeData	= DB::table('kmh_nursing_grade')->orderBy('gov_name', 'asc')->get(); 


		return view('modal.nursingAdd',compact('nursingGradeData','id','returnurl'));
	}

	// 간호등급 수정
	public function nursingMod() {

		$nursing_id			= Input::get('nursing_id');
		$returnurl			= Input::get('returnurl');


		$clinicNursingGrade		= DB::table('kmh_clinic_nursing_grade')->where('id',$nursing_id)->first();

		$nursingGradeData	= DB::table('kmh_nursing_grade')->orderBy('gov_name', 'asc')->get(); 


		return view('modal.nursingMod',compact('clinicNursingGrade','nursingGradeData','nursing_id','returnurl'));
	}

	// 특수 진료 등록
	public function specialAdd() {

		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');		

		$specialProcedureData	= DB::table('kmh_special_procedure')->orderBy('gov_name', 'asc')->get(); 


		return view('modal.specialAdd',compact('specialProcedureData','id','returnurl'));
	}

	// 특수 진료 수정
	public function specialMod() {
		$special_id			= Input::get('special_id');
		$returnurl			= Input::get('returnurl');

		$clinicSpecialProcedure		= DB::table('kmh_clinic_special_procedure')->where('id',$special_id)->first();

		$specialProcedureData	= DB::table('kmh_special_procedure')->orderBy('gov_name', 'asc')->get(); 

		return view('modal.specialMod',compact('clinicSpecialProcedure','specialProcedureData','special_id','returnurl'));		
	}

	// 교통정보 등록
	public function transAdd() {

		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');		

		return view('modal.transAdd',compact('id','returnurl'));
	}

	// 교통전보 수정
	public function transMod() {
		$trans_id			= Input::get('trans_id');
		$returnurl			= Input::get('returnurl');

		

		$clinicTransportation = DB::table('kmh_clinic_transportation')->where('id',$trans_id)->first();
	

		return view('modal.transMod',compact('clinicTransportation','trans_id','returnurl'));		

		
	}

	// 장비 정보 등록
	public function equipmentrAdd() {

		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');	

		$equipmentData	= DB::table('kmh_equipment')->orderBy('gov_name', 'asc')->get();
		

		return view('modal.equipmentrAdd',compact('equipmentData','id','returnurl'));

	}

	// 장비 정보 수정
	public function equipmentrMod() {

		$equipmentr_id		= Input::get('equipmentr_id');
		$returnurl			= Input::get('returnurl');

		

		$clinicEquipment = DB::table('kmh_clinic_equipment')->where('id',$equipmentr_id)->first();

		$equipmentData	= DB::table('kmh_equipment')->orderBy('gov_name', 'asc')->get();
	

		return view('modal.equipmentrMod',compact('clinicEquipment','equipmentData','equipmentr_id','returnurl'));		
	}

	// 시술 정보 등록
	public function procedureAdd() {
		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');	

		$procedureData	= DB::table('kmh_procedure_info')->where('depth','1')->orderBy('id', 'asc')->get();

		return view('modal.procedureAdd',compact('procedureData','id','returnurl'));
	}

	// 시술 정보 수정
	public function procedureMod() {
		$procedure_id		= Input::get('procedure_id');
		$returnurl			= Input::get('returnurl');	




		$clinicProcedure = DB::table('kmh_clinic_procedure')
			->join('kmh_procedure_info', 'kmh_procedure_info.id', '=', 'kmh_clinic_procedure.procedure_info_id')
			->where('kmh_clinic_procedure.id',$procedure_id)->first();


		$ThirdProcedureData = DB::table('kmh_procedure_info')->where('id', $clinicProcedure->procedure_info_id)->first();
		$SecondProcedureData = DB::table('kmh_procedure_info')->where('id', $ThirdProcedureData->parent_id)->first();
		$FirstProcedureData = DB::table('kmh_procedure_info')->where('id', $SecondProcedureData->parent_id)->first();

		$procedure = $FirstProcedureData->name ."> ".$SecondProcedureData->name."> ".$ThirdProcedureData->name;


		return view('modal.procedureMod',compact('clinicProcedure','procedure_id','procedure','returnurl'));	
	}

	// 전후 사진 등록
	public function beforeafterAdd() {

		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');			

		return view('modal.beforeafterAdd',compact('id','returnurl'));
	}

	// 전후 사진 수정
	public function beforeafterMod() {

		$beforeafter_id		= Input::get('beforeafter_id');
		$returnurl			= Input::get('returnurl');	
		
		$clinicBeforeAfter = DB::table('kmh_clinic_before_after')->where('id',$beforeafter_id)->first();

		return view('modal.beforeafterMod',compact('clinicBeforeAfter','beforeafter_id','returnurl'));	

	}

	// 대표 시술 등록
	public function popularprocedureAdd() {
		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');			

		return view('modal.popularprocedureAdd',compact('id','returnurl'));
	}

	// 대표 시술 수정
	public function popularprocedureMod() {

		$popular_procedure_id		= Input::get('popular_procedure_id');
		$returnurl					= Input::get('returnurl');	

		$clinicPopularProcedure = DB::table('kmh_clinic_popular_procedure')->where('id',$popular_procedure_id)->first();

		$MediaData					= DB::table('kmh_media')->where('of','CLINIC_POPULAR_PROCEDURE')->where('of_id',$popular_procedure_id)->get(); 

		return view('modal.popularprocedureMod',compact('clinicPopularProcedure','popular_procedure_id','MediaData','returnurl'));	
	}


	// 병원 회원 의사 등록
	public function user_doctorAdd() {

		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');

		$specialtyData = DB::table('kmh_specialty')->orderBy('name', 'asc')->get(); 
		$medicalSubjectData = DB::table('kmh_medical_subject')->orderBy('gov_name', 'asc')->get();
		$educationData = DB::table('kmh_education')->orderBy('school_name', 'asc')->get();



		return view('modal.user_doctorAdd',compact('id','specialtyData','medicalSubjectData','educationData','returnurl'));
	}

	// 병원 회원 의사 수정
	public function user_doctorMod() {
		$doctor_id					= Input::get('doctor_id');
		$returnurl					= Input::get('returnurl');

		$specialtyData				= DB::table('kmh_specialty')->orderBy('name', 'asc')->get(); 
		$medicalSubjectData			= DB::table('kmh_medical_subject')->orderBy('gov_name', 'asc')->get();
		$educationData				= DB::table('kmh_education')->orderBy('school_name', 'asc')->get();


		$DoctorData					= DB::table('kmh_clinic_doctor')->where('id',$doctor_id)->first(); 
		$DoctorSpecialtyData		= DB::table('kmh_clinic_doctor_specialty')->select('kmh_clinic_doctor_specialty.id','name')->join('kmh_specialty', 'kmh_specialty.id', '=', 'kmh_clinic_doctor_specialty.specialty_id')->where('doctor_id',$doctor_id)->get(); 
		$DoctorMedicalSubjectData	= DB::table('kmh_clinic_doctor_medical_subject')->select('kmh_clinic_doctor_medical_subject.id','gov_name')->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_doctor_medical_subject.medical_subject_id')->where('doctor_id',$doctor_id)->get(); 
		$MediaData					= DB::table('kmh_media')->where('of','DOCTOR')->where('of_id',$doctor_id)->get(); 

		return view('modal.user_doctorMod',compact('doctor_id','DoctorData','DoctorSpecialtyData','DoctorMedicalSubjectData','MediaData','specialtyData','medicalSubjectData','educationData','returnurl'));


	}

	// 병원 회원 장비 등록
	public function user_equipmentrAdd() {

		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');	

		$equipmentData	= DB::table('kmh_equipment')->orderBy('gov_name', 'asc')->get();
		

		return view('modal.user_equipmentrAdd',compact('equipmentData','id','returnurl'));
	}

	// 병원 회원 장비 수정
	public function user_equipmentrMod() {

		$equipmentr_id		= Input::get('equipmentr_id');
		$returnurl			= Input::get('returnurl');

		

		$clinicEquipment = DB::table('kmh_clinic_equipment')->where('id',$equipmentr_id)->first();

		$equipmentData	= DB::table('kmh_equipment')->orderBy('gov_name', 'asc')->get();
	

		return view('modal.user_equipmentrMod',compact('clinicEquipment','equipmentData','equipmentr_id','returnurl'));		


	}

	// 병원 회원 시술 정보 등록
	public function user_procedureAdd() {
		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');	

		$procedureData	= DB::table('kmh_procedure_info')->where('depth','2')->orderBy('id', 'asc')->get();

		return view('modal.user_procedureAdd',compact('procedureData','id','returnurl'));
	}

	// 병원 회원 시술 정보 수정
	public function user_procedureMod() {
		$procedure_id		= Input::get('procedure_id');
		$returnurl			= Input::get('returnurl');	




		$clinicProcedure = DB::table('kmh_clinic_procedure')
			->join('kmh_procedure_info', 'kmh_procedure_info.id', '=', 'kmh_clinic_procedure.procedure_info_id')
			->where('kmh_clinic_procedure.id',$procedure_id)->first();


		$ThirdProcedureData = DB::table('kmh_procedure_info')->where('id', $clinicProcedure->procedure_info_id)->first();
		$SecondProcedureData = DB::table('kmh_procedure_info')->where('id', $ThirdProcedureData->parent_id)->first();
		$FirstProcedureData = DB::table('kmh_procedure_info')->where('id', $SecondProcedureData->parent_id)->first();

		$procedure = $FirstProcedureData->name ."> ".$SecondProcedureData->name."> ".$ThirdProcedureData->name;


		return view('modal.user_procedureMod',compact('clinicProcedure','procedure_id','procedure','returnurl'));	
	}

	// 병원 회원 대표 시술 등록
	public function user_popularprocedureAdd() {

		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');			

		return view('modal.user_popularprocedureAdd',compact('id','returnurl'));
	}



	// 병원 회원 대표 시술 수정
	public function user_popularprocedureMod() {
		$popular_procedure_id		= Input::get('popular_procedure_id');
		$returnurl					= Input::get('returnurl');	

		$clinicPopularProcedure = DB::table('kmh_clinic_popular_procedure')->where('id',$popular_procedure_id)->first();

		$MediaData					= DB::table('kmh_media')->where('of','CLINIC_POPULAR_PROCEDURE')->where('of_id',$popular_procedure_id)->get(); 

		return view('modal.user_popularprocedureMod',compact('clinicPopularProcedure','popular_procedure_id','MediaData','returnurl'));	
	}

	// 병원 회원 전후 사진 등록
	public function user_beforeafterAdd() {

		$id					= Input::get('id');
		$returnurl			= Input::get('returnurl');			

		return view('modal.user_beforeafterAdd',compact('id','returnurl'));
	}

	// 병원 회원 전후 사진 수정
	public function user_beforeafterMod() {

		$beforeafter_id		= Input::get('beforeafter_id');
		$returnurl			= Input::get('returnurl');	
		
		$clinicBeforeAfter = DB::table('kmh_clinic_before_after')->where('id',$beforeafter_id)->first();



		return view('modal.user_beforeafterMod',compact('clinicBeforeAfter','beforeafter_id','returnurl'));	

	}

	// 병원 관리자 신청
	public function clinic_admin_reg() {

		$clinic_id		= Input::get('clinic_id');
		$returnurl		= Input::get('returnurl');	

		$ClinicData = DB::table('kmh_clinic')
			->where('id',$clinic_id)			
			->first();	


		return view('modal.clinic_admin_reg',compact('ClinicData','returnurl'));	
	}

	// 배너 등록
	public function banner_add() {

		$area			= Input::get('area');
		$gubun			= Input::get('gubun');
		$returnurl		= Input::get('returnurl');	

		$procedureData	= DB::table('kmh_procedure_info')->where('depth','2')->orderBy('id', 'asc')->get();

		return view('modal.banner_add',compact('area','gubun','procedureData','returnurl'));	


	}


	// 사이트 상담 보기
	public function contactView() {

		$id			= Input::get('id');


		$quickContactData = DB::table('kmh_quick_contact')->where('id',$id)->first();

		return view('modal.contactView',compact('quickContactData'));	

	}

	// 비밀번호 변경
	public function PwMod() {

	

		$id				= Input::get('id');						//받는 id


		return view('modal.PwMod',compact('id'));
	}


	public function test() {

		
		/*
		$data = array();
		$data['content'] = '';	  
		$data['clinic'] = '';	  
		$data['procedure'] = '';	 

		$data['user_id'] = '';	 
		$data['name'] = '';	 
		$data['email'] = '';	 
		$data['gender'] = '';	 
		$data['birthday'] = '';	 
		$data['d_regis'] = date("Y-m-d H:i:s");			


		Mail::send('emails.test', ['data' => $data], function ($m)  {
			$m->from('medicalkorea.korea@gmail.com', 'sdfsdf');

			$m->to('george@hnconsulting.co.kr', 'george@hnconsulting.co.kr')->subject('테스트로 발송함');
		});
		*/
		
		
	}

	


}
