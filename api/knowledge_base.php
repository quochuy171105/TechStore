<?php

// =========================================================================
// KHO TRI THỨC NÂNG CAO (ADVANCED KNOWLEDGE BASE)
// =========================================================================
//
// Hướng dẫn sử dụng:
// Mỗi mục trong kho tri thức là một mảng bao gồm 3 phần:
// 1. 'keywords': Một danh sách các từ khóa chính để xác định câu hỏi.
//    - Hệ thống sẽ tìm những từ này trong câu hỏi của người dùng.
//    - Viết bằng chữ thường, không dấu để dễ so khớp.
//
// 2. 'match_type': Quy tắc so khớp từ khóa.
//    - 'all': Câu hỏi của người dùng PHẢI chứa TẤT CẢ các từ khóa.
//      (Ví dụ: câu "thủ đô việt nam là gì" chứa cả 'thu do' và 'viet nam').
//    - 'any': Câu hỏi của người dùng CHỈ CẦN chứa MỘT trong các từ khóa.
//      (Ví dụ: câu "chào shop" chứa 'chao').
//
// 3. 'answer': Câu trả lời sẽ được gửi đi nếu quy tắc được thỏa mãn.
//    - Bạn có thể sử dụng định dạng Markdown (ví dụ: **in đậm**).
//
// =========================================================================

return [
    // --- Lời chào và giới thiệu ---
    [
        'keywords' => ['chao', 'hello', 'hi'],
        'match_type' => 'any',
        'answer' => 'Chào bạn, tôi là chatbot của TechStore. Tôi có thể giúp gì cho bạn?',
    ],
    [
        'keywords' => ['ban la ai', 'ten gi'],
        'match_type' => 'any',
        'answer' => 'Tôi là trợ lý ảo của TechStore, được tạo ra để giúp bạn mua sắm và giải đáp các thắc mắc.',
    ],
    [
        'keywords' => ['giup', 'can ho tro'],
        'match_type' => 'any',
        'answer' => 'Tôi có thể giúp bạn tìm kiếm sản phẩm, kiểm tra đơn hàng, tư vấn về chính sách và trả lời các câu hỏi chung. Bạn cần hỗ trợ về vấn đề gì?',
    ],

    // --- Thông tin chung & Cửa hàng ---
    [
        'keywords' => ['thu do', 'viet nam'],
        'match_type' => 'all',
        'answer' => 'Thủ đô của Việt Nam là Hà Nội.',
    ],
    [
        'keywords' => ['dia chi', 'cua hang o dau'],
        'match_type' => 'any',
        'answer' => 'Hiện tại, TechStore là cửa hàng trực tuyến và chưa có chi nhánh vật lý. Bạn có thể đặt hàng tiện lợi ngay trên website của chúng tôi.',
    ],
    [
        'keywords' => ['mua hang', 'dat hang'],
        'match_type' => 'any',
        'answer' => 'Để mua hàng, bạn chỉ cần tìm sản phẩm yêu thích trên website, thêm vào giỏ hàng và tiến hành đặt hàng. Chúng tôi sẽ giao hàng tận nơi cho bạn.',
    ],
    [
        'keywords' => ['thanh toan'],
        'match_type' => 'any',
        'answer' => 'Chúng tôi hỗ trợ 2 hình thức thanh toán chính: thanh toán khi nhận hàng (COD) và thanh toán trực tuyến qua cổng VNPAY (hỗ trợ thẻ ATM, Visa, Master Card, JCB, và QR Pay).'
    ],

    // --- Cảm ơn & Tạm biệt ---
    [
        'keywords' => ['cam on', 'thank you', 'thanks'],
        'match_type' => 'any',
        'answer' => 'Rất vui được hỗ trợ bạn! Nếu cần thêm thông tin, đừng ngần ngại hỏi nhé.',
    ],
    [
        'keywords' => ['tam biet', 'bye'],
        'match_type' => 'any',
        'answer' => 'Tạm biệt bạn! Chúc bạn một ngày tốt lành.',
    ],

    // --- Chính sách & Hỗ trợ ---
    [
        'keywords' => ['bao hanh', 'chinh sach bao hanh'],
        'match_type' => 'any',
        'answer' => 'TechStore có chính sách bảo hành rõ ràng cho từng sản phẩm. Bạn có thể xem chi tiết tại trang **Chính sách bảo hành** của chúng tôi.',
    ],
    [
        'keywords' => ['doi tra', 'hoan tien', 'chinh sach doi tra'],
        'match_type' => 'any',
        'answer' => 'Chúng tôi hỗ trợ đổi trả sản phẩm trong vòng 7 ngày nếu có lỗi từ nhà sản xuất. Vui lòng tham khảo **Chính sách đổi trả** để biết thêm chi tiết.',
    ],
    [
        'keywords' => ['giao hang', 'van chuyen', 'ship'],
        'match_type' => 'any',
        'answer' => 'TechStore giao hàng toàn quốc. Thời gian giao hàng dự kiến từ 2-5 ngày làm việc tùy thuộc vào địa chỉ của bạn. Chi tiết có tại trang **Chính sách giao hàng**.',
    ],
    [
        'keywords' => ['bao mat', 'thong tin ca nhan'],
        'match_type' => 'any',
        'answer' => 'Chúng tôi cam kết bảo mật thông tin cá nhân của khách hàng. Mọi thông tin của bạn đều được mã hóa và bảo vệ. Xem thêm tại **Chính sách bảo mật**.',
    ],
    [
        'keywords' => ['lien he', 'hotline', 'email'],
        'match_type' => 'any',
        'answer' => 'Bạn có thể liên hệ với chúng tôi qua hotline **1900 1234** hoặc email **support@techstore.vn**. Chúng tôi luôn sẵn lòng hỗ trợ!',
    ],

    // --- Sản phẩm & Tìm kiếm ---
    [
        'keywords' => ['tim kiem', 'san pham'],
        'match_type' => 'all',
        'answer' => 'Để tìm kiếm sản phẩm, bạn chỉ cần gõ tên hoặc từ khóa liên quan vào thanh tìm kiếm ở đầu trang web.',
    ],
    [
        'keywords' => ['dien thoai', 'iphone', 'samsung'],
        'match_type' => 'any',
        'answer' => 'Chúng tôi có rất nhiều mẫu điện thoại từ các thương hiệu hàng đầu như Apple (iPhone), Samsung, Xiaomi. Bạn có thể truy cập danh mục **Điện thoại** để xem tất cả sản phẩm.',
    ],
    [
        'keywords' => ['may tinh bang', 'ipad'],
        'match_type' => 'any',
        'answer' => 'Các dòng máy tính bảng mới nhất như iPad Air, iPad Pro đều có sẵn tại TechStore. Hãy ghé thăm mục **Máy tính bảng** nhé!',
    ],
    [
        'keywords' => ['khuyen mai', 'giam gia', 'deal'],
        'match_type' => 'any',
        'answer' => 'TechStore thường xuyên có các chương trình khuyến mãi hấp dẫn. Bạn hãy theo dõi trang chủ hoặc mục **Khuyến mãi** để không bỏ lỡ ưu đãi nào nhé!',
    ],

    // Thêm các quy tắc của riêng bạn vào đây
    // [
    //     'keywords' => ['tu khoa 1', 'tu khoa 2'],
    //     'match_type' => 'all',
    //     'answer' => 'Câu trả lời tương ứng.',
    // ],
];