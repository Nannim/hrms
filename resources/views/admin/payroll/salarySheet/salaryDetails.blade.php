@extends('admin.master')
@section('content')
@section('title')
@lang('salary_sheet.payment_info')
@endsection

	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<a href="{{ route('generateSalarySheet.create') }}"
				class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">
				<i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('salary_sheet.generate_salary_sheet')</a>

				<a href="{{route('generateSalarySheet.bulk')}}"
			class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">
			<i class="fa fa-list-ul" aria-hidden="true"></i>  @lang('salary_sheet.Generate Bulk Salary Sheet')</a>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @yield('title')</div>
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
									<strong>{{ session()->get('error') }}</strong>
								</div>
							@endif
							<div class="row">
								<div class="col-md-2"></div>

								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('common.month')</label>
										{!! Form::text('month','', $attributes = array('class'=>'form-control monthField','id'=>'month','placeholder'=>__('common.month'),'readonly'=>'readonly')) !!}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="exampleInput">@lang('common.status')</label>
										{{ Form::select('status', array(''=>'---- '. __('common.please_select') .' ----','0' => __('salary_sheet.unpaid'), '1' => __('salary_sheet.paid')), '', array('class' => 'form-control status select2 required')) }}
									</div>
								</div>

							</div>
							<br>
							<div class="data">
								@include('admin.payroll.salarySheet.pagination')
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title"><b>@lang('salary_sheet.payment_for')<span class="monthAndYearName"></span></b></h4> </div>
			<div class="modal-body">
				<form>
					{{ csrf_field() }}
					<input type="hidden" class="salary_details_id">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label">@lang('common.employee_name')</label>
								<input type="text" class="form-control employee_name" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label">@lang('paygrade.basic_salary')</label>
								<input type="text" class="form-control basic_salary" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label">@lang('salary_sheet.total_allowance')</label>
								<input type="text" class="form-control total_allowance" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label">@lang('salary_sheet.total_deduction')</label>
								<input type="text" class="form-control total_deduction" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label">@lang('paygrade.gross_salary')</label>
								<input type="text" class="form-control gross_salary" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="recipient-name" class="control-label">@lang('salary_sheet.payment_method')</label>
								<select class="form-control payment_method">
									<option value="Cash">@lang('salary_sheet.cash')</option>
									<option value="Cheque">@lang('salary_sheet.cheque')</option>
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="message-text" class="control-label">@lang('salary_sheet.comments')</label>
								<textarea class="form-control comment"></textarea>
							</div>
						</div>
					</div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><b>@lang('common.close')</b></button>
				<button type="button" class="btn btn-info btn_style waves-effect waves-light makePayment" data-dismiss="modal"	> <b>@lang('salary_sheet.pay')</b></button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('page_scripts')
	<script>
        $(function() {
			$(document).on('click','[data-salary_details_id]',function(event){
				var salary_details_id 	= $(this).attr('data-salary_details_id');
				var monthAndYearName 	= $(this).attr('data-monthAndYearName');
				var employee_name 		= $(this).attr('data-employee_name');
				var basic_salary 		= $(this).attr('data-basic_salary');
				var total_allowance 	= $(this).attr('data-total_allowance');
				var total_deduction 	= $(this).attr('data-total_deduction');
				var gross_salary 		= $(this).attr('data-gross_salary');

				if(total_allowance==0 && basic_salary==0 && total_deduction==0){
                    $('.basic_salary').parent().css({"display": "none"});
                    $('.total_allowance').parent().css({"display": "none"});
                    $('.total_deduction').parent().css({"display": "none"});
					$('.comment').parent().parent().addClass('col-md-6');
					$('.comment').parent().parent().removeClass('col-md-12');
				}else{
                    $('.basic_salary').parent().css({"display": "block"});
                    $('.total_allowance').parent().css({"display": "block"});
                    $('.total_deduction').parent().css({"display": "block"});
                    $('.comment').parent().parent().addClass('col-md-12');
                    $('.comment').parent().parent().removeClass('col-md-6');
				}

				$('.employee_name').val(employee_name);
				$('.basic_salary').val(basic_salary);
				$('.total_allowance').val(total_allowance);
				$('.total_deduction').val(total_deduction);
				$('.gross_salary').val(gross_salary);
				$('.monthAndYearName').html(monthAndYearName);
				$('.salary_details_id').val(salary_details_id);

			});

			$(document).on('click','.makePayment',function(event){

				var payment_method 		 = $('.payment_method').val();
				var comment 	  		 = $('.comment').val();
				var salary_details_id 	 = $('.salary_details_id').val();
				var action 				 = "{{ URL::to('generateSalarySheet/makePayment') }}";
				$.ajax({
					type: 'POST',
					url: action,
					data: {'payment_method': payment_method,'comment': comment,'salary_details_id':salary_details_id,'_token': $('input[name=_token]').val()},
					success: function (data) {
						if (data != 'success') {
                            $.toast({
                                heading: 'Warning',
                                text: 'Something Error Found !, Please try again. !',
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 6
                            });
                            window.setTimeout(function () {
                                location.reload()
                            }, 3000)

                        } else {
                            $.toast({
                                heading: 'success',
                                text: 'Payment Paid !',
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'success',
                                hideAfter: 3000,
                                stack: 6
                            });
                            window.setTimeout(function () {
                                location.reload()
                            }, 3000);
                        }
					}
				});
			});

			$('.data').on('click', '.pagination a', function (e) {
				getData($(this).attr('href').split('page=')[1]);
				e.preventDefault();
			});


            $(".status,.monthField").change(function(){
                getData(1);
            });


        });

        function getData(page) {
            var status 	        = $('.status').val();
            var monthField 		= $('.monthField').val();
            $.ajax({
                 url : '?page=' + page+"&status="+status+"&monthField="+monthField,
                datatype: "html",
            }).done(function (data) {
                $('.data').html(data);
                $("html, body").animate({ scrollTop: 0 }, 800);
            }).fail(function () {
                $.toast({
                    heading: 'Warning',
                    text: 'Something Error Found !, data could not be loaded. !',
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
            });
        }

	</script>
@endsection
