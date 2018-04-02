@extends('layouts.master')
@section('content')
<link href="/front/css/jquery.fancybox.min.css" rel="stylesheet" />
<?php
$favorite = 0;
if(!Auth::guest()) {

	if(DB::table('user_favorite_clinic')->where('clinic_id',$ClinicData->id)->where('user_id',Auth::user()->id)->count('id')) {
		$favorite = 1;
	}
}
?>


<section class="subheader" style="padding-top: 80px;">
	<div class="container">
		<!-- <h1>Property Single</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> Find My Clinic <i class="fa fa-angle-right"></i> <a href="{{ $_SERVER['REQUEST_URI'] }}" class="current">{{$ClinicData->name_en}}</a></div> -->
		<div class="clear"></div>
	</div>
</section>

<section class="module">
	<div class="container">  
		<div class="row">
			<div class="col-lg-8 col-md-8">		
				 @if(Session::has('success'))			
				 <div class="row">
					<div class="col-lg-12">
						<div class="alert-box success"><i class="fa fa-check icon"></i> <?php echo  Session::get('success') ?></div>
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
				<div class="property-single-item property-main">
					<div class="property-header">
						<div class="property-title">							
							<h4>{{$ClinicData->name_en}}</h4>
							<!-- <div class="property-price-single right">$255,000 <span>Per Month</span></div> -->
							<p class="property-address"><i class="fa fa-map-marker icon"></i>{{$ClinicData->address_en}}</p>
							<div class="clear"></div>
							<a href="/send-multiple-inquiry?id[]={{$ClinicData->id}}&returnurl={{ $_SERVER['REQUEST_URI'] }}" class="button grey small right" >SEND INQUIRY</a>
							<div class="clear"></div>
						</div>
						<!-- <div class="property-single-tags">
							<div class="property-tag button alt featured right">Join</div>
						</div> -->
					</div>

					<table class="property-details-single">
						<tr>
							<td><i class="fa fa-user-md"></i> <span>{{ number_format(count($ClinicDoctorData)) }}</span> Doctors</td>
							<td><i class="fa fa-anchor"></i>  Since <span>{{ substr($ClinicData->established,6,4)}}</span></td>
							<td><i class="fa fa-bed"></i> <span>{{number_format($Bed_total)}}</span> Beds</td>
							<td>
								@if(!Auth::guest())									
									<i @if(Auth::user()->level != "3") onclick="fufavorite({{$ClinicData->id}})"  @endif class="fa favorite_{{$ClinicData->id}} @if($favorite) fa-heart star_on_color  @else fa-heart-o star_off_color @endif icon " style="cursor:pointer"></i> 
								@else 
								<a href="/login" ><i class="fa fa-heart-o star_off_color icon"  ></i>&nbsp;</a>
								@endif
								<span id="favorite_count">{{ number_format($favoriteCount) }}</span> Favorite</td>
						</tr>
					</table>
					<div class="property-gallery">
						<div class="slider-nav slider-nav-property-gallery">
							<span class="slider-prev"><i class="fa fa-angle-left"></i></span>
							<span class="slider-next"><i class="fa fa-angle-right"></i></span>
						</div>
						<div class="slide-counter"></div>
						<div class="slider slider-property-gallery">
							@foreach($IMAGEData as $data)
							<div class="slide"><img src="{{$data->path}}" alt="" width="100%"/></div>
							@endforeach
						</div>
						<div class="slider property-gallery-pager">
							@foreach($IMAGEData as $data)
							<a class="property-gallery-thumb"><img src="{{$data->path}}" alt="" width="100%"/></a>
							@endforeach
						</div>
					</div>
				</div><!-- end property title and gallery -->

				<?php

				$adminCount = DB::table('users')->where('clinic_id',$ClinicData->id)->count('id');

				?>
				@if(!$adminCount)
				<div class="row" >
					<div class="col-lg-12 text-right">
						@if(@Auth::guest()) 
							<a href="/login" >Is this your clinic?</a>
						@else
							@if(Auth::user()->level != "3")
							<a href="javascript:" onclick="fnClinicReg({{$ClinicData->id}})">Is this your clinic?</a>
							@endif
						
						@endif
					</div>
				</div>
				@endif

				<div class="widget property-single-item property-description content">
					<h4>
						<span>Profile</span> 
						<img class="divider-hex" src="/front/images/divider-half.png" alt="" />

					</h4>
					
					<div class="row" style="margin-top:10px">						
						<div class="col-md-4"><strong>Medical Department</strong></div>
						<div class="col-md-8">
							@if(count($ClinicMedicalSubjectData) > 0 )
								<?php $index = 1; ?>
								@foreach($ClinicMedicalSubjectData as $data)
									{{$data->name_en}}
									@if( $index != count($ClinicMedicalSubjectData)), @endif
									<?php $index++ ?>
								@endforeach
							@else 
								information unavailable
							@endif								
						</div>
					</div>
					
					
					<div class="row" style="margin-top:10px">
						<div class="col-md-4"><strong>Specialty Hospital</strong></div>
						<div class="col-md-8">
							@if(count($SpecialHospitalData) > 0)
								<?php $index = 1; ?>
								@foreach($SpecialHospitalData as $data)
									{{$data->name_en}}
									@if( $index != count($SpecialHospitalData)), @endif
									<?php $index++ ?>
								@endforeach
							@else 
								information unavailable
							@endif
						</div>
					</div>

					
					<div class="row" style="margin-top:10px">
						<div class="col-md-4"><strong>Specialized Treatment</strong></div>
						<div class="col-md-8">
							@if(count($SpecialProcedureData) > 0 )
								<?php $index = 1; ?>
								@foreach($SpecialProcedureData as $data)
									{{$data->name_en}}
									@if( $index != count($SpecialProcedureData)), @endif
									<?php $index++ ?>
								@endforeach
							@else 
								information unavailable
							@endif
						</div>
					</div>
					<div class="row" style="margin-top:10px">
						<div class="col-md-4"><strong>Medical Equipment </strong></div>
						<div class="col-md-8">
							@if(count($EquipmentData) > 0 )
								<?php $index = 1; ?>
								@foreach($EquipmentData as $data)
									{{$data->name_en}}
									@if( $index != count($EquipmentData)), @endif
									<?php $index++ ?>
								@endforeach
							@else 
								information unavailable
							@endif


							
						</div>
					</div>
					<div class="clear"></div>		
					

					<div class="tabs" style="margin-top:30px;">
						<ul>
						  <li><a href="#tabs-1"><i class="fa fa-bed icon"></i>Bed</a></li>
						</ul>
						<div id="tabs-1" class="ui-tabs-hide">
							<ul class="additional-details-list">
								<li>Regular Patient Room: <span>{{ number_format($ClinicBedData->standard_bed_count) }}</span></li>
								<li>Operating Room: <span>{{ number_format($ClinicBedData->surgery_bed_count) }}</span></li>
								<li>Physical Therapy Room: <span>{{ number_format($ClinicBedData->physical_therapy_bed_count) }}</span></li>
								<li>Delivery Room: <span>{{ number_format($ClinicBedData->birthing_bed_count) }}</span></li>
								<li>NICU: <span>{{ number_format($ClinicBedData->new_born_intensive_care_bed_count) }}</span></li>
								<li>Superior Patient Room: <span>{{ number_format($ClinicBedData->premium_bed_count) }}</span></li>
								<li>Emergency Room: <span>{{ number_format($ClinicBedData->emergency_bed_count) }}</span></li>
								<li>ICU/PICU: <span>{{ number_format($ClinicBedData->adult_child_bed_count) }}</span></li>
							</ul>
						</div>
					</div>
					<div class="tabs" style="margin-top:30px;">
						<ul>						 
						  <li><a href="#tabs-2"><i class="fa fa-stethoscope icon"></i>Treatment</a></li>
						</ul>
						<div id="tabs-2" >
							<ul class="additional-details-list">
								@foreach($ClinicProcedureData as $data)
									@if($ClinicData->is_inquiry)
									<li>
										<a href="/send-multiple-inquiry?id[]={{$ClinicData->id}}&body_part_id={{$data->parent_id}}&procedure_info_id={{$data->id}}&returnurl={{ $_SERVER['REQUEST_URI'] }}">
										{{$data->name_en}}: 
										<span><?php echo $data->expense ? $data->expense : "Ask clinic" ?>@if(!$data->expense)&nbsp;&nbsp;<i class="fa fa-envelope-o" ></i>@endif</span>
										</a>
									</li>
									@endif
								@endforeach
							</ul>
						
						</div>
					</div>
					<div class="tabs" style="margin-top:30px;">
						<ul>							  
						  <li><a href="#tabs-3"><i class="fa fa-clock-o icon"></i>Office Hours</a></li>
						</ul>
						<div id="tabs-3" >
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
								<li>Mon: <span>{{$mon_s}}~ {{$mon_e}}</span></li>
								<li>Tue: <span>{{$tue_s}}~ {{$tue_e}}</span></li>
								<li>Wed: <span>{{$wed_s}}~ {{$wed_e}}</span></li>
								<li>Thu: <span>{{$thu_s}}~ {{$thu_e}}</span></li>
								<li>Fri: <span>{{$fri_s}}~ {{$fri_e}}</span></li>
								<li>Sat: <span>{{$sat_s}}~ {{$sat_e}}</span></li>
								<li style="color:#cc0000"><strong>Sun</strong>: <span>{{$sun_s}}~ {{$sun_e}}</span></li>
								<li style="color:#ffcc00"><strong>Lunch</strong>: <span>{{$lun_s}}~ {{$lun_e}}</span></li>
								
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

				</h4>
				@foreach($ClinicDoctorData as $data)
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


					

				?>
				<a id="doctor{{$data->id}}"></a>
				<div class="agent">
					<a href="#doctor{{$data->id}}" class="agent-img text-center">
						<!-- <div class="img-fade"></div> -->
						<!-- <div class="button alt agent-tag">68 Properties</div> -->
						<img src="{{$doctor_img}}" alt="" style="width: auto;  height: 150px;"  />
			        </a>
			        <div class="agent-content">
						<!-- <a href="#" class="button button-icon small right"><i class="fa fa-angle-right"></i>Contact Agent</a>
						<a href="#" class="button button-icon small grey right"><i class="fa fa-angle-right"></i>Agent Details</a> -->
						<div class="agent-details">
							<h4><a href="#doctor{{$data->id}}">Dr. {{ucwords($data->first_name_en)}} {{ucwords($data->last_name_en)}}</a></h4>			                
			                @if($specialty)<p><i class="fa fa-stethoscope icon"></i>{{ $specialty }}</p>@endif
							@if($education_name)<p><i class="fa fa-graduation-cap icon"></i>{{ $education_name }}</p>@endif
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
				@endforeach

			</div><!-- end agent -->


			@if(count($ClinicPopularProcedureData) > 0 )
			<div class="widget property-single-item property-agent">
				<h4>
					<span>Special Treatment</span> <img class="divider-hex" src="/front/images/divider-half.png" alt="" />

				</h4>
				@foreach($ClinicPopularProcedureData as $data)
				<?php
					$MediaData	= DB::table('kmh_media')->where('of','CLINIC_POPULAR_PROCEDURE')->where('of_id',$data->id)->get(); 
				?>
				
				<div class="agent">
					<h5>{{$data->title}}</h5>
					<div class="row">						
						@if(count($MediaData) > 0 )
						<div class="col-lg-12 ">
							
							<div >
								@foreach($MediaData as $img)
								<figure>
									<figcaption style="float:left;margin-right:5px;">
										<a class="fancybox" rel="group_{{$data->id}}" href="{{$img->path}}" ><img src="{{$img->path}}" alt="{{$img->path}}"></a>
									</figcaption>
								</figure>
								<!-- <img src="{{$img->path}}" width="100"/> -->
								@endforeach
							</div>
							
							<div class="clear"></div>	
						</div>
						@endif
						<div class="col-lg-12 " style="margin-top:10px;">
							<?php echo str_replace(chr(13),'<br />',$data->description) ?>
						</div>

					</div>
					<div class="clear"></div>	
				</div>
				<hr>
				@endforeach
			</div>
			@endif

			@if(count($ClinicBeforeAfterData) > 0 )
			<div class="widget property-single-item property-agent">
				<h4>
					<span>Before & After</span> <img class="divider-hex" src="/front/images/divider-half.png" alt="" />

				</h4>
				@foreach($ClinicBeforeAfterData as $data)
				<?php
					$previous_img  = DB::table('kmh_media')->where('id', $data->previous_media_id)->value('path');
					$after_img  = DB::table('kmh_media')->where('id', $data->after_media_id)->value('path');
				?>
				<div class="agent">
					<h5>{{$data->title}}</h5>
					<div class="row">						
						<div class="col-lg-6 text-center">
							<img src="{{$previous_img}}" style="width: 100%;  height: auto;margin-bottom:10px;" />
						</div>
						<div class="col-lg-6 text-center">
							<img src="{{$after_img}}" style="width: 100%;  height: auto;margin-bottom:10px;" />
						</div>
					</div>
					<div class="clear"></div>	
				</div>
				<hr>
				@endforeach
			</div>
			@endif

			<a id="address"></a>
			<div class="widget property-single-item property-location">
				<h4>
					<span>Location</span> <img class="divider-hex" src="/front/images/divider-half.png" alt="" />
					
				</h4>
				<div id="map-single"></div>
				<div class="agent-details" style="margin-top:10px">
					<div class="row" style="margin-bottom:20px">
						<div class="col-xs-3 col-sm-2"><img src="/front/images/icon-location-taxi.png" /></div>
						<div class="col-xs-9 col-sm-10">* Please show this message to the driver.<br>위 손님을 아래의 주소로 모셔다 주십시오.<br>{{ $ClinicData->address}}</div>
					</div>
					<div class="row" style="margin-bottom:20px">
						<div class="col-xs-3 col-sm-2"><img src="/front/images/icon-location-car.png" /></div>
						<div class="col-xs-9 col-sm-10">{{ $ClinicData->address_en}}</div>
					</div>
					<!-- <p><img src="/front/images/icon-location-metro.png" style="max-width:50px;"/> (123) 456-6789</span></p>
					<p><img src="/front/images/icon-location-bus.png" style="max-width:50px;"/> (123) 456-6789</span></p> -->
					
				</div>
				<div class="row">
					<div class="col-xs-6">
						<button type="button" class="btn btn-primary btn-block"  onclick="openUrl('https://www.google.com/maps/place/{{ $ClinicData->address_en}}')">Get direction</button>
					</div>
					<div class="col-xs-6">
						<button type="button" class="btn btn-info btn-block"  onclick="copyToClipboard('{{ $ClinicData->address_en}}')">Copy the address</button>
					</div>
				</div>
			</div><!-- end location -->
			
		</div><!-- end col -->
		
		<div class="col-lg-4 col-md-4 sidebar sidebar-property-single">		
			@include('layouts.clinic_search')
			@include('layouts.popural_treatment')
			@include('layouts.popural_doctor')


		</div><!-- end row -->
	</div><!-- end container -->
