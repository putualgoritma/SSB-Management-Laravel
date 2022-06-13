@can($editGate)
    @if(empty($row->session_id))
    <a class="btn btn-xs btn-primary" href="{{ route('admin.' . $crudRoutePart . '.sessionsCreate',['schedule_id'=>$row->id,'grade_periode_id'=>$grade_periode_id]) }}">
        Buka Sessi
    </a>
    @else
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.sessionsCreate',['schedule_id'=>$row->id,'grade_periode_id'=>$grade_periode_id]) }}">
        Edit Sessi
    </a>
    <a class="btn btn-xs btn-success" href="{{ route('admin.absents.list', [$row->id]) }}">
        Absensi
    </a>
    @endif    
@endcan