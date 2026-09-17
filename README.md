# Base code — Website đặt vé xem phim/sự kiện (Laravel, Clean Architecture)

Đây là **bộ khung (scaffold)**, không phải project Laravel đầy đủ. Bạn cần tự tạo project Laravel
bằng Laragon trước, sau đó copy các file/thư mục trong bộ này vào để mỗi người bắt tay code song song.

## 1. Kiến trúc áp dụng (Clean Architecture rút gọn cho Laravel)

Mỗi module có 4 lớp, phụ thuộc đi theo 1 chiều:

```
Controller  →  Service (business logic)  →  Repository Interface  →  Repository (Eloquent/Mongo)
   ↑                                                                          ↓
 Route/View                                                                Model
```

- **Controller**: chỉ nhận request, gọi Service, trả về View/JSON. Không viết logic nghiệp vụ ở đây.
- **Service**: chứa toàn bộ luật nghiệp vụ (validate voucher, giữ ghế, chống spam thêm phim...).
- **Repository Interface**: hợp đồng truy xuất dữ liệu — Service chỉ biết interface này, KHÔNG biết Eloquent hay MongoDB.
- **Repository (Eloquent...)**: cài đặt cụ thể bằng Model.

**Lợi ích:** nếu sau này đổi từ MySQL (SQL) sang MongoDB (NoSQL), mỗi người chỉ cần viết lại
`Eloquent...Repository` bằng bản Mongo tương ứng, **không đụng vào Service/Controller/View**.

## 2. Cấu trúc 5 module (5 người)

```
app/Modules/
  Auth/       → NGƯỜI 1: đăng ký, đăng nhập, phân quyền
  Movie/      → NGƯỜI 2: quản lý phim, suất chiếu (Admin + trang xem phim User)
  Booking/    → NGƯỜI 3: chọn ghế, giữ ghế tạm, xác nhận đặt vé, lịch sử vé
  Voucher/    → NGƯỜI 4: áp voucher (ràng buộc giá trị đơn/số lượng/thời hạn), thanh toán
  Report/     → NGƯỜI 5: layout chung Admin + User, dashboard, báo cáo doanh thu
```

Mỗi module tự chứa đủ: `Models/`, `Repositories/`, `Services/`, `Http/Controllers/`, `routes/web.php`, `migrations/`.
View blade tương ứng nằm ở `resources/views/<ten-module>-module/`.

**Mỗi người vừa code logic (Service/Repository) vừa code giao diện (view Blade) cho module của mình** —
đúng theo yêu cầu vừa làm UI vừa làm logic.

## 3. Các bước tích hợp vào project Laravel thật (làm 1 lần, ai làm cũng được)

1. Tạo project Laravel qua Laragon: `composer create-project laravel/laravel ten-du-an`
2. Copy toàn bộ thư mục `app/Modules/` trong bộ này vào `app/Modules/` của project thật
3. Copy `routes/web.php` trong bộ này, **thay thế** file `routes/web.php` gốc của Laravel
4. Copy `resources/views/*` vào `resources/views/` của project thật
5. Copy `app/Http/Middleware/CheckRole.php` vào đúng vị trí, rồi đăng ký middleware:
   - Laravel 11: mở `bootstrap/app.php`, thêm vào `withMiddleware()`:
     ```php
     $middleware->alias(['role' => \App\Http\Middleware\CheckRole::class]);
     ```
   - Laravel 10: mở `app/Http/Kernel.php`, thêm vào mảng `$middlewareAliases`
6. Mở `composer.json`, thêm namespace module vào phần `autoload.psr-4`:
   ```json
   "App\\Modules\\": "app/Modules/"
   ```
   rồi chạy: `composer dump-autoload`
7. Đăng ký binding Interface ↔ Repository trong `app/Providers/AppServiceProvider.php` (phần `register()`):
   ```php
   $this->app->bind(\App\Modules\Auth\Repositories\AuthRepositoryInterface::class, \App\Modules\Auth\Repositories\EloquentAuthRepository::class);
   $this->app->bind(\App\Modules\Movie\Repositories\MovieRepositoryInterface::class, \App\Modules\Movie\Repositories\EloquentMovieRepository::class);
   $this->app->bind(\App\Modules\Booking\Repositories\BookingRepositoryInterface::class, \App\Modules\Booking\Repositories\EloquentBookingRepository::class);
   $this->app->bind(\App\Modules\Voucher\Repositories\VoucherRepositoryInterface::class, \App\Modules\Voucher\Repositories\EloquentVoucherRepository::class);
   $this->app->bind(\App\Modules\Report\Repositories\ReportRepositoryInterface::class, \App\Modules\Report\Repositories\EloquentReportRepository::class);
   ```
8. Copy các file trong `app/Modules/*/migrations/` vào `database/migrations/` của project thật
   (giữ nguyên tên file — tên có ngày tháng để chạy đúng thứ tự), rồi chạy:
   ```
   php artisan migrate
   ```
9. Mỗi người mở file `.env`, chỉnh `DB_DATABASE` trỏ về cùng 1 database MySQL chung của nhóm
   (do Laragon tạo), để migration của 5 người không xung đột.

## 4. Chọn SQL hay NoSQL?

Mặc định bộ code dùng **MySQL qua Eloquent** (khớp với Laragon sẵn có).
Nếu nhóm muốn thử NoSQL (MongoDB) cho 1 module nào đó (ví dụ Booking để lưu lịch sử vé):
- Cài package `mongodb/laravel-mongodb`
- Viết lại riêng class `Eloquent...Repository` của module đó bằng Model kế thừa `MongoDB\Laravel\Eloquent\Model`
- Không cần sửa gì ở Service/Controller/View vì chúng chỉ phụ thuộc vào Interface

## 5. Quy trình làm việc nhóm (Git)

- Mỗi người tạo 1 branch riêng: `feature/auth`, `feature/movie`, `feature/booking`, `feature/voucher`, `feature/report`
- Chỉ merge vào `main` sau khi đã test chạy được trên máy mình
- Vì mỗi module là 1 thư mục riêng trong `app/Modules/`, hạn chế tối đa xung đột (conflict) khi merge
- File `routes/web.php` gộp và `AppServiceProvider.php` là 2 file dùng chung — cần thống nhất khi ai đó thêm route/binding mới, tránh ghi đè lẫn nhau

## 6. Việc còn cần làm thêm (mỗi người tự hoàn thiện cho module mình)

- Validate đầy đủ hơn (Form Request riêng thay vì validate trực tiếp trong Controller)
- CSS/giao diện đẹp hơn (hiện tại view chỉ là HTML thô để chạy được)
- AJAX thật cho giữ ghế/áp voucher (hiện đã có route JSON sẵn, chỉ cần viết JS gọi fetch/axios)
- Job/Scheduler tự động gọi `releaseExpiredHolds()` định kỳ (Booking module) thay vì chỉ gọi khi có người load lại trang