</section>

@include('layouts.footer')

@include('layouts.js')
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqb3fT3SbMSDMggMEK7fJOIkvamccLrjA&sensor=false"></script>
<script src="/front/js/jquery.fancybox.js"></script>

<script>
jQuery(document).ready(function(){
  jQuery(".fancybox").fancybox();
});


//intialize the map
function initialize() {
  var mapOptions = {
    zoom: 15,
    scrollwheel: false,
    center: new google.maps.LatLng("{{$ClinicData->y_pos}}", "{{$ClinicData->x_pos}}")
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
var contentString = '<div class="info-box"><h4>{{$ClinicData->name_en}}</h4><p>{{$ClinicData->address_en}}</p><br/></div>';

var infowindow = new google.maps.InfoWindow({ content: contentString });

google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map,marker);
  });

}

google.maps.event.addDomListener(window, 'load', initialize);


function fufavorite(id) {

	var count = parseInt($('#favorite_count').html());
	$.ajax({
		url:'/member/favoriteAdd?id='+id,
		type:'get',				
		success:function(data){	

				
		
			
			if(data == 1) {

				$('#favorite_count').html(count + 1);
				$(".favorite_"+id).addClass("star_on_color");
				$(".favorite_"+id).addClass("fa-heart");
				$(".favorite_"+id).removeClass("fa-heart-o");
				$(".favorite_"+id).removeClass("star_off_color");

			} else if(data == 2)  {
				$('#favorite_count').html(count - 1);
				$(".favorite_"+id).removeClass("star_on_color");
				$(".favorite_"+id).removeClass("fa-heart");
				$(".favorite_"+id).addClass("fa-heart-o");
				$(".favorite_"+id).addClass("star_off_color");
			} 			
			
		},
		complete : function(data) {
			 
	   },
		error:function(request,status,error){	
	   }
	})
}


function fnClinicReg(clinic_id) {
	url = "/modal/clinic_admin/reg?clinic_id="+clinic_id+"&returnurl={{ urlencode($_SERVER['REQUEST_URI']) }}";

  
	
	$("#Modal .modal-content").load(url, function() { 
		 $("#Modal").modal("show"); 
	});
}



function copyToClipboard(str) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(str).select();
    document.execCommand("copy");
    $temp.remove();
    alert('Clinic address copied to your clipboard!');
}

function openUrl(url) {
    window.open(
        url,
        '_blank'
    );
}
</script>
@stop