<!DOCTYPE html>
<html>
<head>
    <title>Laravel Calendar</title>
    <style>
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            max-width: 900px;
            margin: auto;
        }
        .day, .header {
            border: 1px solid #ccc;
            min-height: 100px;
            padding: 5px;
        }
        .header {
            background: #eee;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

@php
    $prevMonth = $month == 1 ? 12 : $month - 1;
    $prevYear = $month == 1 ? $year - 1 : $year;
    $nextMonth = $month == 12 ? 1 : $month + 1;
    $nextYear = $month == 12 ? $year + 1 : $year;
@endphp

<div style="display: flex; justify-content: center; align-items: center; position: relative; margin-bottom: 20px;">
    <a href="?month={{ $prevMonth }}&year={{ $prevYear }}">⬅️</a>
    <strong style="margin: 0 15px;">{{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</strong>
    <a href="?month={{ $nextMonth }}&year={{ $nextYear }}">➡️</a>

    <a href="{{ url('/calender') }}" style="position: absolute; right: 0;">nu</a>
</div>

<div class="calendar">
    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
        <div class="header">{{ $day }}</div>
    @endforeach

    {{--    empty days    --}}
    @for ($i = 0; $i < $startDay; $i++)
        <div class="day"></div>
    @endfor

    {{-- the rest of the calender --}}
    @for ($day = 1; $day <= $daysInMonth; $day++)
        @php
            $date = \Carbon\Carbon::create($year, $month, $day)->toDateString();
            $dayEvents = collect($events)->where('date', $date);
        @endphp
        <div class="day">
            <strong>{{ $day }}</strong>
            @foreach($dayEvents as $event)
                <div style="font-size: 0.85em;">{{ $event['title'] }}</div>
            @endforeach
        </div>
    @endfor
</div>

</body>
</html>
