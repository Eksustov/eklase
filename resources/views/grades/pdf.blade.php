<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Grades</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        td:first-child {
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>My Grades</h2>

    @php
        $months = $grades->pluck('created_at')->map->format('F Y')->unique();
        $subjects = $grades->pluck('subject.name')->unique();

        $gradesMatrix = [];

        foreach ($grades as $grade) {
            $month = $grade->created_at->format('F Y');
            $subject = $grade->subject->name;
            $gradesMatrix[$subject][$month][] = $grade->grade;
        }
    @endphp

    <table>
        <thead>
            <tr>
                <th>Subject</th>
                @foreach ($months as $month)
                    <th>{{ $month }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
                <tr>
                    <td>{{ $subject }}</td>
                    @foreach ($months as $month)
                        <td>
                            @if (isset($gradesMatrix[$subject][$month]))
                                {{ implode(', ', $gradesMatrix[$subject][$month]) }}
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
