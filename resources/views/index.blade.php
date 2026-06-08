<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Gia 5.0 - Danh sách phòng</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Danh sách Căn hộ / Phòng trọ</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Số phòng</th>
                <th>Giá thuê</th>
                <th>Mô tả chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach($houses as $house)
            <tr>
                <td>{{ $house->id }}</td>
                <td>{{ $house->house_no }}</td>
                <td>{{ number_format($house->price) }} VNĐ</td>
                <td>{{ $house->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>