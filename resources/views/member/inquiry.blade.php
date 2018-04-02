@extends('layouts.master')
@section('content')
<?php
$color_array = array('green','gold','red','purple');
?>

<section class="subheader">
  <div class="container">
    <h1>Inquiry</h1>
    <div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/mypage" class="current">Inquiry</a></div>
    <div class="clear"></div>
  </div>
</section>

<section class="module favorited-properties">
  <div class="container">
	
  
	<div class="row ">
		<div class="col-lg-3 col-md-3 sidebar-left">
			@include('member.left_menu')		
			
		</div>

		<div class="col-lg-9 col-md-9">

			 @if(Session::has('success'))			
			 <div class="row">
				<div class="col-lg-12">
					<div class="alert-box success"><i class="fa fa-check icon"></i> {{ Session::get('success') }}</div>
				</div>
			</div>
			@endif
			@if(Session::has('danger'))
			
			 <div class="row">
				<div class="col-lg-12">
					<div class="alert-box error"><i class="fa fa-close icon"></i> {{ Session::get('danger') }}</div>
				</div>
			</div>
			@endif
			
			<div class="row grid-blog">
			<?php $_i = 0 ?>
			@foreach($InquiryData as $data)
			<?php
				 $ClinicMedicalSubjectName = DB::table('kmh_clinic_medical_subject')
					->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
					->where('clinic_id',$data->clinic_id)->orderBy('kmh_clinic_medical_subject.id', 'desc')->value('name_en');

				if(!$ClinicMedicalSubjectName) $ClinicMedicalSubjectName = "all";

				$medical_subject_url = $ClinicMedicalSubjectName."/";
				$medical_subject_url = str_replace(" ","-",$medical_subject_url);
				
				$url = "/clinic/".$medical_subject_url.$data->name_url."#address";

				$clinic_img = DB::table('kmh_media')->where('of','CLINIC')->where('of_id',$data->clinic_id)->orderBy('id', 'desc')->value('path');
				if(!$clinic_img) $clinic_img = "/front/images/1837x1206.png";



				$str_date = $data->d_regis;

				$date = date("M d Y", strtotime( $str_date ) )."<br>". date("h:i A", strtotime( $str_date ) );

				$addr_arry = explode(",",$data->address_en);
				$addr = $data->address_en;
				if(count($addr_arry) > 3 ) $addr = $addr_arry[count($addr_arry)-2].", ".$addr_arry[count($addr_arry)-1];

				$messageCount = DB::table('kmh_inquiry_message')->where('inquiry_id',$data->id)->count('id');

				$messageData = DB::table('kmh_inquiry_message')->where('inquiry_id',$data->id)->orderBy('id','desc')->first();

				$body_part_name = "";
				if($data->body_part_id) {
					$body_part_name = DB::table('kmh_procedure_info')->where('id',$data->body_part_id)->value('name_en');
				}

				$procedure_info_name = "";
				if($data->procedure_info_id) {
					$procedure_info_name = DB::table('kmh_procedure_info')->where('id',$data->procedure_info_id)->value('name_en');
				}



				$is_confirm = DB::table('kmh_inquiry_message')->where('is_confirm','0')->where('inquiry_id',$data->id)->where('user_id','!=',Auth::user()->id)->count('id');		

			?>
				<div class="col-lg-4 col-md-4">
				<!-- <button type="button" class="btn btn-xs btn-danger">asdfsdf	</button> -->
					<div class="blog-post blog-post-creative shadow-hover">
						<div class="blog-post-img">
							<a href="/mypage/inquiryView?id={{$data->id}}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}">
							<img src="{{$clinic_img}}" alt="" />
							<div class="img-fade"></div>						
							<div class="img-overlay {{$color_array[$_i % 4]}}"></div>
							
							</a>
						</div>
						<div class="content blog-post-content">
							<h3><a href="/mypage/inquiryView?id={{$data->id}}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}">{{$data->name_en}}</a></h3>
							<ul class="blog-post-details">
								<a href="/mypage/inquiryView?id={{$data->id}}&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}">
							  @if($is_confirm)
							  <li style="color:#d9534f"><i class="fa fa-envelope icon"></i>New</li>
							  @else 
							  <li><i class="fa fa-envelope icon"></i>New</li>							  
							  @endif							  
							  <li><i class="fa fa-comment-o icon"></i>{{ number_format($messageCount)}} Threads</li>
							  </a>
							</ul>
							@if($body_part_name or $procedure_info_name)
							<p style="color:#48a0dc">
								<strong>#{{$body_part_name}} @if($procedure_info_name) ▶ #{{$procedure_info_name}} @endif</strong>
							</p>
							@endif
							@if(count($messageData) > 0 )
							<p>
							<?php echo mb_substr($messageData->message, 0, 140, "UTF-8"); ?>
							</p>
							@endif
						</div>
					</div>
				</div>

			<?php $_i++ ?>
			@endforeach
			</div>



			
			<div class="pagination">
				<div class="center">
					{!! $InquiryData->links('vendor.pagination.bootstrap-4') !!}
				</div>
				<div class="clear"></div>
			</div>

			
		
		</div><!-- end col -->
	</div><!-- end row -->

  </div><!-- end container -->
</section>


@include('layouts.footer')

@include('layouts.js')

<script>
function fnInquiryDel(id) {

	if (confirm('Are you sure you want to delete this?    '))
	{
		 url = "/del/inquiry?id="+id+"&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";
		 location.href=url;
	}	
}
</script>

@stop