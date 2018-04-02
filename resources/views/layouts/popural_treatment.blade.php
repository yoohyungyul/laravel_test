<?php
$TreatmentsBannerData = DB::table('kmh_banner')
	->join('kmh_procedure_info', 'kmh_procedure_info.id', '=', 'kmh_banner.b_id')	
	->select('b_id','b_img','name_en','parent_id')
	->where('area','2')->where('gubun','1')->orderBy('b_ord','asc')->take(7)->get();
?>

<div class="widget widget-sidebar recent-properties">
	<h4><span>Popural Treatment</span> <img src="/front/images/divider-half.png" alt="" /></h4>
	<div class="widget-content box">
		<ul class="bullet-list">
			@foreach($TreatmentsBannerData as $data)
			<li><a href="/find-my-clinic?body_part_id={{$data->parent_id}}&procedure_info_id={{$data->b_id}}">{{$data->name_en}}</a></li>
			@endforeach
		</ul>
	</div><!-- end widget content -->
</div><!-- end widget -->