@extends('admin.layouts.app')

@section('content')

<style>
    .tenants-premium-wrapper {
        min-height: calc(100vh - 60px);
        padding-top: 20px;
    }

    .container-fluid {
        font-family: 'Poppins', sans-serif;
    }

    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        background: #fff;
        overflow: hidden;
    }

    .card-header-custom {
        background: #fff;
        padding: 20px 30px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title-custom {
        font-size: 1.2rem;
        font-weight: 700;
        color: #4e73df;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(78, 115, 223, 0.4);
        color: white;
    }

    .table-custom thead th {
        background-color: #f8f9fa;
        color: #555;
        font-weight: 600;
        border-top: none;
        border-bottom: 2px solid #eee;
        padding: 15px;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    .table-custom tbody td {
        padding: 15px;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
        color: #444;
        font-size: 0.95rem;
    }

    .table-custom tbody tr:hover {
        background-color: #fcfcfc;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        outline: none;
        border: 1px solid #d1d3e2;
        border-radius: 8px;
        padding: 5px 10px;
    }

    .badge-house {
        background: #e3f2fd;
        color: #1565c0;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .text-price { color: #2e7d32; font-weight: 600; }
    .text-debt { color: #c62828; font-weight: 700; }
    .text-paid { color: #8e10e1; font-weight: 600; }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s;
        margin: 0 2px;
        cursor: pointer;
    }

    .btn-view { background: #e0f2f1; color: #00897b; }
    .btn-view:hover { background: #00897b; color: white; }

    .btn-edit { background: #e3f2fd; color: #1976d2; }
    .btn-edit:hover { background: #1976d2; color: white; }

    .btn-print { background: #fff8e1; color: #b45309; }
    .btn-print:hover { background: #b45309; color: white; }

    .btn-delete { background: #ffebee; color: #c62828; }
    .btn-delete:hover { background: #c62828; color: white; }
</style>

<div class="tenants-premium-wrapper">
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom">

                    <div class="card-header-custom">
                        <h4 class="card-title-custom">
                            <i class="fa fa-users text-primary"></i>
                            Quản lý Thông tin Khách thuê
                        </h4>

                        <button class="btn btn-gradient btn-sm" id="new_tenant">
                            <i class="fa fa-plus-circle mr-1"></i>
                            Thêm khách mới
                        </button>
                    </div>

                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-custom table-hover mb-0" id="tenant-list">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="50">#</th>
                                        <th>Họ và tên khách thuê</th>
                                        <th class="text-center" width="120">Phòng thuê</th>
                                        <th class="text-right" width="150">Giá thuê gốc</th>
                                        <th class="text-right" width="150">Dư nợ hiện tại</th>
                                        <th class="text-center" width="150">Lần đóng cuối</th>
                                        <th class="text-center" width="200">Hành động</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($tenants as $key => $row)
                                        @php
                                            $dateIn = $row->date_in ? strtotime($row->date_in . ' 23:59:59') : time();
                                            $nowTime = strtotime(date('Y-m-d') . ' 23:59:59');

                                            $months = abs($nowTime - $dateIn);
                                            $months = floor($months / (30 * 60 * 60 * 24));

                                            $price = $row->house->price ?? 0;
                                            $payable = $price * $months;

                                            $paid = $row->payments->sum('amount');

                                            $lastPayment = $row->payments
                                                ->sortByDesc(function($payment) {
                                                    return $payment->created_at ?? $payment->date_created;
                                                })
                                                ->first();

                                            $lastPaymentDate = $lastPayment
                                                ? ($lastPayment->created_at ?? $lastPayment->date_created)
                                                : null;

                                            $outstanding = $payable - $paid;

                                            $fullname = trim(
                                                ($row->lastname ?? '') . ', ' .
                                                ($row->firstname ?? '') . ' ' .
                                                ($row->middlename ?? '')
                                            );
                                        @endphp

                                        <tr>
                                            <td class="text-center text-muted align-middle">
                                                {{ $key + 1 }}
                                            </td>

                                            <td class="align-middle">
                                                <b class="text-dark" style="font-size: 1rem;">
                                                    {{ ucwords($fullname) }}
                                                </b>
                                            </td>

                                            <td class="text-center align-middle">
                                                <span class="badge-house">
                                                    {{ $row->house->house_no ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <td class="text-right align-middle">
                                                <span class="text-price">
                                                    {{ number_format($price, 0, ',', '.') }} đ
                                                </span>
                                            </td>

                                            <td class="text-right align-middle">
                                                @if($outstanding > 0)
                                                    <span class="text-debt">
                                                        {{ number_format($outstanding, 0, ',', '.') }} VNĐ
                                                    </span>
                                                @else
                                                    <span class="text-paid">
                                                        0 VNĐ
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="text-center align-middle small">
                                                @if($lastPaymentDate)
                                                    {{ date('d/m/Y', strtotime($lastPaymentDate)) }}
                                                @else
                                                    <span class="text-muted small">Chưa đóng</span>
                                                @endif
                                            </td>

                                            <td class="text-center align-middle">
                                                <button class="btn-action btn-view view_payment"
                                                        type="button"
                                                        data-id="{{ $row->id }}"
                                                        title="Xem lịch sử thanh toán">
                                                    <i class="fa fa-eye"></i>
                                                </button>

                                                <button class="btn-action btn-edit edit_tenant"
                                                        type="button"
                                                        data-id="{{ $row->id }}"
                                                        title="Sửa thông tin khách">
                                                    <i class="fa fa-pen"></i>
                                                </button>

                                                <button class="btn-action btn-print print_contract"
                                                        type="button"
                                                        data-id="{{ $row->id }}"
                                                        title="In hợp đồng thuê nhà">
                                                    <i class="fa fa-file-contract"></i>
                                                </button>

                                                <button class="btn-action btn-delete delete_tenant"
                                                        type="button"
                                                        data-id="{{ $row->id }}"
                                                        title="Xóa cư dân">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#tenant-list').DataTable({
        language: {
            sProcessing: "Đang xử lý...",
            sLengthMenu: "Hiển thị _MENU_ dòng",
            sZeroRecords: "Không tìm thấy khách thuê nào phù hợp",
            sInfo: "Hiện _START_ đến _END_ của _TOTAL_ khách",
            sSearch: "Tìm nhanh:",
            oPaginate: {
                sNext: '<i class="fa fa-chevron-right"></i>',
                sPrevious: '<i class="fa fa-chevron-left"></i>'
            }
        }
    });
});

$('#new_tenant').click(function(){
    uni_modal(
        "Thêm Khách Thuê Mới",
        "{{ route('admin.tenants.manage') }}",
        "mid-large"
    );
});

$(document).on('click', '.view_payment', function(){
    uni_modal(
        "Lịch sử Thanh Toán",
        "{{ url('/admin/tenants/payment-history') }}/" + $(this).attr('data-id'),
        "large"
    );
});

$(document).on('click', '.edit_tenant', function(){
    uni_modal(
        "Cập nhật Thông Tin Cư Dân",
        "{{ url('/admin/tenants/manage') }}/" + $(this).attr('data-id'),
        "mid-large"
    );
});

$(document).on('click', '.print_contract', function(){
    var id = $(this).attr('data-id');
    window.open("{{ url('/admin/tenants/print-contract') }}/" + id, "_blank");
});

$(document).on('click', '.delete_tenant', function(){
    _conf(
        "Bạn có chắc chắn muốn xóa khách thuê này khỏi hệ thống?",
        "delete_tenant",
        [$(this).attr('data-id')]
    );
});

function delete_tenant(id){
    start_load();

    $.ajax({
        url: "{{ url('/admin/tenants/delete') }}/" + id,
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(resp){
            if(resp == 1){
                alert_toast("Đã xóa dữ liệu khách thuê thành công", 'success');

                setTimeout(function(){
                    location.reload();
                }, 1500);
            } else {
                alert_toast("Có lỗi xảy ra trong quá trình xóa dữ liệu!", 'danger');
                end_load();
            }
        },
        error: function(){
            alert_toast("Lỗi server!", 'danger');
            end_load();
        }
    });
}
</script>

@endsection