<?php
use Illuminate\Support\Facades\Input;

$body_part_id =  Input::get('body_part_id');
$procedure_info_id = Input::get('procedure_info_id');
$medical_id = Input::get('medical_id');
$area = Input::get('area');


$procedureData	= DB::table('kmh_procedure_info')->where('depth',2)->where('parent_id',1)->orderBy('id', 'asc')->get();

$procedureSubData	= DB::table('kmh_procedure_info')->where('depth',3)->where('parent_id',$body_part_id)->orderBy('id', 'asc')->get();

$medicalData	= DB::table('kmh_medical_subject')->orderBy('name_en', 'asc')->get();

$areaData = DB::table('kmh_code')->where('group_code', 'C0005')->where('group_value','>','0')->orderBy('group_ord', 'asc')->get();
?>

<div class="widget widget-sidebar sidebar-properties advanced-search hidden-xs hidden-sm">
	<h4><span>Advanced Search</span> <img src="/front/images/divider-half-white.png" alt="" /></h4>
	<div class="widget-content box">
	<form  autocomplete="off" method="get" action="/find-my-clinic">
		<div class="form-block border">
			<label for="property-location">Select a body part</label>
			<select name="body_part_id" class="border" id="body-part-select" >
				<option value="">Any</option>
				<?php $__currentLoopData = $procedureData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($data->id); ?>" <?php if($body_part_id ==$data->id ): ?> selected="selected" <?php endif; ?>><?php echo e($data->name_en); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>					
			</select>
		</div>
		<div class="form-block border">
			<label for="property-status">Select a treatment</label>
			<select name="procedure_info_id"  class="border" id="procedure-info-select">
				<option value="">Any</option>
				<?php $__currentLoopData = $procedureSubData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($data->id); ?>" <?php if($procedure_info_id ==$data->id ): ?> selected="selected" <?php endif; ?>><?php echo e($data->name_en); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		
			</select>
		</div>
		<div class="form-block border">
			<label for="property-type">Location</label>
			<select id="property-type" class="border" name="area">
				<option value="">Any</option>
				<?php $__currentLoopData = $areaData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($data->group_value); ?>" <?php if($area == $data->group_value): ?> selected="selected" <?php endif; ?>><?php echo e($data->group_str); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
		</div>
		<div class="form-block border">
			<label for="property-type">Select a medical department</label>
			<select id="property-type" class="border" name="medical_id">
				<option value="">Any</option>
				<?php $__currentLoopData = $medicalData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($data->id); ?>" <?php if($medical_id ==$data->id ): ?> selected="selected" <?php endif; ?>><?php echo e($data->name_en); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
			</select>
		</div>	

		<div class="form-block">
			<input type="submit" class="button" value="Find" />
		</div>
	</form>
	</div><!-- end widget content -->
</div><!-- end widget -->

<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header " style="background:#48a0dc;">
				<button type="button" class="close" data-dismiss="modal" style="color:#FFF">&times;</button>
				<h4 class="modal-title"  style="color:#FFF">Advanced Search</h4>
			</div>
			<div class="modal-body">
				<div class="widget-content box">
				<form  autocomplete="off" method="get" action="/find-my-clinic">
					<div class="form-block border">
						<label for="property-location">Select a body part</label>
						<select name="body_part_id"   class="border " id="p_body-part-select">
							<option value="">Any</option>
							<?php $__currentLoopData = $procedureData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($data->id); ?>" <?php if($body_part_id ==$data->id ): ?> selected="selected" <?php endif; ?>><?php echo e($data->name_en); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>					
						</select>
					</div>
					<div class="form-block border">
						<label for="property-status">Select a treatment</label>
						<select name="procedure_info_id"  class="border " id="p_procedure-info-select">
							<option value="">Any</option>
							<?php $__currentLoopData = $procedureSubData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($data->id); ?>" <?php if($procedure_info_id ==$data->id ): ?> selected="selected" <?php endif; ?>><?php echo e($data->name_en); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		
						</select>
					</div>
					<div class="form-block border">
						<label for="property-type">Location</label>
						<select id="property-type" class="border" name="area">
							<option value="">Any</option>
							<?php $__currentLoopData = $areaData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($data->group_value); ?>"><?php echo e($data->group_str); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</select>
					</div>
					<div class="form-block border">
						<label for="property-type">Select a medical department</label>
						<select id="property-type" class="border" name="medical_id">
							<option value="">Any</option>
							<?php $__currentLoopData = $medicalData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($data->id); ?>" <?php if($medical_id ==$data->id ): ?> selected="selected" <?php endif; ?>><?php echo e($data->name_en); ?></option>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
						</select>
					</div>	

					<div class="form-block">
						<input type="submit" class="button " value="Find" />
					</div>
				</form>
				</div><!-- end widget content -->
			</div>     
		</div>
	</div>
</div>