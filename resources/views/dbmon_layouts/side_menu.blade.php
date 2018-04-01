<div class="site-menubar">
	<div class="site-menubar-body">
		<div>
			<div>
				<ul class="site-menu" data-plugin="menu">
					<li class="site-menu-category">General</li>
					<li class="site-menu-item has-sub">
						<a href="/dbmon">
							<i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
							<span class="site-menu-title">Dashboard</span>
							<!-- <div class="site-menu-badge">
							  <span class="badge badge-pill badge-success">3</span>
							</div> -->
						</a>
             
					</li>
					<li class="site-menu-item has-sub @if(strpos($_SERVER['REQUEST_URI'],'dbmon/clinic') == '1')  active open @endif ">
						<a href="javascript:void(0)">
							<i class="site-menu-icon wb-layout" aria-hidden="true"></i>
							<span class="site-menu-title">병원관리</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item  @if(strpos($_SERVER['REQUEST_URI'],'dbmon/clinic/list') == '1')  active  @endif  ">
								<a class="animsition-link" href="/dbmon/clinic/list">
									<span class="site-menu-title">병원리스트</span>
								</a>
							</li>
							<li class="site-menu-item  @if(strpos($_SERVER['REQUEST_URI'],'dbmon/clinic/adminApp') == '1')  active  @endif  ">
								<a class="animsition-link" href="/dbmon/clinic/adminApp">
									<span class="site-menu-title">관리자 신청 리스트</span>
								</a>
							</li>
							<li class="site-menu-item  @if(strpos($_SERVER['REQUEST_URI'],'dbmon/clinic/regApp') == '1')  active  @endif  ">
								<a class="animsition-link" href="/dbmon/clinic/regApp">
									<span class="site-menu-title">병원 등록 리스트</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="site-menu-item has-sub @if(strpos($_SERVER['REQUEST_URI'],'dbmon/doctor') == '1')  active open @endif">
						<a href="javascript:void(0)">
							<i class="site-menu-icon wb-layout" aria-hidden="true"></i>
							<span class="site-menu-title">의사관리</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/doctor') == '1')  active  @endif">
								<a class="animsition-link" href="/dbmon/doctor">
									<span class="site-menu-title">의사리스트</span>
								</a>
							</li>
						</ul>
					</li>

					<li class="site-menu-item has-sub @if(strpos($_SERVER['REQUEST_URI'],'dbmon/inquiry') == '1')  active open @endif">
						<a href="javascript:void(0)">
							<i class="site-menu-icon wb-layout" aria-hidden="true"></i>
							<span class="site-menu-title">문의관리</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/inquiry/clinic') == '1')  active  @endif">
								<a class="animsition-link" href="/dbmon/inquiry/clinic">
									<span class="site-menu-title">병원문의 리스트</span>
								</a>
							</li>
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/inquiry/site') == '1')  active  @endif">
								<a class="animsition-link" href="/dbmon/inquiry/site">
									<span class="site-menu-title">사이트문의 리스트</span>
								</a>
							</li>
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/inquiry/newsletter') == '1')  active  @endif">
								<a class="animsition-link" href="/dbmon/inquiry/newsletter">
									<span class="site-menu-title">Newsletter 리스트</span>
								</a>
							</li>
						</ul>
					</li>

					<li class="site-menu-item has-sub @if(strpos($_SERVER['REQUEST_URI'],'dbmon/procedureInfo') == '1')  active open @endif">
						<a href="javascript:void(0)">
							<i class="site-menu-icon wb-layout" aria-hidden="true"></i>
							<span class="site-menu-title">시술관리</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/procedureInfo') == '1')  active  @endif">
								<a class="animsition-link" href="/dbmon/procedureInfo">
									<span class="site-menu-title">시술부위 및 시술명 리스트</span>
								</a>
							</li>
						</ul>
					</li>

					<li class="site-menu-item has-sub @if(strpos($_SERVER['REQUEST_URI'],'dbmon/gov-data') == '1')  active open @endif">
						<a href="javascript:void(0)">
							<i class="site-menu-icon wb-layout" aria-hidden="true"></i>
							<span class="site-menu-title">데이타관리</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/gov-data/medic-instt') == '1')  active  @endif ">
								<a class="animsition-link" href="/dbmon/gov-data/medic-instt">
									<span class="site-menu-title">심평원 - 병원정보서비스</span>
								</a>
							</li>
							<!-- <li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/gov-data/non-payment') == '1')  active  @endif ">
								<a class="animsition-link" href="/dbmon/gov-data/non-payment">
									<span class="site-menu-title">심평원 - 비급여진료비정보서비스</span>
								</a>
							</li> -->
							<!-- <li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/gov-data/parmacy') == '1')  active  @endif ">
								<a class="animsition-link" href="/dbmon/gov-data/parmacy">
									<span class="site-menu-title">심평원 - 약국정보서비스</span>
								</a>
							</li> -->
							<!-- <li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/gov-data/mdlrt-action') == '1')  active  @endif ">
								<a class="animsition-link" href="/dbmon/gov-data/mdlrt-action">
									<span class="site-menu-title">심평원 - 진료행위정보서비스</span>
								</a>
							</li> -->
							<!-- <li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/gov-data/spcl-mdlrt-hosp') == '1')  active  @endif ">
								<a class="animsition-link" href="/dbmon/gov-data/spcl-mdlrt-hosp">
									<span class="site-menu-title">심평원 - 특수진료병원정보서비스</span>
								</a>
							</li> -->
							<!-- <li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/gov-data/diss') == '1')  active  @endif">
								<a class="animsition-link" href="/dbmon/gov-data/diss">
									<span class="site-menu-title">심평원 - 질병정보서비스</span>
								</a>
							</li>
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/gov-data/address') == '1')  active  @endif ">
								<a class="animsition-link" href="/dbmon/gov-data/address">
									<span class="site-menu-title">심평원 - 우편번호서비스</span>
								</a>
							</li>
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/gov-data/address/en') == '1')  active  @endif ">
								<a class="animsition-link" href="/dbmon/gov-data/address/en">
									<span class="site-menu-title">심평원 - 영문 우편번호서비스</span>
								</a>
							</li> -->
						</ul>
					</li>  

					<li class="site-menu-item has-sub @if(strpos($_SERVER['REQUEST_URI'],'dbmon/blog') == '1')  active open @endif">
						<a href="javascript:void(0)">
							<i class="site-menu-icon wb-layout" aria-hidden="true"></i>
							<span class="site-menu-title">블로그관리</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/blog') == '1')  active  @endif">
								<a class="animsition-link" href="/dbmon/blog">
									<span class="site-menu-title">블로그 리스트</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="site-menu-item has-sub @if(strpos($_SERVER['REQUEST_URI'],'dbmon/user') == '1')  active open @endif">
						<a href="javascript:void(0)">
							<i class="site-menu-icon wb-layout" aria-hidden="true"></i>
							<span class="site-menu-title">회원관리</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/user') == '1')  active  @endif">
								<a class="animsition-link" href="/dbmon/user">
									<span class="site-menu-title">회원리스트</span>
								</a>
							</li>
						</ul>
					</li>


					<li class="site-menu-item has-sub @if(strpos($_SERVER['REQUEST_URI'],'dbmon/site') == '1')  active open @endif">
						<a href="javascript:void(0)">

							<i class="site-menu-icon wb-layout" aria-hidden="true"></i>
							<span class="site-menu-title">사이트관리</span>
							<span class="site-menu-arrow"></span>
						</a>
						<ul class="site-menu-sub">
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/site/banner') == '1')  active  @endif"">
								<a class="animsition-link" href="/dbmon/site/banner">
									<span class="site-menu-title">배너관리</span>
								</a>
							</li>
							<li class="site-menu-item @if(strpos($_SERVER['REQUEST_URI'],'dbmon/site/setting') == '1')  active  @endif"">
								<a class="animsition-link" href="/dbmon/site/setting">
									<span class="site-menu-title">설정</span>
								</a>
							</li>
						</ul>
					</li>


				</ul>          
			</div>
		</div>
	</div>
    <div class="site-menubar-footer">
		<a href="/dbmon/site/setting" class="fold-show" data-placement="top" data-toggle="tooltip" data-original-title="Settings">
			<span class="icon wb-settings" aria-hidden="true"></span>
		</a>
		<a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">

		</a>
		<a href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();" data-toggle="tooltip" data-original-title="로그 아웃">
			<span class="icon wb-power" aria-hidden="true"></span>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>
		</a>
	</div>
</div>