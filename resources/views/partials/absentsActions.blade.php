@can($editGate)
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.presence', [$row->id,$register_def,$session_id]) }}">
        Absen
    </a>
    <a class="btn btn-xs btn-info" href="{{ route('admin.' . $crudRoutePart . '.bill', [$row->id,$register_def,$session_id]) }}">
        Bayar
    </a>
@endcan