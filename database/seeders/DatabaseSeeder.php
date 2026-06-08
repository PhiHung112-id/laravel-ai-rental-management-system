<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Chèn dữ liệu bảng Categories (Phân loại)
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Nhà song lập'],
            ['id' => 2, 'name' => 'Nhà ở dành cho một gia đình'],
            ['id' => 3, 'name' => 'Nhà ở nhiều gia đình'],
            ['id' => 4, 'name' => 'Nhà 2 tầng'],
        ]);

        // 2. Chèn dữ liệu bảng Locations (Khu vực)
        DB::table('locations')->insert([
            ['id' => 1, 'location_name' => 'Thủ Dầu Một', 'description' => null, 'img_path' => '1767701880_thanh-pho-thu-dau-mot-768x510.png'],
            ['id' => 2, 'location_name' => 'Thuận An', 'description' => null, 'img_path' => '1767701880_quy_hoach_su_dung_dat_thanh_pho_thuan_an_1.jpg'],
            ['id' => 3, 'location_name' => 'Dĩ An', 'description' => null, 'img_path' => '1767701880_TP.-Di-An.jpg'],
            ['id' => 5, 'location_name' => 'Bến Cát', 'description' => null, 'img_path' => '1767703260_bencat.jpg'],
        ]);

        // 3. Chèn dữ liệu bảng Customers (Khách hàng)
        DB::table('customers')->insert([
            ['id' => 1, 'name' => 'Nguyễn Phi Hùng', 'email' => 'phihungone@gmail.com', 'password' => 'e10adc3949ba59abbe56e057f20f883e', 'google_id' => null, 'phone' => '094770967', 'address' => 'VIET NAM', 'avatar' => null, 'created_at' => '2025-12-22 16:42:52'],
            ['id' => 2, 'name' => 'Huy', 'email' => 'huy@gmail.com', 'password' => 'e10adc3949ba59abbe56e057f20f883e', 'google_id' => null, 'phone' => '0909090909', 'address' => 'Bình Dương', 'avatar' => null, 'created_at' => '2026-01-06 18:23:42'],
            ['id' => 3, 'name' => 'Khang', 'email' => 'khang@gmail.com', 'password' => 'e10adc3949ba59abbe56e057f20f883e', 'google_id' => null, 'phone' => '0808080808', 'address' => 'Bình Dương', 'avatar' => null, 'created_at' => '2026-01-06 20:40:02'],
            ['id' => 6, 'name' => 'Hùng Nguyễn', 'email' => 'phihungone1@gmail.com', 'password' => '3033265d1d6efe2ad2f45d42ef9dee52', 'google_id' => '103212652878384300874', 'phone' => '', 'address' => '', 'avatar' => 'https://lh3.googleusercontent.com/a/ACg8ocLiuIfk6qxW_o_V-ufzv3HSrty70PokudndGHAVgWsFdQjPi-E=s96-c', 'created_at' => '2026-01-09 23:30:41'],
        ]);

        // 4. Chèn dữ liệu bảng Houses (Danh sách phòng)
        DB::table('houses')->insert([
            ['id' => 1, 'house_no' => 'P.101', 'location' => 'Trường Đại học Kinh tế - Kỹ thuật Bình Dương...', 'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3917.091556995443!2d106.70874177480762!3d10.956456339203484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d751e024b99d%3A0x20b3f9b4c8fdc732!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaW5oIHThur8gLSBL4bu5IHRodeG6rXQgQsOsbmggRMawxqFuZw!5e0!3m2!1svi!2s!4v1766418152032!5m2!1svi!2s', 'category_id' => 1, 'location_id' => 3, 'description' => 'Phòng ngay tầng trệt, gần chỗ để xe...', 'price' => 1250000, 'sale_price' => 125000000, 'img_path' => '1767701940_nhasonglap.jpg'],
            ['id' => 2, 'house_no' => 'P.102', 'location' => 'Trường Đại học Kinh tế - Kỹ thuật Bình Dương...', 'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3917.091556995443!2d106.70874177480762!3d10.956456339203484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d751e024b99d%3A0x20b3f9b4c8fdc732!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaW5oIHThur8gLSBL4bu5IHRodeG6rXQgQsOsbmggRMawxqFuZw!5e0!3m2!1svi!2s!4v1766418152032!5m2!1svi!2s', 'category_id' => 1, 'location_id' => 1, 'description' => 'Phòng có gác lửng đúc kiên cố...', 'price' => 1450000, 'sale_price' => 145000000, 'img_path' => '1767701940_nhasonglap.jpg'],
            ['id' => 3, 'house_no' => 'P.103', 'location' => 'Trường Đại học Kinh tế - Kỹ thuật Bình Dương...', 'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3917.091556995443!2d106.70874177480762!3d10.956456339203484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d751e024b99d%3A0x20b3f9b4c8fdc732!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaW5oIHThur8gLSBL4bu5IHRodeG6rXQgQsOsbmggRMawxqFuZw!5e0!3m2!1svi!2s!4v1766418152032!5m2!1svi!2s', 'category_id' => 1, 'location_id' => 2, 'description' => 'Gác gỗ, diện tích nhỏ gọn...', 'price' => 1100000, 'sale_price' => 110000000, 'img_path' => '1767702120_nhasonglap.jpg'],
            ['id' => 6, 'house_no' => 'P.201', 'location' => 'Trường Đại học Kinh tế - Kỹ thuật Bình Dương...', 'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3917.091556995443!2d106.70874177480762!3d10.956456339203484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d751e024b99d%3A0x20b3f9b4c8fdc732!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaW5oIHThur8gLSBL4bu5IHRodeG6rXQgQsOsbmggRMawxqFuZw!5e0!3m2!1svi!2s!4v1766418152032!5m2!1svi!2s', 'category_id' => 2, 'location_id' => 3, 'description' => 'Full nội thất: Máy lạnh Panasonic...', 'price' => 3200000, 'sale_price' => 320000000, 'img_path' => '1767702300_nhacho1giading.jpg'],
            ['id' => 15, 'house_no' => 'P.305', 'location' => 'Trường Đại học Kinh tế - Kỹ thuật Bình Dương...', 'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3917.091556995443!2d106.70874177480762!3d10.956456339203484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d751e024b99d%3A0x20b3f9b4c8fdc732!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaW5oIHThur8gLSBL4bu5IHRodeG6rXQgQsOsbmggRMawxqFuZw!5e0!3m2!1svi!2s!4v1766418152032!5m2!1svi!2s', 'category_id' => 3, 'location_id' => 1, 'description' => 'Phong cách Decor Vintage...', 'price' => 4300000, 'sale_price' => 430000000, 'img_path' => '1767702480_nhachonhieugiading.jpg'],
            ['id' => 16, 'house_no' => 'Kiot 01', 'location' => 'Trường Đại học Kinh tế - Kỹ thuật Bình Dương...', 'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3917.091556995443!2d106.70874177480762!3d10.956456339203484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d751e024b99d%3A0x20b3f9b4c8fdc732!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaW5oIHThur8gLSBL4bu5IHRodeG6rXQgQsOsbmggRMawxqFuZw!5e0!3m2!1svi!2s!4v1766418152032!5m2!1svi!2s', 'category_id' => 4, 'location_id' => 1, 'description' => 'Mặt tiền đường lớn...', 'price' => 6500000, 'sale_price' => 650000000, 'img_path' => '1767702480_nha2tang.jpg'],
            ['id' => 17, 'house_no' => 'Kiot 02', 'location' => 'Trường Đại học Kinh tế - Kỹ thuật Bình Dương...', 'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3917.091556995443!2d106.70874177480762!3d10.956456339203484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3174d751e024b99d%3A0x20b3f9b4c8fdc732!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaW5oIHThur8gLSBL4bu5IHRodeG6rXQgQsOsbmggRMawxqFuZw!5e0!3m2!1svi!2s!4v1766418152032!5m2!1svi!2s', 'category_id' => 4, 'location_id' => 1, 'description' => 'Cạnh cổng ra vào khu trọ...', 'price' => 5800000, 'sale_price' => 580000000, 'img_path' => '1767702480_nha2tang.jpg']
        ]);

        // 5. Chèn dữ liệu bảng Tenants (Người thuê phòng)
        DB::table('tenants')->insert([
            ['id' => 3, 'firstname' => 'NGUYEN', 'middlename' => 'PHI', 'lastname' => 'HUNG', 'email' => 'phihungone1@gmail.com', 'contact' => '1234567', 'house_id' => 2, 'status' => 0, 'date_in' => '2025-07-15'],
            ['id' => 7, 'firstname' => 'Bình', 'middlename' => 'Thị', 'lastname' => 'Trần', 'email' => 'binh.tran@gmail.com', 'contact' => '0902223334', 'house_id' => 2, 'status' => 1, 'date_in' => '2024-02-15'],
            ['id' => 13, 'firstname' => 'Cường', 'middlename' => 'Mạnh', 'lastname' => 'Lê', 'email' => 'cuong.le@gmail.com', 'contact' => '0903334445', 'house_id' => 3, 'status' => 1, 'date_in' => '2025-09-20'],
            ['id' => 26, 'firstname' => 'Nguyễn Phi', 'middlename' => '', 'lastname' => 'Hùng', 'email' => 'phihungone@gmail.com', 'contact' => '094770967', 'house_id' => 15, 'status' => 1, 'date_in' => '2025-12-30']
        ]);

        // 6. Chèn dữ liệu bảng System Settings (Cấu hình)
        DB::table('system_settings')->insert([
            ['id' => 1, 'name' => 'Quản Gia 5.0', 'email' => 'lienhe@quangia.vn', 'address' => 'Thủ Dầu Một, Bình Dương', 'contact' => '0988.888.888', 'cover_img' => '1603344720_1602738120_pngtree-purple-hd-business-banner-image_5493.jpg', 'about_content' => 'Hệ thống quản lý chuyên nghiệp Quản Gia 5.0']
        ]);
    }
}