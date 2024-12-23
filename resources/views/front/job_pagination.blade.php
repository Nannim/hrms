@php
$front_setting = getFrontData();
@endphp

<div class="row">
                <div class="col-12">
                    <div class="tab-content mt-2" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="recent-job" role="tabpanel" aria-labelledby="recent-job-tab">
                            <div class="row">
                                
                                <div class="col-lg-12">
                                    @foreach($jobs as $job)
                                    <div class="job-box bg-white overflow-hidden border rounded mt-4 position-relative overflow-hidden">
                                        <div class="lable text-center pt-2 pb-2">
                                            <ul class="list-unstyled best text-white mb-0 text-uppercase">
                                                <li class="list-inline-item"><i class="mdi mdi-star"></i></li>
                                            </ul>
                                        </div>
                                        <div class="p-4">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <div class="mo-mb-2">
                                                        <img src="{{ url('uploads/front/'.$front_setting->logo) }}" alt="" class="img-fluid mx-auto d-block">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div>
                                                        <h5 class="f-18"><a href="#" class="text-dark">{{ $job->job_title }}</a></h5>
                                                        <p class="text-muted mb-0">{{ $job->post }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div>
                                                        <p class="text-muted mb-0">Published at : {{date("d M Y", strtotime($job->created_at))}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div>
                                                        <p class="text-muted mb-0 mo-mb-2">Deadline : {{date("d M Y", strtotime($job->application_end_date))}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-3 bg-light">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="text-left">
                                                        <a href="{{ route('job.details',['id' => $job->job_id,'slug' => str_replace(' ','-',strtolower($job->job_title))]) }}" 
                                                        class="text-primary">View Details<i class="mdi mdi-chevron-double-right"></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="text-right">
                                                        <a href="{{ route('job.details',['id' => $job->job_id,'slug' => str_replace(' ','-',strtolower($job->job_title))]) }}" class="text-primary">Apply Now <i class="mdi mdi-chevron-double-right"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <!-- end row -->
            <div class="row">
                <div class="col-lg-12 mt-4 pt-2 text-center">
                 {{$jobs->links('vendor.pagination.bootstrap-4')}}
                </div>
            </div>