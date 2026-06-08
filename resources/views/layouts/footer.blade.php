<style>
.premium-footer{
    background-color:#0f172a!important;
    color:#94a3b8!important;
    padding-top:70px;
    border-top:4px solid #f4b619;
    position:relative;
    z-index:1;
    clear:both;
}

.premium-footer *{
    box-sizing:border-box;
}

.premium-footer a{
    text-decoration:none!important;
}

.footer-brand-title{
    font-size:1.4rem;
    font-weight:800;
    color:#fff!important;
}

.footer-brand-title span{
    color:#f4b619!important;
}

.footer-heading{
    font-size:1.05rem;
    font-weight:700;
    color:#fff!important;
    text-transform:uppercase;
    margin-bottom:25px;
    position:relative;
    padding-bottom:10px;
}

.footer-heading::after{
    content:'';
    position:absolute;
    bottom:0;
    left:0;
    width:35px;
    height:3px;
    background:#3b82f6;
    border-radius:10px;
}

.footer-link{
    color:#94a3b8!important;
    display:block;
    margin-bottom:12px;
    font-size:.92rem;
    font-weight:500;
    transition:all .25s ease;
}

.footer-link:hover{
    color:#f4b619!important;
    transform:translateX(5px);
}

.footer-contact-item{
    display:flex;
    align-items:flex-start;
    margin-bottom:15px;
    font-size:.92rem;
    color:#94a3b8!important;
}

.footer-contact-icon{
    color:#3b82f6!important;
    margin-right:12px;
    margin-top:3px;
    width:20px;
    text-align:center;
}

.footer-social-box{
    display:flex;
    gap:10px;
    margin-top:20px;
}

.footer-social-icon{
    width:38px;
    height:38px;
    background:#1e293b;
    color:#cbd5e1!important;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:all .3s ease;
}

.footer-social-icon:hover{
    color:white!important;
    transform:translateY(-3px);
}

.footer-social-icon.fb:hover{
    background:#1877f2;
}

.footer-social-icon.yt:hover{
    background:#ff0000;
}

.footer-social-icon.zl:hover{
    background:#0068ff;
}

.footer-bottom{
    border-top:1px solid #1e293b;
    padding:25px 0;
    margin-top:50px;
    font-size:.88rem;
}
</style>

<footer class="premium-footer">

    <div class="container">

        <div class="row">

            <div class="col-lg-4 col-md-6 mb-5">

                <h5 class="footer-brand-title mb-3">

                    <i class="fa fa-laptop-house text-primary mr-2"></i>

                    QUẢN GIA <span>5.0</span>

                </h5>

                <p class="small"
                   style="line-height:1.8;color:#94a3b8;">

                    Hệ sinh thái quản lý và tìm kiếm
                    không gian sống thông minh.

                </p>

                <div class="footer-social-box">

                    <a href="#"
                       class="footer-social-icon fb">

                        <i class="fab fa-facebook-f"></i>

                    </a>

                    <a href="#"
                       class="footer-social-icon yt">

                        <i class="fab fa-youtube"></i>

                    </a>

                    <a href="#"
                       class="footer-social-icon zl">

                        <i class="fa fa-comments"></i>

                    </a>

                </div>

            </div>

            <div class="col-lg-4 col-md-6 mb-5">

                <h5 class="footer-heading">
                    Liên Kết Nhanh
                </h5>

                <a href="{{ url('/') }}"
                   class="footer-link">

                    <i class="fa fa-chevron-right mr-2"></i>

                    Trang chủ

                </a>

                <a href="{{ url('/rooms') }}"
                   class="footer-link">

                    <i class="fa fa-chevron-right mr-2"></i>

                    Danh sách phòng

                </a>

                <a href="{{ url('/contact') }}"
                   class="footer-link">

                    <i class="fa fa-chevron-right mr-2"></i>

                    Liên hệ

                </a>

            </div>

            <div class="col-lg-4 col-md-12 mb-4">

                <h5 class="footer-heading">
                    Thông Tin Liên Hệ
                </h5>

                <div class="footer-contact-item">

                    <i class="fa fa-map-marker-alt footer-contact-icon"></i>

                    <span>
                        Bình Dương, Việt Nam
                    </span>

                </div>

                <div class="footer-contact-item">

                    <i class="fa fa-phone-alt footer-contact-icon"></i>

                    <span class="font-weight-bold text-white">
                        1900 1560
                    </span>

                </div>

                <div class="footer-contact-item">

                    <i class="fa fa-envelope footer-contact-icon"></i>

                    <span>
                        cskh@quangia50.vn
                    </span>

                </div>

            </div>

        </div>

        <div class="footer-bottom text-center">

            <p class="mb-0"
               style="color:#64748b;">

                &copy; {{ date('Y') }}

                <span class="text-white font-weight-bold">
                    Quản Gia 5.0
                </span>

                - GPS Team

            </p>

        </div>

    </div>

</footer>