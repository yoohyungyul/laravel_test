
<?php $__env->startSection('content'); ?>

<section class="subheader">
	<div class="container">
		<h1>Agent Listing Row Sidebar</h1>
		<div class="breadcrumb right">Home <i class="fa fa-angle-right"></i> <a href="/doctors" class="current">Doctors</a></div>
		<div class="clear"></div>
	</div>
</section>

<section class="module">
	<div class="container">
		<div class="row">	
			<div class="col-lg-8 col-md-8"> 
				
				<?php $__currentLoopData = $DoctorData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

				<?php

					$clinic_name_url = DB::table('kmh_clinic')->where('id',$data->clinic_id)->value('name_en');
					if(!$clinic_name_url ) $clinic_name_url = "all";
					$clinic_name_url = str_replace(" ","-",$clinic_name_url)."/";		


					$name_url = $data->first_name_en." ".$data->last_name_en;
					$name_url = str_replace(" ","-",$name_url);		

					$url = "/doctor/".$clinic_name_url.$name_url."?id=".$data->id;

				?>
				<div class="row">
					<div class="col-lg-12">
						<div class="agent agent-row agent-row-sidebar shadow-hover">
							<a href="<?php echo e($url); ?>" class="agent-img">
								<div class="img-fade"></div>
								<div class="button alt agent-tag">24 Properties</div>
								<img src="/front/images/1197x1350.png" alt="" />
							</a>
							<div class="agent-content">
								<div class="agent-details">
									<h4><a href="<?php echo e($url); ?>"><?php echo e($data->first_name_en); ?> <?php echo e($data->last_name_en); ?></a></h4>
									<p><i class="fa fa-tag icon"></i>Selling Agent</p>
									<p><i class="fa fa-envelope icon"></i>sparker@homely.com</p>
									<p><i class="fa fa-phone icon"></i>(123) 456-6789</p>
								</div>
								<div class="agent-text">
									Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et...
								</div>
			    				<div class="agent-footer center">
			    					<ul class="social-icons circle">
			    						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
			    						<li><a href="#"><i class="fa fa-instagram"></i></a></li>
			    						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
			    						<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
			    						<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
			    					</ul>
									<a href="<?php echo e($url); ?>" class="button button-icon right"><i class="fa fa-angle-right"></i>View Details</a>
			    				</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div><!-- end row -->
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		
			
				<div class="pagination">
					<div class="center">
						<?php echo $DoctorData->links('vendor.pagination.bootstrap-4'); ?>

					</div>
					<div class="clear"></div>
				</div>			
			</div><!-- end col -->
		
			<div class="col-lg-4 col-md-4 sidebar">
				<div class="widget widget-sidebar sidebar-properties advanced-search">
					<h4><span>Advanced Search</span> <img src="/front/images/divider-half-white.png" alt="" /></h4>
					<div class="widget-content box">
					<form>
						<div class="form-block border">
							<label for="property-location">Location</label>
							<select id="property-location" class="border">
								<option value="">Any</option>
								<option value="baltimore">Baltimore</option>
								<option value="ny">New York</option>
								<option value="nap">Annapolis</option>
							</select>
						</div>
						<div class="form-block border">
							<label for="property-status">Property Status</label>
							<select id="property-status" class="border">
								<option value="">Any</option>
								<option value="sale">For Sale</option>
								<option value="rent">For Rent</option>
							</select>
						</div>
						<div class="form-block border">
							<label for="property-type">Property Type</label>
							<select id="property-type" class="border">
								<option value="">Any</option>
								<option value="family">Family Home</option>
								<option value="apartment">Apartment</option>
								<option value="apartment">Condo</option>
							</select>
						</div>					  
						<div class="form-block">
							<label>Price</label>
							<div class="price-slider" id="price-slider"></div>
						</div>
						<div class="form-block border">
							<label>Beds</label>
							<select name="beds" id="property-beds" class="border">
								<option value="">Any</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>
						<div class="form-block border">
							<label>Baths</label>
							<select name="baths" id="property-baths" class="border">
								<option value="">Any</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select>
						</div>

						<div class="form-block">
							<label>Area</label>
							<input type="number" name="areaMin" class="area-filter border" placeholder="Min" />
							<input type="number" name="areaMax" class="area-filter border" placeholder="Max" />
							<div class="clear"></div>
						</div>

						<div class="form-block">
							<input type="submit" class="button" value="Find Properties" />
						</div>
					</form>
					</div><!-- end widget content -->
				</div><!-- end col -->		
			</div><!-- end row -->
		</div><!-- end container -->
	</div>
</section>


<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('layouts.js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>


</script>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>