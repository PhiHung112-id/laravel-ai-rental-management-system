# 🏠 Quản Gia 5.0 – Hệ sinh thái quản lý không gian sống thông minh

**Quản Gia 5.0** là nền tảng số hỗ trợ quản lý phòng trọ, căn hộ dịch vụ và không gian sống theo hướng hiện đại. Hệ thống giúp chủ nhà, ban quản lý và cư dân dễ dàng quản lý thông tin phòng, khách thuê, hợp đồng, hóa đơn, thông báo và cộng đồng cư dân trên cùng một nền tảng.

Dự án được xây dựng theo mô hình **Laravel MVC**, kết hợp với công nghệ **AI** nhằm hỗ trợ dự đoán giá thuê/giá bán dựa trên các yếu tố như diện tích, vị trí, tiện ích và đặc điểm bất động sản. Mục tiêu của hệ thống là nâng cao hiệu quả quản lý, tối ưu trải nghiệm người dùng và hướng đến mô hình quản lý không gian sống thông minh.

---

## 🚀 Tính năng nổi bật

### 🏢 Quản lý phòng và căn hộ

Cho phép quản lý danh sách phòng/căn hộ, trạng thái thuê, thông tin chi tiết, giá thuê, tiện ích và hình ảnh minh họa.

### 👥 Quản lý khách thuê

Hỗ trợ lưu trữ thông tin khách thuê, lịch sử thuê phòng, hợp đồng và các thông tin liên quan trong quá trình sử dụng dịch vụ.

### 📄 Quản lý hợp đồng và hóa đơn

Hệ thống hỗ trợ quản lý hợp đồng thuê, hóa đơn dịch vụ, tiền phòng, điện, nước và các khoản phí phát sinh một cách tập trung.

### 🤖 Dự đoán giá bằng trí tuệ nhân tạo

Tích hợp mô hình **RandomForestRegressor** thông qua **Python/FastAPI**, giúp dự đoán giá thuê hoặc giá bán dựa trên dữ liệu đầu vào như diện tích, khu vực và tiện ích.

### 💬 Cộng đồng cư dân

Tích hợp sảnh chat real-time giúp cư dân trao đổi, nhận thông báo và tương tác với ban quản lý nhanh chóng.

### 🔔 Thông báo hệ thống

Hệ thống thông báo giúp ban quản lý gửi tin tức, cảnh báo, nhắc nhở thanh toán và các thông tin quan trọng đến cư dân.

### 🎨 Giao diện hiện đại

Giao diện được thiết kế theo phong cách hiện đại, thân thiện, dễ sử dụng và tương thích với cả máy tính lẫn thiết bị di động.

---

## 🛠 Công nghệ sử dụng

| Thành phần | Công nghệ                     |
| ---------- | ----------------------------- |
| Backend    | Laravel Framework, PHP 8.x    |
| Frontend   | Bootstrap 4, jQuery, AJAX     |
| AI/ML      | Python, FastAPI, Scikit-learn |
| Database   | MySQL                         |
| Web Server | Apache / Nginx                |
| Kiến trúc  | MVC                           |

---

## 📦 Hướng dẫn cài đặt

### 1. Clone dự án

```bash
git clone https://github.com/username/quan-gia-5.0.git
cd quan-gia-5.0
```

### 2. Cài đặt thư viện

```bash
composer install
npm install
```

### 3. Cấu hình môi trường

Sao chép file `.env.example` thành `.env`:

```bash
cp .env.example .env
```

Sau đó cấu hình thông tin kết nối cơ sở dữ liệu trong file `.env`:

```env
DB_DATABASE=ten_database
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Tạo khóa ứng dụng

```bash
php artisan key:generate
```

### 5. Chạy dự án

```bash
php artisan serve
```

Truy cập hệ thống tại:

```bash
http://127.0.0.1:8000
```

---

## 📸 Hình ảnh minh họa

> Có thể chèn các ảnh chụp màn hình giao diện hệ thống tại đây, ví dụ:
>
> * Trang chủ
> * Trang danh sách phòng
> * Trang chi tiết phòng
> * Trang quản lý hợp đồng
> * Trang hóa đơn
> * Trang dự đoán giá bằng AI
> * Giao diện chat cộng đồng cư dân

---

## 👤 Tác giả

Dự án được thực hiện bởi:

**Nguyễn Phi Hùng**
Sinh viên chuyên ngành **Kỹ thuật phần mềm**

* Email: `phihungone1@gmail.com`
* GitHub: `https://github.com/phihungone1`

---

## 📌 Mục tiêu dự án

Quản Gia 5.0 hướng đến việc xây dựng một hệ thống quản lý nhà trọ/căn hộ dịch vụ thông minh, giúp giảm thao tác thủ công, tăng tính minh bạch trong quản lý và nâng cao trải nghiệm cho cả chủ nhà lẫn cư dân.
