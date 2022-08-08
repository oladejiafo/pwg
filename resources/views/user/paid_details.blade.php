
		<!-- Theme style  -->
		<link rel="stylesheet" href="{{asset('user/extra/css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{asset('user/extra/css/styled.css')}}">
	{{-- <div class="col-md-12">
		<div class="about-desc animate-box">

			<div class="fancy-collapse-panel">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
									aria-expanded="true" aria-controls="collapseOne"> &nbsp; @foreach($prod as $pp) {{$pp->product_name}} @endforeach PACKAGE
								</a>
							</h4>
						</div><hr style="height:2px;border:none;color:#333;background-color:#333;" >
						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
							aria-labelledby="headingOne">
							<div class="panel-body">
                              @foreach($pays as $pay) 
                                <div class="row">
									<div class="col-md-3">
										<p>
                                         {{$pay->payment}}
                                        </p>
									</div>
									<div class="col-md-3">
										<p>
                                        @foreach($paid as $pd) 
                                           
                                           {{ $pd->payment_status }}
                                           
                                         @endforeach
                                        </p>
									</div>
                                    <div class="col-md-6" align="right">
                                        <p>
                                        @foreach($paid as $pd) 
                                           
                                           @if( $pd->product_payment_id == $pay->id)
                                           <a class="btn btn-secondary" href="#">Get Reciept</a>
                                           @else
                                           <a class="btn btn-secondary" href="{{ url('product', $pay->id) }}">Pay Now</a>
                                           @endif
                                           
                                         @endforeach
                                        </p>
                                    </div>
								</div><hr>
                              @endforeach
							</div>
						</div>
					</div>
					<!-- <div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
									aria-expanded="false" aria-controls="collapseTwo">What We Do?
								</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
							aria-labelledby="headingTwo">
							<div class="panel-body">
								<p>We are a customer focused enterprise, providing effective process, best practices to
									align with your goals and expectations on the following line of services:</p>
								<ul>
									<li>IT Staffing Services</li>
									<li>IT Trainings</li>
									<li>IT Testing Center</li>
									<li>Application/Product Development</li>
									<li>Data Analytics</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion"
									href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Benefits
									We Offer?
								</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel"
							aria-labelledby="headingThree">
							<div class="panel-body">
								<ul>
									<li>Detol Technology offers a flexible benefits package, where you can choose the
										health and wellness benefits that suits your needs.</li>
									<li>Medical/Prescription Health Insurance –Enables you to choose a medical plan
										that’s best for you or your family through our service provider United Health
										Care Group. (www.uhc.com)</li>
									<li>Dental –Offers an open choice plan with in and out-of-network coverage.</li>
									<li>Medical/Prescription Health Insurance –Enables you to choose a medical plan
										that’s best for you or your family through our service provider United Health
										Care Group. (www.uhc.com)</li>
									<li>Vision –Gives you the ability to choose from an extensive nationwide network of
										doctors (www.vsp.com)</li>
								</ul>

							</div>

						</div> -->
					</div>
				</div>
			</div>
		</div> --}}


		<div class="gototop js-top">
			<a href="#" class="js-gotop"><i class="icon-arrow-up2"></i></a>
		</div>

		<!-- jQuery -->
		<script src="{{asset('user/extra/js/jquery.min.js')}}"></script>
		<!-- Bootstrap -->
		<script src="{{asset('user/extra/js/bootstrap.min.js')}}"></script>

		</body>

</html>
