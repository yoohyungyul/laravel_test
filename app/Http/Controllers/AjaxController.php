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

class AjaxController extends Controller
{

	
 
	// 시술 리스트
	public function procedure() {
		$depth		= Input::get('depth');
		$value		= Input::get('value');

		$procedureData	= DB::table('kmh_procedure_info')->where('depth',$depth)->where('parent_id',$value)->orderBy('id', 'asc')->get();


		// 2차일 경우
		if($depth == "2") {
			$str = "<select  class='form-control' onchange='fnProcedure(\"3\",this.value)' ><option value=''>선택</option>";

			foreach($procedureData as $data) {
				$str .=	"<option value='".$data->id."'>".$data->name."</option>";
			}
			$str .=	"</select>";
		
		// 3차일 경우
		} else {
			$str = "";

			foreach($procedureData as $data) {

				$str .= '

				<div class="row">
					<div class="col-lg-4 form-group">
						<div class="checkbox-custom checkbox-primary ">		
							<input type="checkbox" name="procedure_info_id[]" value="'.$data->id.'" />
							<label for="inputUnchecked" style="padding-right:40px;padding-bottom:10px;">'.$data->name.'</label>	
						</div>
					</div>
					<div class="col-lg-4 form-group">
						<select  class="form-control " name="score_slug[]"  >
							<option value="0">선택</option>
							<option value="5">★★★★★</option>
							<option value="4">★★★★</option>
							<option value="3">★★★</option>
							<option value="2">★★</option>
							<option value="1">★</option>
						</select>
					</div>
					<div class="col-lg-4 form-group">
						<input type="text" class="form-control" name="expense[]" placeholder="수가">
					</div>
				</div>	';
			}
		}

		

		return $str;
	}

	// 시술 정보 리스트
	public function procedure_info_list() {
		$body_part_id		= Input::get('body_part_id');

		$procedure = array();

		$procedureData	= DB::table('kmh_procedure_info')->where('depth',3)->where('parent_id',$body_part_id)->orderBy('id', 'asc')->get();

		foreach($procedureData as $data) {

			
			$procedure[] = array("id" => $data->id,"nameEn" => $data->name_en);
		}


		return response()->json($procedure);
		
	}

	// 시술 정보 관리 
	public function procedure_info_sub() {

		$id   = Input::get('id');

		$procedure = array();

		$procedureData	= DB::table('kmh_procedure_info')->where('depth',3)->where('parent_id',$id)->orderBy('id', 'asc')->get();

		foreach($procedureData as $data) {

			
			$procedure[] = array("img" => $data->img,"id" => $data->id,"name" => $data->name,"nameEn" => $data->name_en);
		}


		return response()->json($procedure);


	}
	
}
