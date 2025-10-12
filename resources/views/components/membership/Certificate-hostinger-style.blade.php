<div x-data="printInit" class="flex flex-col items-center w-full space-y-6">
    <!-- بطاقة الشهادة -->
    <div class="scrollbar flex flex-col items-center w-full m-0 p-0">
        <div id="certificateCard" x-ref="card">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&family=Playfair+Display:wght@400;700&display=swap');

                .certificate {
                    max-width: 1050px;
                    margin: 50px auto;
                    background: #fff;
                    border-radius: 25px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
                    padding: 60px 70px;
                    color: #333;
                    display: flex;
                    flex-direction: column;
                    position: relative;
                    font-family: 'Cairo', sans-serif;
                }

                /* رفع الصور قليلاً */
                .logo {
                    width: 100px;
                    display: block;
                    margin: 0 auto 15px auto;
                }

                .footer {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding-top: 15px;
                    margin-bottom: 10px;
                }

                .signature img {
                    height: 100px;
                }

                .qr-code {
                    width: 85px;
                    height: 85px;
                }

                /* تحريك النصوص قليلاً للأسفل */
                .sides {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    gap: 80px;
                    margin-bottom: 80px;
                    /* زيادة المسافة للنصوص لتكون في الوسط */
                }

                /*side left content */
                .side.left-content {
                    margin-top: 20px;
                }

                .side {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }

                .right {
                    text-align: right;
                    direction: rtl;
                }

                .left {
                    text-align: left;
                    direction: ltr;
                }

                .title {
                    font-size: 28px;
                    font-weight: 700;
                    color: #bfa45f;
                    margin-bottom: 25px;
                    font-family: 'Playfair Display', serif;
                    text-transform: uppercase;
                }

                .content {
                    font-size: 16px;
                    line-height: 1.9;
                    margin-bottom: 40px;
                    min-height: 110px;
                }

                .member-info {
                    font-size: 14px;
                    line-height: 1.9;
                    color: #555;
                }

                .info-row {
                    margin-bottom: 5px;
                }

                /* الرقم أسفل كل شيء */
                .unique-id {
                    text-align: center;
                    font-size: 15px;
                    font-weight: 600;
                    color: #bfa45f;
                    margin-top: 20px;
                }

                .certificate::before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: radial-gradient(circle at top center, rgba(191, 164, 95, 0.06), transparent 70%);
                    z-index: 0;
                    border-radius: 25px;
                }

                .certificate * {
                    position: relative;
                    z-index: 1;
                }
            </style>

            <div class="certificate">
                <!-- الشعار -->
                <img src="{{ asset('favicon.ico') }}" alt="Logo" class="logo">

                <div class="sides">
                    <!-- الجهة اليمنى (عربي) -->
                    <div class="side right">
                        <div class="title">شهادة عضوية</div>
                        <div class="content">
                            يمنح موقع <strong>نسق</strong> هذه الشهادة للعضو الموقر تقديرًا لانضمامه المتميز، وإسهامه
                            الإيجابي في دعم مجتمعنا، وتشجيعًا له على الاستمرار في مسيرة التميز والعطاء.
                        </div>
                        <div class="member-info">
                            <div class="info-row"><strong>الاسم:</strong> محمد أحمد علي</div>
                            <div class="info-row"><strong>نوع العضوية:</strong> ذهبية</div>
                            <div class="info-row"><strong>تاريخ الانضمام:</strong> 12/10/2025</div>
                            <div class="info-row"><strong>رقم العضوية:</strong> 0001-2025</div>
                        </div>
                    </div>

                    <!-- الجهة اليسرى (إنجليزي) -->
                    <div class="side left">
                        <div class="title">Membership Certificate</div>
                        <div class="content">
                            <strong>Nasq</strong> proudly grants this certificate to the esteemed member in recognition
                            of outstanding membership, valuable contribution to our community, and continued pursuit of
                            excellence.
                        </div>
                        <div class="member-info">
                            <div class="info-row"><strong>Name:</strong> Mohammed Ahmed Ali</div>
                            <div class="info-row"><strong>Membership Type:</strong> Gold</div>
                            <div class="info-row"><strong>Joining Date:</strong> 12/10/2025</div>
                            <div class="info-row"><strong>Membership ID:</strong> 0001-2025</div>
                        </div>
                    </div>
                </div>

                <div class="footer">
                    <div class="signature">
                        <img src="{{ asset('nasaq.png') }}" alt="Official Stamp">
                    </div>
                    <img src="{{ $user->profileQrCodePng() }}" alt="QR Code" class="qr-code">
                </div>

                <div class="unique-id">رقم العضوية الفريد: NASQ-0001-2025</div>
            </div>
        </div>
    </div>

    <!-- أزرار التحميل -->
    <div class="flex flex-col md:flex-row items-center gap-4">
        <button @click="downloadTransparent"
            class="btn flex justify-center items-center gap-2 rtl:flex-row-reverse bg-primary/40 hover:bg-primary/30 disabled:opacity-50 py-2 px-4 rounded mt-5"
            :disabled="isLoadingPng">
            <div x-show="isLoadingPng" x-transition.opacity.duration.500ms
                class="border-primary border-b-transparent border-4 animate-spin size-6 rounded-full"></div>
            <span> تنزيل الشهادة كصورة</span>
        </button>

        <button @click="downloadPDF"
            class="btn flex justify-center items-center gap-2 rtl:flex-row-reverse bg-primary/40 hover:bg-primary/30 disabled:opacity-50 py-2 px-4 rounded mt-5"
            :disabled="isLoadingPdf">
            <div x-show="isLoadingPdf" x-transition.opacity.duration.500ms
                class="border-primary border-b-transparent border-4 animate-spin size-6 rounded-full"></div>
            <span> تنزيل الشهادة PDF</span>
        </button>
    </div>
</div>
