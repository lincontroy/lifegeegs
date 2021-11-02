<table>
    <style>
        tr {
            font-size: smaller;
        }
    </style>
    <thead>
    <tr>
        <th style="text-align: center;">{{__('SL')}}</th>
        <th style="text-align: center;">{{__('Gateway Name')}}</th>
        <th style="text-align: center;">{{__('User Name')}}</th>
        <th style="text-align: center;">{{__('User Phone')}}</th>
        <th style="text-align: center;">{{__('Amount')}}</th>
        <th style="text-align: center;">{{__('Trx Id')}}</th>
        <th style="text-align: center;">{{__('Status')}}</th>
        <th style="text-align: center;">{{__('Created Date')}}</th>
        <th style="text-align: center;">{{__('Created Time')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $key=> $value)
        <tr>
            <td style="text-align: center;">{{ $key+1 }}</td>
            <td style="text-align: center;">{{ $value->getway->name ?? null }}</td>
            <td style="text-align: center;">{{ $value->user->name ?? null }}</td>
            <td style="text-align: center;">{{ $value->user->phone ?? null }}</td>
            <td style="text-align: center;">{{ $value->amount ?? null }}</td>
            <td style="text-align: center;">{{ $value->trx_id ?? null }}</td>
            <td style="text-align: center;">
                @if($value->status ==1)
                    <span style="color: green">Active</span>
                @else
                    <span style="color: red">Inactive</span>
                @endif
            </td>
            <td style="text-align: center;">{{ $value->created_at->format('d.m.Y') ?? null }}</td>
            <td style="text-align: center;">{{ $value->created_at->diffForHumans() ?? null }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
