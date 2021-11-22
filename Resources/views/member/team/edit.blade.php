<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">@lang('team::app.editTeam')</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        {!! Form::open(['id'=>'editTeamForm','class'=>'ajax-form','method'=>'POST']) !!}
        
            <div class="form-body">
                <div class="form-group">
                    <label class="required">@lang('app.name')</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $team->name }}"/>
                </div>
                
                <div class="form-group">
                    <label>@lang('app.description')</label>
                    <textarea class="form-control" name="description" placeholder="Description" rows="5">{{ $team->description }}</textarea>
                </div>

                <div class="form-actions">
                    <button class="btn btn-success">
                        <i class="fa fa-check"></i>
                        @lang('app.update')
                    </button>
                </div>
            </div>

        {!! Form::close() !!}
    </div>
</div>

<script>
    $('#editTeamForm').submit(function (e) {
        e.preventDefault();
        $.easyAjax({
            url: "{{route('member.team.update', $team)}}",
            container: '#editTeamForm',
            type: "PATCH",
            data: $(this).serialize(),
            success: function(res){
                if(res.status =='success'){
                    $('#teamModal').modal('hide');
                    location.reload(true);
                }
            }
        })
    });
</script>