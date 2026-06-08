<div class="container-fluid">

    <table class="table">

        <tr>
            <th width="180">Khách hàng</th>
            <td>{{ $requestItem->customer->name ?? '' }}</td>
        </tr>

        <tr>
            <th>Số điện thoại</th>
            <td>{{ $requestItem->customer->phone ?? '' }}</td>
        </tr>

        <tr>
            <th>Email</th>
            <td>{{ $requestItem->customer->email ?? '' }}</td>
        </tr>

        <tr>
            <th>Thông tin phòng</th>
            <td>{{ $requestItem->room_info }}</td>
        </tr>

        <tr>
            <th>Tổng tiền góp</th>
            <td>
                {{ number_format($requestItem->total_price,0,',','.') }} VNĐ
            </td>
        </tr>

        <tr>
            <th>Kỳ hạn</th>
            <td>{{ $requestItem->months }} tháng</td>
        </tr>

    </table>

</div>