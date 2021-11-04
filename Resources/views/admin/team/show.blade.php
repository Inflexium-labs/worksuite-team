@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bower_components/multiselect/css/multi-select.css') }}">
@endpush

@section('content')
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <a href="{{ route('admin.team.index') }}" class="btn btn-outline btn-inverse btn-sm pull-left m-r-15">
                <i class="fa fa-arrow-left"></i> @lang('app.back')
            </a>

            <h4 class="page-title "><i class="fa fa-users"></i> {{ $pageTitle ?? __('team::app.teamView') }}</h4>
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
                            <div class="panel-heading">@lang('team::app.teamInformation')</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <ul class="basic-list">
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    @lang('team::app.teamName'):
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    {{ $team->name }}
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    @lang('app.description'):
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    {{ $team->description }}
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    @lang('app.status'):
                                                </div>
                                                <div class="col-sm-7 text-right" id="status">
                                                    <span
                                                        class="badge badge-{{ $team->status ? 'success' : 'danger' }}">{{ $team->status ? 'Active' : 'Inactive' }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    @lang('team::app.since'):
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    {{ $team->created_at->format('d F, Y') }}
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    @lang('team::app.members'):
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    <span class="badge badge-success">{{ $team->members->count() }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row" id="previewLeader">
                                                <div class="col-sm-5">
                                                    @lang('team::app.teamLeader'):
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    <a href="javascript:;" style="color: #03a9f3;">{{ $team->leader->name ?? 'Add' }}</a>
                                                    {{-- <a class="label label-info"><i class="fa fa-pencil"></i></a> --}}
                                                </div>
                                            </div>
                                            <div class="row" id="editLeader" style="display: none;">
                                                <select class="form-control select2 m-b-10" data-placeholder="@lang('modules.messages.chooseMember')" name="team_leader">
                                                    @foreach ($employees as $emp)
                                                        <option value="{{ $emp->id }}" {{ $emp->id == $team->team_leader ? 'selected' : '' }}>{{ ucwords($emp->name) }}
                                                            @if ($emp->id == $user->id)
                                                                (@lang('team::app.you')) @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-sm btn-success" id="update">@lang('app.update')</button>
                                                <button class="btn btn-sm btn-inverse" id="cancel">@lang('app.cancel')</button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    @lang('team::app.updateStatus')
                                                </div>
                                                <div class="col-sm-7 text-right">
                                                    <div class="switchery-demo">
                                                        <input id="statusBtn" type="checkbox" name="status" value="1"
                                                            class="js-switch" data-color="#00c292"
                                                            data-secondary-color="#f96262"
                                                            {{ $team->status ? 'checked' : '' }} />
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <button class="btn btn-sm btn-info" id="editTeam">@lang('app.edit')</button>
                                                </div>
                                                <div class="col-sm-7 text-right" id="deleteTeam">
                                                    <button class="btn btn-sm btn-danger">@lang('app.delete')</button>
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
                            <div class="panel-heading">@lang('team::app.teamMembers')</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">

                                    {!! Form::open(['id' => 'addMembersForm', 'class' => 'ajax-form', 'method' => 'POST']) !!}
                                    <div class="form-body">
                                        <div class="form-group" id="user_id">
                                            <select class="select2 m-b-10 select2-multiple " multiple="multiple"
                                                data-placeholder="@lang('modules.messages.chooseMember')" name="members[]">
                                                @foreach ($employees as $emp)
                                                    <option value="{{ $emp->id }}">{{ ucwords($emp->name) }} {{ isset($emp->employeeDetail->department->team_name) ? ' - ('.$emp->employeeDetail->department->team_name.')' : '' }}
                                                        @if ($emp->id == $user->id)
                                                            (@lang('team::app.you')) @endif
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button type="submit" id="save-members" class="btn btn-success"><i
                                                    class="fa fa-check"></i> @lang('app.save')
                                            </button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}


                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th width="50%">@lang('app.name')</th>
                                                    <th>@lang('app.department')</th>
                                                    <th>@lang('app.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody id="employeeDocsList">
                                                @foreach ($team->members as $member)
                                                    <tr>
                                                        <td>{{ $member->employeeDetail->employee_id ?? 'none' }}</td>
                                                        <td>{{ $member->name }}</td>
                                                        <td>{{ $member->employeeDetail->department->team_name ?? '--' }}
                                                        </td>
                                                        <td><a class="btn btn-danger btn-xs unlinkMember"
                                                                data-id="{{ $member->id }}"
                                                                href="{{ route('admin.team.remove-member', $team->id) }}"><i
                                                                    class="fa fa-unlink"></i></a></td>
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
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/multiselect/js/jquery.multi-select.js') }}"></script>
    <script>
        $(".select2").select2({
            formatNoMatches: function() {
                return "{{ __('messages.noRecordFound') }}";
            }
        });

        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });

        $('#editTeam').click(function(e) {
            e.preventDefault();
            $.ajaxModal('#teamModal', '{{ route('admin.team.edit', $team) }}');
        });

        $('#addMembersForm').submit(function(e) {
            e.preventDefault();
            $.easyAjax({
                url: "{{ route('admin.team.add-members', $team) }}",
                container: '#addMembersForm',
                type: "POST",
                data: $(this).serialize(),
                success: function(res) {
                    if (res.status == 'success') {
                        $('#teamModal').modal('hide');
                        location.reload(true);
                    }
                }
            })
        });

        $('#statusBtn').change(function() {
            let status = $('#statusBtn').prop("checked");

            $.easyAjax({
                url: "{{ route('admin.team.status-update', $team) }}",
                type: "POST",
                data: {
                    'status': status,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status == 'success') {
                        let style = status ? 'success' : 'danger';
                        let text = status ? 'Active' : 'Inactive';
                        let badge = '<span class="badge badge-' + style + '">' + text + '</span>';
                        $('#status').html(badge);
                    }
                }
            })
        })

        $('body .unlinkMember').click(function(e) {
            e.preventDefault();
            property = $(this).parent().parent();
            $.easyAjax({
                url: $(this).attr('href'),
                type: "DELETE",
                data: {
                    'member': $(this).data('id'),
                    '_token': '{{ csrf_token() }}'
                },
                success: function(res) {
                    property.remove();
                }
            })
        });

        $('#deleteTeam').click(function() {
            swal({
                title: "Delete Team",
                text: "Are you sure want to delete?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm) {
                console.log(isConfirm);
                if (isConfirm) {
                    $.easyAjax({
                        type: 'DELETE',
                        url: '{{ route('admin.team.destroy', $team) }}',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                $.unblockUI();
                            }
                        }
                    });
                }
            });
        });

        $('#previewLeader a').click(function(){
            toggleLeaderTab()
        })

        $('#editLeader #cancel').click(function(){
            toggleLeaderTab()
        })

        function toggleLeaderTab() {
            let preview = $('#previewLeader');
            let edit = $('#editLeader');
            
            preview.toggle('show');
            edit.toggle('show');
        }

        $('#editLeader #update').click(function(){
            $.easyAjax({
                url: "{{ route('admin.team.update-leader', $team) }}",
                type: "POST",
                data: { 'leader': $(this).prev().val(), '_token': '{{ csrf_token() }}' },
                success: function(res) {
                    if (res.status == 'success') {
                        location.reload(true);
                    }
                }
            })
        })

    </script>
@endpush
