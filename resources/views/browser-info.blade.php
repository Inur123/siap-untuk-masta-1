<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browser Info</title>
</head>
<body>
    <h1>Informasi Browser</h1>

    <p><strong>Browser:</strong> {{ $browser }}</p>
    <p><strong>Perangkat:</strong> {{ $device }}</p>
    <p><strong>Sistem Operasi:</strong> {{ $os }}</p>

    @if ($device == 'Mobile')
        <p>Anda menggunakan perangkat mobile!</p>
    @elseif ($device == 'Tablet')
        <p>Anda menggunakan perangkat tablet!</p>
    @else
        <p>Anda menggunakan perangkat desktop!</p>
    @endif
</body>
</html>
