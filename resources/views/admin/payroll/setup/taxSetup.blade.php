@extends('admin.master')
@section('content')
@section('title')
@lang('payroll_setup.tax_rule_setup')
@endsection
<style>

	.select2{ width: 100% !important;}

</style>
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>

		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @lang('payroll_setup.rate_of_income_tax')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							@if(session()->has('success'))
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;<strong>{{ session()->get('success') }}</strong>
								</div>
							@endif
							@if(session()->has('error'))
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<i class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
								</div>
							@endif
							<div class="table-responsive">
								<table  class="table table-bordered">
									<thead>
										 <tr class="tr_header">
											<th>@lang('common.serial')</th>
											<th>@lang('payroll_setup.total_income')</th>
											<th>@lang('payroll_setup.tax_rate') %</th>
											<th>@lang('payroll_setup.taxable_amount')</th>
											<th>@lang('common.update')</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="5"><b>@lang('payroll_setup.tax_rules') (@lang('payroll_setup.male'))</b></td>
										</tr>
										@php
											$countTax = count($maleTax);
										@endphp
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										@foreach($maleTax as $key=>$value)
											<tr>
												<td>
                                                    @php
                                                    if($key == 0){
                                                        echo __('payroll_setup.first');
                                                    }
                                                    else{
                                                        echo  __('payroll_setup.next');
                                                    }
                                                    @endphp
												</td>
												<td>
                                                    @php
                                                    echo '<input type="hidden" class="form-control taxHiddenValue" name="tax_rule_id" value="'.$value->tax_rule_id.'">';
                                                    echo '<input type="hidden" class="form-control gender" name="gender" value="'.$value->gender.'">';
                                                    if($key +1 == $countTax){
                                                        echo __('payroll_setup.remaining_total_income')." ---";
                                                        echo '<input type="hidden" class="form-control amount" name="amount" value="0">';
                                                    }else{
                                                    @endphp
													<input type="number" class="form-control amount" name="amount" value="{{$value->amount}}">
                                                    @php } @endphp
												</td>
												<td>
													<!-- <select class="form-control percentage_of_tax select2 required" name="percentage_of_tax">
                                                        @php
                                                        for($i=0;$i<=50;$i+=5){
                                                            $selected = '';
                                                            if($value->percentage_of_tax == $i){
                                                                $selected = 'selected';
                                                            }
                                                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'%</option>';
                                                        }
                                                        @endphp
													</select> -->
                                                    <input type="number" step="0.03" value="{{ $value->percentage_of_tax }}" class="form-control percentage_of_tax" name="percentage_of_tax">
												</td>
												<td>
                                                    @php
                                                    if($key +1 == $countTax){
                                                        echo __('payroll_setup.remaining_taxable_amount')."---";
                                                        echo '<input type="hidden" class="form-control amount_of_tax" name="amount_of_tax" value="0">';
                                                    }else{
                                                    @endphp
													<input type="text" readonly class="form-control amount_of_tax" name="amount_of_tax" value="{{$value->amount_of_tax}}">
                                                    @php } @endphp
												</td>
												<td style="width:100px;">
													<button type="button" class="btn btn-sm btn-success saveTaxRow">
														@lang('common.update')
													</button>
												</td>
											</tr>
										@endforeach

										<tr>
											<td colspan="5"><b>@lang('payroll_setup.tax_rules') (@lang('payroll_setup.female'))</b></td>
										</tr>
										@foreach($femaleTax as $key=>$value)
											<tr>
												<td>
                                                    @php
                                                    if($key == 0){
                                                        echo __('payroll_setup.first');
                                                    }
                                                    else{
                                                        echo  __('payroll_setup.next');
                                                    }
                                                    @endphp
												</td>
												<td>
                                                    @php
                                                    echo '<input type="hidden" class="form-control taxHiddenValue" name="tax_rule_id" value="'.$value->tax_rule_id.'">';
                                                    echo '<input type="hidden" class="form-control gender" name="gender" value="'.$value->gender.'">';
                                                    if($key +1 == $countTax){
                                                        echo __('payroll_setup.remaining_total_income')." ---";
                                                        echo '<input type="hidden" class="form-control amount" name="amount" value="0">';
                                                    }else{
                                                    @endphp
													<input type="number" class="form-control amount" name="amount" value="{{$value->amount}}">
                                                    @php } @endphp
												</td>
												<td>
													<!-- <select class="form-control percentage_of_tax select2 required" name="percentage_of_tax">
                                                        @php
                                                        for($i=0;$i<=50;$i+=5){
                                                            $selected = '';
                                                            if($value->percentage_of_tax == $i){
                                                                $selected = 'selected';
                                                            }
                                                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'%</option>';
                                                        }
                                                        @endphp
													</select> -->
                                                    <input type="number" step="0.03" value="{{ $value->percentage_of_tax }}" class="form-control percentage_of_tax" name="percentage_of_tax">
												</td>
												<td>
                                                    @php
                                                    if($key +1 == $countTax){
                                                        echo __('payroll_setup.remaining_taxable_amount')."---";
                                                        echo '<input type="hidden" class="form-control amount_of_tax" name="amount_of_tax" value="0">';
                                                    }else{
                                                    @endphp
													<input type="number" readonly class="form-control amount_of_tax" name="amount_of_tax" value="{{$value->amount_of_tax}}">
                                                    @php } @endphp
												</td>
												<td style="width:100px;">
													<button type="button" class="btn btn-sm btn-success saveTaxRow">
														@lang('common.update')
													</button>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('page_scripts')
	<script type="text/javascript">
		jQuery(function(){

            $(document).on("keyup",".amount,.percentage_of_tax  ",function(){
                var amount 				= $(this).parents('tr').find('.amount').val();
                var percentage_of_tax   = $(this).parents('tr').find('.percentage_of_tax').val();
                var taxableAmount = 0;
                taxableAmount = (amount * percentage_of_tax) /100;
                $(this).parents('tr').find('.amount_of_tax').val(taxableAmount);
            });


            $("body").on("click",".saveTaxRow  ",function(){
                var taxHiddenValue      = $(this).parents('tr').find('.taxHiddenValue').val();
                var amount 				= $(this).parents('tr').find('.amount').val();
                var percentage_of_tax   = $(this).parents('tr').find('.percentage_of_tax').val();
                var amount_of_tax   	= $(this).parents('tr').find('.amount_of_tax').val();
                var gender   	        = $(this).parents('tr').find('.gender').val();
                var action = "{{ URL::to('taxSetup/updateTaxRule') }}";
                $.ajax({
                    type: "post",
                    url: action,
                    data: {'tax_rule_id': taxHiddenValue, 'amount': amount,'percentage_of_tax':percentage_of_tax,'amount_of_tax':amount_of_tax,'gender':gender,'_token': $('input[name=_token]').val()},
                    success: function (data) {
                        if(data == 'success'){
                            $.toast({
                                heading: 'success',
                                text: 'Income tax rule update successfully !',
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 6
                            });
                        }else{
                            $.toast({
                                heading: 'Problem',
                                text: 'Something error found !',
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'error',
                                hideAfter: 3000,
                                stack: 6
                            });
                        }

                    }
                });
			})
		});
	</script>
@endsection
