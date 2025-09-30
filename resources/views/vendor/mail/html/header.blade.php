@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('images/logoPNG.png') }}" class="logo" alt="FurniScape Logo">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
