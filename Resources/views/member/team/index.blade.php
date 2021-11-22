@extends('layouts.member-app')

@section('content')
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title "><i class="fa fa-users"></i> {{ $pageTitle ?? __('team::app.team') }}</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <a href="{{ route('member.team.create') }}" class="btn btn-outline btn-success btn-sm pull-right"
                id="createTeam">
                @lang('team::app.createTeam')
                <i class="fa fa-plus" aria-hidden="true"></i>
            </a>
        </div>
    </div>

    <div class="white-box">
        <div class="col-md-12">
            <div class="row dashboard-stats front-dashboard">

                @foreach ($teams as $team)
                <div class="col-md-4 col-sm-6">
                    <a href="{{ route('member.team.show', $team) }}">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div>
                                        <span class="{{ $team->status ? 'bg-success-gradient' : 'bg-danger-gradient'}}" title="{{ $team->status ? 'Active' : 'Inactive'}}"></span>
                                    </div>
                                </div>
                                <div class="col-xs-5 m-t-10">
                                    {{ $team->name }}
                                </div>
                                <div class="col-xs-4 text-right">
                                    <span class="widget-title"> @lang('team::app.members')</span><br>
                                    <span class="counter">{{ $team->members->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    {{--Ajax Modal--}}
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
                    <button type="button" class="btn default" data-dismiss="modal">@lang('app.close')</button>
                    <button type="button" class="btn blue">@lang('app.save')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->.
    </div>
    {{--Ajax Modal Ends--}}
@endsection

@push('footer-script')
    <script>
        $('#createTeam').click(function(e) {
            e.preventDefault();
            $.ajaxModal('#teamModal', $(this).attr('href'));
        });
    </script>
@endpush
