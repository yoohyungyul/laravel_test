
<?php $__env->startSection('content'); ?>




<section class="subheader subheader-listing-sidebar" style="background:#787c8a url(/front/images/find-my-clinic-top-bg.jpg) no-repeat center;padding-top: 80px;">
	<div class="container" >
		<?php if($body_part_id or $procedure_info_id): ?>		
		<?php
		//	echo $body_part_id."_".$procedure_info_id;
		$body_part_name = DB::table('kmh_procedure_info')->where('id',$body_part_id)->value('name_en');
		$procedure_info_name = DB::table('kmh_procedure_info')->where('id',$procedure_info_id)->value('name_en');
		?>

		<h5 style="color:#fff;">#<?php echo e($body_part_name); ?> <?php if($procedure_info_name): ?>- #<?php echo e($procedure_info_name); ?><?php endif; ?> </h5>
		<div class="clear"></div>
		<?php endif; ?>
		<!-- <h1>FIND MY CLINIC</h1> -->
		
		<!-- <div class="clear"></div>
		<div class="breadcrumb right" style="color:#fff;padding:0px;margin:0px">Home <i class="fa fa-angle-right"></i> <a href="/find-my-clinic" class="current">Find My Clinic</a></div> -->
		<div class="clear"></div>		
	</div>
</section>


