<table>
    <style>
        tr {
            font-size: smaller;
        }
    </style>
    <thead>
    <tr>
        <th style="text-align: center;">{{ __('SL')}}</th>
        <th style="text-align: center;">{{ __('Plan Name')}}</th>
        <th style="text-align: center;">{{ __('User Name')}}</th>
        <th style="text-align: center;">{{ __('User Phone')}}</th>
        <th style="text-align: center;">{{ __('Storage Limit')}}</th>
        <th style="text-align: center;">{{ __('Monthly Request')}}</th>
        <th style="text-align: center;">{{ __('Daily Request')}}</th>
        <th style="text-align: center;">{{ __('Captcha')}}</th>
        <th style="text-align: center;">{{ __('Manual Request')}}</th>
        <th style="text-align: center;">{{ __('Mail Activity')}}</th>
        <th style="text-align: center;">{{ __('Created Date')}}</th>
        <th style="text-align: center;">{{ __('Created Time')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $key=> $value)
        <tr>
            <td style="text-align: center;">{{ $key+1 }}</td>
            <td style="text-align: center;">{{ $value->name ?? null }}</td>
            <td style="text-align: center;">{{ $value->user->name ?? null }}</td>
            <td style="text-align: center;">{{ $value->user->phone ?? null }}</td>
            <td style="text-align: center;">{{ $value->storage_limit ?? null }}</td>
            <td style="text-align: center;">{{ $value->monthly_req ?? null }}</td>
            <td style="text-align: center;">{{ $value->daily_req ?? null }}</td>
            <td style="text-align: center;">
                @if($value->captcha ==1)
                    <span style="color: green">Active</span>
                @else
                    <span style="color: red">Inactive</span>
                @endif
            </td>
            <td style="text-align: center;">
                @if($value->menual_req ==1)
                    <span style="color: green">Active</span>
                @else
                    <span style="color: red">Inactive</span>
                @endif
            </td>
            <td style="text-align: center;">
                @if($value->mail_activity ==1)
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
