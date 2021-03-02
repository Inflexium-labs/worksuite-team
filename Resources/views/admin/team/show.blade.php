@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/switchery/dist/switchery.min.css') }}">
@endpush

@section('content')
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('admin.team.index') }}" class="btn btn-outline btn-inverse btn-sm pull-left m-r-15">
                <i class="fa fa-arrow-left"></i> Back
            </a>

            <h4 class="page-title "><i class="fa fa-users"></i> {{ $pageTitle ?? 'Team' }}</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

        </div>
    </div>

    <div class="white-box">
        <div class="col-md-12">
            <div class="row dashboard-stats front-dashboard">

                <div class="row">
                    <div class="col-md-4">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">Team Information</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <ul class="basic-list">
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    Team Name:
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    {{ $team->name }}
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    Description:
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    {{ $team->description }}
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    Status:
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    <span
                                                        class="badge badge-{{ $team->status ? 'success' : 'danger' }}">{{ $team->status ? 'Active' : 'Inactive' }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    Since:
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    {{ $team->created_at->format('d F, Y') }}
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    Members:
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    <span class="label label-success">{{ $team->members->count() }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    Update Status
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    <div class="switchery-demo">
                                                        <input id="statusBtn" type="checkbox" name="status" value="1" class="js-switch"
                                                            data-color="#00c292" data-secondary-color="#f96262" />
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">Team Members</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <ul class="list-task list-group" data-role="tasklist">
                                        <li class="list-group-item" data-role="task">
                                            <strong>Title</strong> <span class="pull-right"><strong>Follow Up
                                                    Date</strong></span>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="text-center">
                                                <div class="empty-space" style="height: 200px;">
                                                    <div class="empty-space-inner">
                                                        <div class="icon" style="font-size:20px"><i
                                                                class="fa fa-user-plus"></i>
                                                        </div>
                                                        <div class="title m-b-15">No pending follow-up. </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- Ajax Modal --}}
    <div class="modal fade bs-modal-md in" id="teamModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" id="modal-data-application">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
                </div>
                <div class="modal-body">
                    @lang('incident::app.loading')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn blue">Save changes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->.
    </div>
    {{-- Ajax Modal Ends --}}
@endsection

@push('footer-script')
    <script src="{{ asset('plugins/bower_components/switchery/dist/switchery.min.js') }}"></script>
    <script>
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });

        $('#statusBtn').change(function(){
            alert('tes');
        })
    </script>
@endpush