<section class="module">
	<div class="container">  
		<div class="row">
			<div class="col-lg-8 col-md-8">	
				 <?php if(Session::has('success')): ?>			
				 <div class="row">
					<div class="col-lg-12">
						<div class="alert-box success"><i class="fa fa-check icon"></i> <?php echo  Session::get('success') ?></div>
					</div>
				</div>
				<?php endif; ?>
				<?php if(Session::has('danger')): ?>
				
				 <div class="row">
					<div class="col-lg-12">
						<div class="alert-box error"><i class="fa fa-close icon"></i> <?php echo e(Session::get('danger')); ?></div>
					</div>
				</div>
				<?php endif; ?>

				<div class="property-listing-header">
					<span class="property-count left"><strong><?php echo e(number_format($ClinicData->total())); ?></strong> clinics found</span>
					
					<button type="button" class="button grey small right" onclick="fnMultipleInquiry('id[]')">Multiple Inquiry</button>
					<div class="property-layout-toggle right hidden-md hidden-lg">
						<button class="button  small right" data-toggle="modal" data-target="#myModal" >Advanced Search</button>
					</div>
				
					
					
					<div class="clear"></div>
				</div><!-- end property listing header -->
				<form name="form_list"  method="get"  action="/send-multiple-inquiry">	
				<input type="hidden" name="returnurl" value="<?php echo e($_SERVER['REQUEST_URI']); ?>" />
				<input type="hidden" name="body_part_id" value="<?php echo e($body_part_id); ?>" />
				<input type="hidden" name="procedure_info_id" value="<?php echo e($procedure_info_id); ?>" />
				<?php $__currentLoopData = $ClinicData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php
					$ClinicMedicalSubjectName = DB::table('kmh_clinic_medical_subject')
						->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
						->where('clinic_id',$data->id)->orderBy('kmh_clinic_medical_subject.id', 'desc')->value('name_en');

					if(!$ClinicMedicalSubjectName) $ClinicMedicalSubjectName = "all";

					$medical_subject_url = $ClinicMedicalSubjectName."/";
					$medical_subject_url = str_replace(" ","-",$medical_subject_url);
					
					$url = "/clinic/".$medical_subject_url.$data->name_url;

					$clinic_img = DB::table('kmh_media')->where('of','CLINIC')->where('of_id',$data->id)->orderBy('id', 'desc')->value('path');
					if(!$clinic_img) $clinic_img = "/front/images/1837x1206.png";


					// 병원 의사 정보
					$DoctorCount = DB::table('kmh_clinic_doctor');
					$DoctorCount = $DoctorCount->where('clinic_id',$data->id);
					$DoctorCount = $DoctorCount->orderBy('id', 'desc')->count('id');

				
					
					$addr_arry = explode(",",$data->address_en);
					$addr = $data->address_en;
					if(count($addr_arry) > 3 ) $addr = $addr_arry[count($addr_arry)-2].", ".$addr_arry[count($addr_arry)-1];

					$type_name = DB::table('kmh_clinic_type')->where('id',$data->type_id)->value('name_en');

					// 병원 진료 정보
					$ClinicMedicalSubjectData = DB::table('kmh_clinic_medical_subject')
						->join('kmh_medical_subject', 'kmh_medical_subject.id', '=', 'kmh_clinic_medical_subject.medical_subject_id')
						->where('clinic_id',$data->id)->orderBy('kmh_clinic_medical_subject.id', 'asc')->get();

					$favorite = 0;
					if(!Auth::guest()) {
					
						if(DB::table('user_favorite_clinic')->where('clinic_id',$data->id)->where('user_id',Auth::user()->id)->count('id')) {
							$favorite = 1;
						}
					}
	
				?>
			
				<div class="property property-row property-row-sidebar shadow-hover">
					<a href="<?php echo e($url); ?>" class="property-img">
						<div class="img-fade"></div>
						<!-- <div class="property-tag button status"></div> -->
						
						<div class="property-color-bar"></div>
						<img src="<?php echo e($clinic_img); ?>" alt="" />
					</a>
					<div class="property-content">
						<div class="property-title">
							<h4><a href="<?php echo e($url); ?>"><?php echo e($data->name_en); ?></a></h4>
							<p class="property-address" style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;"><i class="fa fa-map-marker icon"></i><?php echo e($addr); ?></p>
							<div class="clear"></div>
							<p class="property-text" style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;margin-bottom:0px;">Type: <?php echo e($type_name); ?></p>
							<p class="property-text" style="width: 100%;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;margin-top:0px;">Department : 
								<?php if(count($ClinicMedicalSubjectData) > 0 ): ?>
									<?php $index = 1; ?>
									<?php $__currentLoopData = $ClinicMedicalSubjectData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php echo e($m_data->name_en); ?>

										<?php if( $index != count($ClinicMedicalSubjectData)): ?>, <?php endif; ?>
										<?php $index++ ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php else: ?> 
									information unavailable
								<?php endif; ?>								
							</p>
						</div>
						<table class="property-details">
							<tr>

								<td><i class="fa fa-user-md"></i> <?php echo e(number_format($DoctorCount)); ?> Doctor<?php if($DoctorCount > 1 ) echo "s" ?></td>
								<td><i class="fa fa-anchor"></i> Since <?php echo e(substr($data->established,6,4)); ?></td>
							</tr>
						</table>
					</div>
					<div class="property-footer">
						<span class="left" style="color:#fff;padding-top:6px;"><?php if($data->is_inquiry): ?><label><input type="checkbox"  class="chk" name="id[]" value="<?php echo e($data->id); ?>"/>Select to Send multiple Inquiry</label><?php endif; ?></span>
						<span class="right">
							<!-- <a class="a2a_dd" href="https://www.addtoany.com/share"><i class="fa fa-share-alt"></i>&nbsp;</a>
							<a href="#"><i class="fa fa-heart-o icon"></i></a>
							<a href="#"><i class="fa fa-envelope-o"></i></a> -->
							<span class="button " style="padding-left:10px;padding-right:10px;">
								<a class="a2a_dd" href="https://www.addtoany.com/share"><i class="fa fa-share-alt" style="color:#fff;"></i>&nbsp;&nbsp;</a>
								<?php if(!Auth::guest()): ?>
								<a href="javascript:" <?php if(Auth::user()->level != "3"): ?> onclick="fufavorite(<?php echo e($data->id); ?>)" <?php endif; ?> ><i class="fa favorite_<?php echo e($data->id); ?> <?php if($favorite): ?> fa-heart star_on_color  <?php else: ?> fa-heart-o star_off_color <?php endif; ?> icon "></i>&nbsp;</a>
								<?php else: ?>
								<a href="/login" ><i class="fa fa-heart-o star_off_color "  style="font-size:18px;cursor:pointer"></i>&nbsp;</a>
								<?php endif; ?>

								<?php if($data->is_inquiry): ?>
								<a href="/send-multiple-inquiry?id[]=<?php echo e($data->id); ?>&body_part_id=<?php echo e($body_part_id); ?>&procedure_info_id=<?php echo e($procedure_info_id); ?>&returnurl=<?php echo e($_SERVER['REQUEST_URI']); ?>"><i class="fa fa-envelope-o" style="color:#fff"></i>&nbsp;</a>
								<?php endif; ?>
							</span>
							<!-- <a href="<?php echo e($url); ?>" class="button button-icon"><i class="fa fa-angle-right"></i>Details</a> -->
						</span>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</form>
				
				<div class="pagination">
					<div class="center">
						<?php echo $ClinicData->appends(['body_part_id' => $body_part_id])->appends(['procedure_info_id' => $procedure_info_id])->appends(['medical_id' => $medical_id])->appends(['area' => $area])->links('vendor.pagination.bootstrap-4'); ?>

					</div>
					<div class="clear"></div>
				</div>
		
			</div><!-- end listing -->
		
			<div class="col-lg-4 col-md-4 sidebar">			
				

				<?php echo $__env->make('layouts.clinic_search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<?php echo $__env->make('layouts.popural_treatment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<?php echo $__env->make('layouts.popural_doctor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

			</div><!-- end sidebar -->		
		</div><!-- end row -->
	</div><!-- end container -->
</section>



<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
$("#body-part-select").change(function (event) {

	var bodyPartId = $("#body-part-select").val();	

    $.ajax({
		url: '/ajax/procedure_info_list',
        data: 'body_part_id=' + bodyPartId,
        type: 'get',
        dataType: 'json',
        beforeSend: function (xhr) {
			xhr.setRequestHeader("Accept", "application/json");       
		}
    }).done(function (data) {

		$('#procedure-info-select').children().remove().end().append('<option selected value="">Any</option>') ;

		$.each(data, function (i, item) {
			$('#procedure-info-select').append($('<option>', { 
				value: item.id,
				text : item.nameEn 
			}));
		});

		$('#procedure-info-select').chosen().trigger("chosen:updated");
     });
});

$("#p_body-part-select").change(function (event) {

	var bodyPartId = $("#p_body-part-select").val();	

    $.ajax({
		url: '/ajax/procedure_info_list',
        data: 'body_part_id=' + bodyPartId,
        type: 'get',
        dataType: 'json',
        beforeSend: function (xhr) {
			xhr.setRequestHeader("Accept", "application/json");       
		}
    }).done(function (data) {

		$('#p_procedure-info-select').children().remove().end().append('<option selected value="">Any</option>') ;

		$.each(data, function (i, item) {
			$('#p_procedure-info-select').append($('<option>', { 
				value: item.id,
				text : item.nameEn 
			}));
		});

		$('#p_procedure-info-select').chosen().trigger("chosen:updated");
     });
});


function fnMultipleInquiry(obj) {

	var i, sum=0, tag=[], str="";
    var chk = document.getElementsByName(obj);
    var tot = chk.length;
    for (i = 0; i < tot; i++) {
        if (chk[i].checked == true) {
            tag[sum] = chk[i].value;
            sum++;
        }
    }	

    if(tag.length == 0)  {
		alert("Select at least 1 clinic!");
		return false;
	}

	document.form_list.submit();
	
}


function fufavorite(id) {
	$.ajax({
		url:'/member/favoriteAdd?id='+id,
		type:'get',				
		success:function(data){	
		
			
			if(data == 1) {
				$(".favorite_"+id).addClass("star_on_color");
				$(".favorite_"+id).addClass("fa-heart");
				$(".favorite_"+id).removeClass("fa-heart-o");
				$(".favorite_"+id).removeClass("star_off_color");

			} else if(data == 2)  {
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

</script>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>