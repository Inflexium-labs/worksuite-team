@if(user()->cans('view_team'))
<li>
    <a href="{{ route('admin.team.index') }}" class="waves-effect">
        <i class="fa fa-users" aria-hidden="true"></i>
        <span class="hide-menu">@lang('team::app.team')</span></a>
</li>
@endif
