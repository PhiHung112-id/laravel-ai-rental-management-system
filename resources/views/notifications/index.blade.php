@extends('layouts.app')

@push('styles')
<style>
    body { background-color: #f4f7fe; font-family: 'Poppins', sans-serif; }

    .notif-page-banner {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        padding: 60px 0;
        color: white;
        text-align: center;
        border-radius: 0 0 40px 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-bottom: 40px;
    }

    .notif-page-banner h2 {
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .notif-page-banner p {
        font-size: 1rem;
        opacity: 0.85;
        font-weight: 400;
    }

    .timeline-container {
        position: relative;
        max-width: 850px;
        margin: 0 auto;
        padding: 20px 0;
    }

    .timeline-container::after {
        content: '';
        position: absolute;
        width: 4px;
        background-color: #e2e8f0;
        top: 0;
        bottom: 0;
        left: 35px;
        margin-left: -2px;
        border-radius: 10px;
    }

    .timeline-item {
        padding: 10px 30px 25px 30px;
        position: relative;
        background-color: inherit;
        width: 100%;
        padding-left: 75px;
    }

    .timeline-icon-box {
        position: absolute;
        width: 46px;
        height: 46px;
        left: 12px;
        top: 12px;
        border-radius: 50%;
        background: #ffffff;
        border: 3px solid #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3b82f6;
        z-index: 10;
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.25);
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .timeline-item.item-pinned .timeline-icon-box {
        border-color: #f59e0b;
        color: #f59e0b;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
    }

    .timeline-item:hover .timeline-icon-box {
        background: #2563eb;
        color: #ffffff;
        scale: 1.05;
        border-color: #2563eb;
    }

    .timeline-item.item-pinned:hover .timeline-icon-box {
        background: #f59e0b;
        color: #ffffff;
        border-color: #f59e0b;
    }

    .notif-main-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 25px 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.02);
        border: 1px solid rgba(0,0,0,0.01);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .notif-main-card.card-pinned {
        border-left: 5px solid #f59e0b;
    }

    .notif-main-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(37, 99, 235, 0.06);
        border-color: rgba(37, 99, 235, 0.15);
    }

    .notif-main-card.card-pinned:hover {
        border-color: #f59e0b;
    }

    .notif-card-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 8px;
        transition: color 0.2s ease;
    }

    .notif-main-card:hover .notif-card-title {
        color: #2563eb;
    }

    .notif-main-card.card-pinned:hover .notif-card-title {
        color: #d97706;
    }

    .notif-card-time {
        font-size: 0.78rem;
        color: #94a3b8;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 15px;
    }

    .notif-card-content {
        font-size: 0.92rem;
        color: #475569;
        line-height: 1.6;
        font-weight: 500;
    }

    .notif-tag-urgent {
        background-color: #fef3c7;
        color: #d97706;
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 6px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-left: 8px;
        vertical-align: middle;
        display: inline-block;
    }
</style>
@endpush

@section('content')

<div class="notif-page-banner">
    <div class="container">
        <h2>
            <i class="fa fa-bullhorn mr-2" style="color: #f59e0b;"></i>
            Bảng Tin Trung Tâm
        </h2>
        <p>Cập nhật các thông báo, quy định và thông tin vận hành từ Ban quản lý tòa nhà Quản Gia 5.0</p>
    </div>
</div>

<div class="container mb-5">
    <div class="timeline-container">

        @forelse($notifications as $row)
            @php
                $isPinned = $row->is_pinned == 1;
            @endphp

            <div class="timeline-item {{ $isPinned ? 'item-pinned' : '' }}">
                <div class="timeline-icon-box">
                    <i class="fa {{ $isPinned ? 'fa-thumbtack' : 'fa-bell' }}"></i>
                </div>

                <div class="notif-main-card {{ $isPinned ? 'card-pinned' : '' }}">
                    <h4 class="notif-card-title">
                        {{ $row->title }}

                        @if($isPinned)
                            <span class="notif-tag-urgent">
                                <i class="fa fa-paperclip mr-1"></i>Đã Ghim
                            </span>
                        @endif
                    </h4>

                    <div class="notif-card-time">
                        <i class="far fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y H:i') }}
                        •
                        <i class="far fa-user"></i>
                        Ban Quản Lý Tòa Nhà
                    </div>

                    <div class="notif-card-content">
                        {!! nl2br(e($row->content)) !!}
                    </div>
                </div>
            </div>

        @empty
            <div class="text-center py-5 bg-white rounded-lg shadow-sm border mx-auto" style="max-width: 600px; border-radius: 20px !important;">
                <i class="fa fa-bell-slash fa-4x text-muted mb-3 opacity-25"></i>
                <h5 class="font-weight-bold text-secondary">Bảng tin trống</h5>
                <p class="text-muted small mb-0 px-4">
                    Hiện tại Ban quản lý chưa phát hành thông báo mới nào dành cho cư dân tòa nhà.
                </p>
            </div>
        @endforelse

    </div>
</div>

@endsection