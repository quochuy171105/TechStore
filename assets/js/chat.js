// ============================================
// SMART AI CHATBOT - UPGRADED VERSION
// Tích hợp AI, Database & Context-Aware
// ============================================

$(document).ready(function () {
    const chatWindow = $('#chat-window');
    const chatBubble = $('#chat-bubble');
    const chatBody = $('.chat-body');
    const chatInput = $('#chat-input');

    // ============================================
    // CONFIGURATION & STATE MANAGEMENT
    // ============================================

    const CONFIG = {
        apiEndpoint: 'api/chatbot.php', // Backend API endpoint
        typingDelay: { min: 800, max: 1500 },
        maxHistoryLength: 50,
        contextWindow: 5, // Số tin nhắn gần nhất để phân tích context
        confidenceThreshold: 0.6
    };

    let chatHistory = [];
    let conversationContext = {
        userIntent: null,       // Ý định gần nhất của người dùng (ví dụ: 'product_inquiry')
        lastProducts: [],       // Danh sách sản phẩm cuối cùng được hiển thị
        focusedProduct: null,   // Sản phẩm đang được thảo luận chính
        priceRange: null,       // Khoảng giá người dùng quan tâm
        userPreferences: {},    // Các sở thích khác (ví dụ: camera, gaming)
        lastProductType: null   // Loại sản phẩm cuối cùng được đề cập (ví dụ: 'điện thoại')
    };

    // ============================================
    // ENHANCED KNOWLEDGE BASE với NLP
    // ============================================

    const knowledgeBase = {
        greetings: {
            keywords: ['chào', 'hello', 'hi', 'xin chào', 'ad ơi', 'alo', 'hế nhô'],
            patterns: [/^(xin )?chào/, /^hi+$/, /^hello+$/i],
            priority: 10,
            intent: 'greeting',
            responses: [
                {
                    text: 'Chào bạn! 👋 Tôi là trợ lý ảo thông minh của Tech Store. Tôi có thể giúp bạn:',
                    type: 'action',
                    actions: [
                        { label: '🔍 Tìm sản phẩm phù hợp', command: 'tư vấn sản phẩm' },
                        { label: '🎁 Xem khuyến mãi HOT', command: 'khuyến mãi hôm nay' },
                        { label: '📦 Tra cứu đơn hàng', command: 'kiểm tra đơn hàng' }
                    ]
                }
            ]
        },

        product_search: {
            keywords: ['tìm', 'tư vấn', 'mua', 'chọn', 'nên', 'giá', 'bao nhiêu', 'khoảng', 'điện thoại', 'laptop', 'máy tính bảng', 'phụ kiện', 'đồng hồ thông minh', 'loa bluetooth', 'máy ảnh', 'máy chơi game', 'pc', 'màn hình'],
            patterns: [/tìm.*(điện thoại|laptop|máy tính bảng|phụ kiện|đồng hồ thông minh|loa bluetooth|máy ảnh|máy chơi game|pc|màn hình)/, /tư vấn.*(mua|chọn)/, /giá.*(khoảng|từ|dưới|trên)/],
            priority: 9,
            intent: 'product_inquiry',
            requiresDB: true,
            responses: [
                {
                    text: 'Để tư vấn chính xác, cho tôi biết thêm về nhu cầu của bạn nhé:',
                    type: 'action',
                    actions: [
                        { label: '💰 Ngân sách của bạn', command: 'budget' },
                        { label: '🎯 Mục đích sử dụng', command: 'usage' },
                        { label: '⭐ Tính năng ưu tiên', command: 'features' }
                    ]
                }
            ]
        },

        budget_inquiry: {
            keywords: ['giá', 'tiền', 'ngân sách', 'khoảng', 'triệu', 'rẻ', 'mắc'],
            patterns: [/(\d+)\s*(triệu|tr|k|nghìn)/, /dưới.*(\d+)/, /từ.*(\d+).*đến.*(\d+)/],
            priority: 8,
            intent: 'budget_filter',
            requiresDB: true,
            extractInfo: true
        },

        // START OF NEW INTENTS
        product_availability: {
            keywords: ['còn hàng', 'hết hàng', 'sẵn có', 'stock'],
            patterns: [/còn hàng không/, /sẵn hàng không/],
            priority: 8,
            intent: 'product_availability',
            responses: [
                { text: 'Để kiểm tra tình trạng hàng, bạn vui lòng cho tôi biết sản phẩm cụ thể bạn quan tâm nhé.', type: 'text' },
                { text: 'Hầu hết sản phẩm trên website đều còn hàng. Bạn có thể đặt hàng trực tiếp!', type: 'text' }
            ]
        },

        product_specs: {
            keywords: ['màu', 'hiệu năng', 'chip', 'pin', '5g', 'esim', 'chống nước', 'bản', 'gb'],
            patterns: [/có.*màu gì/, /chip.*mạnh không/, /pin.*bao lâu/, /hỗ trợ 5g|esim/, /chống nước/],
            priority: 8,
            intent: 'product_specs',
            responses: [
                { text: 'Thông tin chi tiết về cấu hình (màu sắc, hiệu năng, pin,...) đều có đầy đủ trên trang chi tiết sản phẩm. Bạn có thể xem sản phẩm và đặt câu hỏi cụ thể hơn nhé.', type: 'text' }
            ]
        },

        product_condition: {
            keywords: ['hàng mới', 'trưng bày', 'new', 'used', 'like new'],
            patterns: [/hàng mới hay hàng trưng bày/, /máy mới 100%/],
            priority: 7,
            intent: 'product_condition',
            responses: [
                { text: 'Chúng tôi cam kết 100% sản phẩm bán ra là hàng mới, nguyên seal, chính hãng. Chúng tôi không kinh doanh hàng trưng bày hay đã qua sử dụng.', type: 'text' }
            ]
        },

        product_media: {
            keywords: ['ảnh thật', 'video', 'thực tế', 'hình ảnh'],
            patterns: [/có ảnh|video thực tế/, /hình ảnh thật/],
            priority: 7,
            intent: 'product_media',
            responses: [
                { text: 'Tất cả hình ảnh trên website đều là ảnh chụp thực tế của sản phẩm tại studio của chúng tôi. Bạn cần xem góc cạnh nào cụ thể hơn không?', type: 'text' }
            ]
        },

        payment_methods: {
            keywords: ['vat', 'trả góp', 'giấy tờ', 'cod', 'thanh toán', 'quẹt thẻ'],
            patterns: [/gồm vat chưa/, /trả góp 0%/, /thanh toán.*thế nào/, /có cod không/],
            priority: 8,
            intent: 'payment_methods',
            responses: [
                { text: 'Giá trên web là giá cuối cùng đã bao gồm VAT. Chúng tôi hỗ trợ trả góp 0% qua thẻ tín dụng và có chấp nhận thanh toán khi nhận hàng (COD) toàn quốc.', type: 'text' }
            ]
        },

        trade_in: {
            keywords: ['thu cũ', 'đổi mới', 'trade-in'],
            patterns: [/thu cũ đổi mới/],
            priority: 8,
            intent: 'trade_in',
            responses: [
                { text: 'Chương trình "Thu Cũ Đổi Mới" của chúng tôi áp dụng cho nhiều dòng sản phẩm. Bạn vui lòng mang máy cũ đến cửa hàng gần nhất để được định giá và tư vấn chi tiết nhé.', type: 'text' }
            ]
        },

        bulk_purchase: {
            keywords: ['mua nhiều', 'số lượng', 'giá sỉ'],
            patterns: [/mua số lượng nhiều/, /giá sỉ/],
            priority: 7,
            intent: 'bulk_purchase',
            responses: [
                { text: 'Khi mua hàng với số lượng lớn, bạn sẽ nhận được mức chiết khấu đặc biệt. Vui lòng liên hệ hotline kinh doanh của chúng tôi để được báo giá tốt nhất.', type: 'text' }
            ]
        },

        delivery_policy: {
            keywords: ['kiểm tra hàng', 'đồng kiểm'],
            patterns: [/kiểm tra hàng trước/, /đồng kiểm/],
            priority: 7,
            intent: 'delivery_policy',
            responses: [
                { text: 'Bạn hoàn toàn được quyền kiểm tra sản phẩm (đồng kiểm) trước khi thanh toán cho nhân viên giao hàng để đảm bảo sản phẩm đúng như bạn đặt.', type: 'text' }
            ]
        },

        technical_support: {
            keywords: ['tương thích', 'cài đặt', 'nóng máy', 'game'],
            patterns: [/tương thích với/, /hỗ trợ cài đặt/, /chơi game có nóng không/],
            priority: 7,
            intent: 'technical_support',
            responses: [
                { text: 'Đội ngũ kỹ thuật của chúng tôi luôn sẵn sàng hỗ trợ. Bạn có thể cho tôi biết cụ thể vấn đề bạn đang gặp phải với sản phẩm nào không?', type: 'text' }
            ]
        },

        ordering_guide: {
            keywords: ['đặt hàng', 'mua hàng', 'làm sao', 'cách mua'],
            patterns: [/làm sao để đặt hàng/, /cách mua hàng/],
            priority: 8,
            intent: 'ordering_guide',
            responses: [
                { text: 'Để đặt hàng, bạn chỉ cần thêm sản phẩm vào giỏ hàng và tiến hành thanh toán. Hoặc bạn có thể để lại SĐT, nhân viên của chúng tôi sẽ gọi lại tư vấn và đặt hàng giúp bạn.', type: 'text' }
            ]
        },

        order_cancellation: {
            keywords: ['hủy đơn', 'đặt nhầm', 'cancel'],
            patterns: [/hủy đơn được không/, /đặt nhầm/],
            priority: 8,
            intent: 'order_cancellation',
            responses: [
                { text: 'Để hủy đơn hàng, bạn vui lòng cung cấp mã đơn hàng hoặc số điện thoại đặt hàng. Tôi sẽ kiểm tra và hỗ trợ bạn ngay lập tức.', type: 'text' }
            ]
        },

        account_support: {
            keywords: ['tài khoản', 'đăng nhập', 'mật khẩu', 'login'],
            patterns: [/không đăng nhập được/, /quên mật khẩu/],
            priority: 7,
            intent: 'account_support',
            responses: [
                { text: 'Nếu bạn gặp sự cố khi đăng nhập, bạn có thể thử sử dụng chức năng "Quên mật khẩu". Nếu vẫn không được, hãy cho tôi biết tên tài khoản hoặc email của bạn.', type: 'text' }
            ]
        },
        // END OF NEW INTENTS

        promotions: {
            keywords: ['khuyến mãi', 'giảm giá', 'ưu đãi', 'sale', 'coupon', 'voucher', 'flash sale'],
            patterns: [/khuyến mãi|giảm giá|ưu đãi/],
            priority: 9,
            intent: 'promotion_inquiry',
            requiresDB: true,
            responses: [
                {
                    text: '🔥 Đang có các chương trình khuyến mãi HOT:',
                    type: 'action',
                    dynamicContent: 'promotions',
                    actions: [
                        { label: 'Xem tất cả khuyến mãi', id: 'view-promotions' }
                    ]
                }
            ]
        },

        product_compare: {
            keywords: ['so sánh', 'khác nhau', 'giống', 'tốt hơn', 'vs', 'hay'],
            patterns: [/so sánh.*và/, /(\w+)\s+hay\s+(\w+)/, /khác.*gì/],
            priority: 8,
            intent: 'comparison',
            requiresDB: true,
            extractInfo: true
        },

        order_tracking: {
            keywords: ['đơn hàng', 'kiểm tra', 'tra cứu', 'order', 'mã', 'giao hàng', 'ship'],
            patterns: [/(?:mã|đơn).*(?:hàng|order)/, /(?:DH|ORD)\d+/],
            priority: 7,
            intent: 'order_status',
            requiresDB: true,
            extractInfo: true
        },

        warranty: {
            keywords: ['bảo hành', 'đổi trả', 'chính sách', 'lỗi', 'hỏng'],
            patterns: [/bảo hành/, /đổi.*trả/, /(?:bị|bị lỗi|hỏng)/],
            priority: 7,
            intent: 'warranty_inquiry',
            responses: [
                {
                    text: '🛡️ Chính sách bảo hành của chúng tôi:\n• Bảo hành chính hãng 12-24 tháng\n• Đổi mới trong 30 ngày đầu\n• 1 đổi 1 nếu lỗi NSX',
                    type: 'text'
                },
                {
                    text: 'Bạn cần kiểm tra bảo hành cho sản phẩm cụ thể?',
                    type: 'action',
                    actions: [
                        { label: 'Kiểm tra bảo hành', command: 'tra bảo hành' },
                        { label: 'Điều kiện đổi trả', command: 'chính sách đổi trả' }
                    ]
                }
            ]
        },

        shipping: {
            keywords: ['vận chuyển', 'giao hàng', 'ship', 'bao lâu', 'khi nào', 'phí ship'],
            patterns: [/giao.*(?:hàng|trong|bao lâu)/, /ship/, /phí.*vận chuyển/],
            priority: 6,
            intent: 'shipping_inquiry',
            responses: [
                {
                    text: '🚚 Thông tin vận chuyển:\n• Nội thành: 2-4 giờ\n• Ngoại thành: 1-2 ngày\n• Tỉnh xa: 3-5 ngày\n• Miễn phí ship đơn >500k',
                    type: 'text'
                }
            ]
        },

        stores: {
            keywords: ['địa chỉ', 'cửa hàng', 'chi nhánh', 'ở đâu', 'showroom', 'địa điểm'],
            patterns: [/(?:cửa hàng|showroom|địa chỉ).*(?:ở đâu|nào)/, /có.*(?:chi nhánh|cửa hàng)/],
            priority: 6,
            intent: 'store_location',
            requiresDB: true
        },

        thank_you: {
            keywords: ['cảm ơn', 'thank you', 'thanks', 'ok', 'được', 'tuyệt'],
            patterns: [/cảm ơn/, /thanks?/i, /ok+$/],
            priority: 5,
            intent: 'gratitude',
            responses: [
                {
                    text: '🤗 Rất vui được hỗ trợ bạn! Bạn còn cần tư vấn thêm không?',
                    type: 'action',
                    actions: [
                        { label: 'Xem sản phẩm mới', id: 'view-new-products' },
                        { label: 'Kết thúc hội thoại', command: 'goodbye' }
                    ]
                }
            ]
        }
    };

    // ============================================
    // AI ENGINE - NLP & CONTEXT PROCESSING
    // ============================================

    class ChatbotAI {
        constructor() {
            this.intentClassifier = new IntentClassifier();
            this.entityExtractor = new EntityExtractor();
            this.contextManager = new ContextManager();
        }

        async processMessage(userInput) {
            // 1. Phân tích intent
            const intent = this.intentClassifier.classify(userInput, conversationContext);

            // 2. Trích xuất entities (giá, sản phẩm, mã đơn hàng...)
            const entities = this.entityExtractor.extract(userInput);

            // 3. Suy luận từ Context
            // Nếu intent không rõ ràng nhưng có sản phẩm trong context, ưu tiên hỏi về sản phẩm đó
            if (intent.intent === 'product_specs' || intent.intent === 'product_availability') {
                if (!entities.product_name && conversationContext.focusedProduct) {
                    entities.product_id = conversationContext.focusedProduct.id;
                    intent.requiresDB = true; // Cần gọi DB để lấy thông tin cho sản phẩm context
                }
            }

            // Bổ sung product_type từ context nếu không có trong entities
            if (!entities.product_type && conversationContext.lastProductType) {
                entities.product_type = conversationContext.lastProductType;
            }

            // 4. Quyết định action
            if (intent.requiresDB) {
                return await this.fetchDatabaseResponse(intent, entities);
            }

            return this.getStaticResponse(intent);
        }

        async fetchDatabaseResponse(intent, entities) {
            try {
                // Thêm product_id từ context vào entities nếu có
                if (conversationContext.focusedProduct && !entities.product_id) {
                    entities.product_id = conversationContext.focusedProduct.id;
                }

                const response = await $.ajax({
                    url: CONFIG.apiEndpoint,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: intent.intent, // Use the correct intent for the backend
                        entities: JSON.stringify(entities),
                        context: JSON.stringify(conversationContext),
                        history: JSON.stringify(chatHistory.slice(-CONFIG.contextWindow))
                    }
                });

                // Gán danh sách sản phẩm vào response để context manager có thể xử lý
                const formattedResponse = this.formatDatabaseResponse(response, intent);
                if (response.success && response.data.products) {
                    formattedResponse.products = response.data.products;
                }
                return formattedResponse;

            } catch (error) {
                console.error('Database fetch error:', error);
                return this.getErrorResponse();
            }
        }

        formatDatabaseResponse(data, intent) {
            if (!data.success) {
                return { text: data.message || 'Đã có lỗi xảy ra', type: 'text' };
            }

            // Các intent trả về message đơn giản
            if (data.data && data.data.message) {
                return { text: data.data.message, type: 'text' };
            }

            switch (intent.intent) {
                case 'product_inquiry':
                case 'budget_filter':
                    return this.formatProductResults(data.data.products);
                case 'promotion_inquiry':
                    return this.formatPromotions(data.data.promotions);
                case 'order_status':
                    return this.formatOrderStatus(data.data.order);
                case 'comparison':
                    return this.formatComparison(data.data.products);
                // Không cần các case mới ở đây vì chúng chỉ trả về message đã được xử lý ở trên
                default:
                    return { text: 'Phản hồi không xác định từ server.', type: 'text' };
            }
        }

        formatProductResults(products) {
            if (!products || products.length === 0) {
                return { text: 'Rất tiếc, tôi không tìm thấy sản phẩm nào phù hợp.', type: 'text' };
            }

            const productCards = products.map(p => `
                <div class="product-card-chat">
                    <img src="assets/image/products/${p.HinhAnh}" alt="${p.TenSP}" class="product-image-chat">
                    <div class="product-info-chat">
                        <p class="product-name-chat">${p.TenSP}</p>
                        <p class="product-price-chat">${this.formatPrice(p.Gia)}</p>
                        <a href="views/user/product_detail.php?id=${p.MaSP}" target="_blank" class="btn btn-sm btn-gradient">Xem chi tiết</a>
                    </div>
                </div>
            `).join('');

            const text = `
                <p>Tôi đã tìm thấy các sản phẩm sau:</p>
                <div class="product-list-chat">
                    ${productCards}
                </div>
            `;
            return { text: text, type: 'html' };
        }

        formatPromotions(promotions) {
            const promoList = promotions.slice(0, 3).map((p, i) =>
                `🔥 **${p.title}**\n   ${p.description}\n   🎁 Giảm ${p.discount_percent}% | Bắt đầu: ${p.start_date} | Kết thúc: ${p.end_date}`
            ).join('\n\n');

            return {
                text: `💝 Khuyến mãi HOT hiện tại:\n\n${promoList}`,
                type: 'action',
                actions: promotions.slice(0, 3).map(p => ({
                    label: p.cta || 'Xem chi tiết',
                    url: `${BASE_URL}views/user/promotions.php#promo-${p.id}`
                }))
            };
        }

        formatOrderStatus(order) {
            if (!order) {
                return { text: 'Không tìm thấy thông tin đơn hàng. Vui lòng kiểm tra lại mã đơn hàng hoặc số điện thoại.', type: 'text' };
            }

            let details = ``;
            if (order.products && order.products.length > 0) {
                details = `
                    <div class="order-products">
                        <p class="mb-1"><strong>Sản phẩm:</strong></p>
                        <ul>
                            ${order.products.map(p => `<li>${p.TenSP} (x${p.SoLuong}) - ${this.formatPrice(p.ThanhTien)}</li>`).join('')}
                        </ul>
                    </div>
                `;
            }

            const text = `
                <div class="order-status-card">
                    <p><strong>Trạng thái đơn hàng #${order.MaDH}</strong></p>
                    <p><strong>Trạng thái:</strong> <span class="badge bg-success">${order.TrangThai}</span></p>
                    <p><strong>Ngày đặt:</strong> ${new Date(order.NgayTao).toLocaleDateString('vi-VN')}</p>
                    <p><strong>Tổng tiền:</strong> ${this.formatPrice(order.TongTien)}</p>
                    ${details}
                </div>
            `;
            return { text: text, type: 'html' }; // Kiểu html để render đúng
        }

        formatComparison(products) {
            if (!products || products.length < 2) {
                return { text: 'Không đủ thông tin để so sánh sản phẩm.', type: 'text' };
            }

            const p1 = products[0];
            const p2 = products[1];

            const text = `
                <div class="comparison-card">
                    <p class="text-center"><strong>So sánh ${p1.TenSP} và ${p2.TenSP}</strong></p>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td><strong>Giá</strong></td>
                                <td>${this.formatPrice(p1.Gia)}</td>
                                <td>${this.formatPrice(p2.Gia)}</td>
                            </tr>
                            <tr>
                                <td><strong>Thương hiệu</strong></td>
                                <td>${p1.ThuongHieu}</td>
                                <td>${p2.ThuongHieu}</td>
                            </tr>
                            <tr>
                                <td><strong>Mô tả</strong></td>
                                <td>${p1.MoTa.substring(0, 100)}...</td>
                                <td>${p2.MoTa.substring(0, 100)}...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `;
            return { text: text, type: 'html' };
        }

        formatPrice(price) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(price);
        }

        buildQueryString() {
            const params = new URLSearchParams();
            if (conversationContext.priceRange) {
                params.append('price_min', conversationContext.priceRange.min);
                params.append('price_max', conversationContext.priceRange.max);
            }
            return params.toString() ? '?' + params.toString() : '';
        }

        getStaticResponse(intent) {
            if (intent.responses && intent.responses.length > 0) {
                return intent.responses[Math.floor(Math.random() * intent.responses.length)];
            }

            return this.getDefaultResponse();
        }

        getDefaultResponse() {
            return {
                text: '🤔 Tôi chưa hiểu rõ câu hỏi của bạn. Bạn có thể:',
                type: 'action',
                actions: [
                    { label: '❓ Xem câu hỏi thường gặp', url: 'faq.php' },
                    { label: '👤 Chat với nhân viên', command: 'kết nối nhân viên' },
                    { label: '📞 Gọi hotline', command: 'hotline' }
                ]
            };
        }

        getErrorResponse() {
            return {
                text: '⚠️ Đã có lỗi khi xử lý yêu cầu. Vui lòng thử lại hoặc liên hệ hotline.',
                type: 'action',
                actions: [
                    { label: 'Thử lại', command: 'retry' },
                    { label: 'Liên hệ hỗ trợ', command: 'support' }
                ]
            };
        }
    }

    // ============================================
    // INTENT CLASSIFIER
    // ============================================

    class IntentClassifier {
        classify(input, context) {
            const lowerInput = input.toLowerCase();
            let bestMatch = null;
            let maxScore = 0;

            for (const category in knowledgeBase) {
                const entry = knowledgeBase[category];
                let score = this.calculateScore(lowerInput, entry, context);

                if (score > maxScore) {
                    maxScore = score;
                    bestMatch = { ...entry, type: category, score };
                }
            }

            if (maxScore > CONFIG.confidenceThreshold) {
                return bestMatch;
            }

            return { type: 'unknown', score: 0, responses: [] };
        }

        calculateScore(input, entry, context) {
            let score = 0;

            // Keyword matching
            for (const keyword of entry.keywords) {
                if (input.includes(keyword)) {
                    score += entry.priority * 0.3;
                }
            }

            // Pattern matching (regex)
            if (entry.patterns) {
                for (const pattern of entry.patterns) {
                    if (pattern.test(input)) {
                        score += entry.priority * 0.7;
                    }
                }
            }

            // Context boost (nếu đang nói về chủ đề này)
            if (context.lastCategory === entry.intent) {
                score *= 1.2;
            }

            return score;
        }
    }

    // ============================================
    // ENTITY EXTRACTOR
    // ============================================

    class EntityExtractor {
        extract(input) {
            const entities = {};

            // Trích xuất giá tiền (thông minh hơn)
            const priceRegex = /(?:dưới|trên|khoảng|từ|thấp hơn|cao hơn)?\s*(\d+(?:[.,]\d+)?)\s*(k|ngàn|nghìn|triệu|tr)?(?:\s*(?:đến|tới)\s*(\d+(?:[.,]\d+)?)\s*(k|ngàn|nghìn|triệu|tr)?)?/gi;
            let priceMatch;
            let priceRange = {};

            while ((priceMatch = priceRegex.exec(input.toLowerCase())) !== null) {
                const keyword = (priceMatch[0].match(/dưới|trên|khoảng|từ|thấp hơn|cao hơn/) || [])[0];
                const num1 = parseFloat(priceMatch[1].replace(',', '.'));
                const unit1 = priceMatch[2] || '';
                const num2 = priceMatch[3] ? parseFloat(priceMatch[3].replace(',', '.')) : null;
                const unit2 = priceMatch[4] || '';

                const parseValue = (num, unit) => {
                    if (unit.startsWith('tr')) return num * 1000000;
                    if (unit.startsWith('k') || unit.startsWith('ng')) return num * 1000;
                    return num;
                };

                const value1 = parseValue(num1, unit1);
                const value2 = num2 ? parseValue(num2, unit2) : null;

                if (keyword === 'dưới' || keyword === 'thấp hơn') {
                    priceRange.min = 0;
                    priceRange.max = value1;
                } else if (keyword === 'trên' || keyword === 'cao hơn') {
                    priceRange.min = value1;
                    priceRange.max = 1000000000; // Giả định một giới hạn trên lớn
                } else if (keyword === 'khoảng') {
                    priceRange.min = value1 * 0.8;
                    priceRange.max = value1 * 1.2;
                } else if (keyword === 'từ' && value2) {
                    priceRange.min = value1;
                    priceRange.max = value2;
                } else if (value2) { // Mặc định là khoảng từ...đến
                    priceRange.min = value1;
                    priceRange.max = value2;
                } else { // Chỉ có một con số
                    priceRange.min = value1;
                    priceRange.max = value1;
                }
                break; // Chỉ xử lý lần khớp đầu tiên để tránh phức tạp
            }

            if (Object.keys(priceRange).length > 0) {
                entities.priceRange = priceRange;
            }

            // Trích xuất mã đơn hàng
            const orderPattern = /(?:DH|ORD|ORDER)?(\d{6,})/i;
            const orderMatch = input.match(orderPattern);
            if (orderMatch) {
                entities.orderCode = orderMatch[1];
            }

            // Trích xuất tên sản phẩm (brands, models)
            const brands = ['iphone', 'samsung', 'xiaomi', 'oppo', 'vivo', 'realme', 'dell', 'asus', 'hp', 'lenovo', 'macbook'];
            entities.brands = brands.filter(brand => input.toLowerCase().includes(brand));

            // Trích xuất loại sản phẩm
            const productTypes = ['điện thoại', 'laptop', 'máy tính bảng', 'phụ kiện', 'đồng hồ', 'loa', 'máy ảnh', 'pc', 'màn hình'];
            entities.product_type = productTypes.filter(type => input.toLowerCase().includes(type));

            // Trích xuất tính năng ưu tiên
            const features = {
                camera: /camera|ảnh|chụp|hình/i,
                gaming: /game|gaming|chơi game/i,
                battery: /pin|battery|sạc/i,
                performance: /mạnh|nhanh|hiệu năng|cấu hình/i,
                design: /đẹp|thiết kế|màu|ngoại hình/i
            };

            entities.features = [];
            for (const [feature, pattern] of Object.entries(features)) {
                if (pattern.test(input)) {
                    entities.features.push(feature);
                }
            }

            return entities;
        }
    }

    // ============================================
    // CONTEXT MANAGER
    // ============================================

    class ContextManager {
        update(intent, entities, aiResponse) {
            // Cập nhật intent hiện tại
            conversationContext.userIntent = intent.intent;

            // Cập nhật entities
            if (entities.priceRange) {
                conversationContext.priceRange = entities.priceRange;
            }

            // Cập nhật danh sách sản phẩm cuối cùng được hiển thị
            if (aiResponse && aiResponse.products) {
                conversationContext.lastProducts = aiResponse.products;
                // Mặc định focus vào sản phẩm đầu tiên trong danh sách
                if (aiResponse.products.length > 0) {
                    conversationContext.focusedProduct = aiResponse.products[0];
                }
            }

            if (entities.product_type && entities.product_type.length > 0) {
                conversationContext.lastProductType = entities.product_type[0];
            }
        }

        reset() {
            conversationContext = {
                lastCategory: null,
                userIntent: null,
                mentionedProducts: [],
                priceRange: null,
                userPreferences: {}
            };
        }
    }

    // ============================================
    // CHAT UI HANDLERS
    // ============================================

    const chatbotAI = new ChatbotAI();

    // Toggle chat window
    chatBubble.on('click', function () {
        chatWindow.toggleClass('open');
        $('body').toggleClass('chat-open');

        if (chatWindow.hasClass('open') && chatHistory.length === 0) {
            const welcomeMsg = knowledgeBase.greetings.responses[0];
            appendMessage(welcomeMsg, 'received', 'welcome');
            chatHistory.push({ type: 'received', data: welcomeMsg });
        } else {
            scrollToBottom();
        }
    });

    $('#close-chat').on('click', function () {
        chatWindow.removeClass('open');
        $('body').removeClass('chat-open');
    });

    $('#send-chat').on('click', sendMessage);

    chatInput.on('keypress', function (e) {
        if (e.which == 13) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Action button handler
    $(document).on('click', '.chat-action-button', function () {
        const command = $(this).data('command');
        const url = $(this).data('url');

        if (url) {
            window.open(url, '_blank');
            appendMessage('✅ Đã mở liên kết trong tab mới.', 'received');
        } else if (command) {
            appendMessage(command, 'sent');
            chatHistory.push({ type: 'sent', text: command });
            processAIResponse(command);
        }
    });

    // ============================================
    // CORE FUNCTIONS
    // ============================================

    async function sendMessage() {
        const messageText = chatInput.val().trim();
        if (!messageText) return;

        appendMessage(messageText, 'sent');
        chatInput.val('');

        chatHistory.push({ type: 'sent', text: messageText });

        // Giới hạn history
        if (chatHistory.length > CONFIG.maxHistoryLength) {
            chatHistory = chatHistory.slice(-CONFIG.maxHistoryLength);
        }

        await processAIResponse(messageText);
    }

    async function processAIResponse(messageText) {
        showTypingIndicator();

        try {
            // Thêm delay tự nhiên
            await new Promise(resolve =>
                setTimeout(resolve,
                    CONFIG.typingDelay.min +
                    Math.random() * (CONFIG.typingDelay.max - CONFIG.typingDelay.min)
                )
            );

            const aiResponse = await chatbotAI.processMessage(messageText);
            hideTypingIndicator();
            appendMessage(aiResponse, 'received');

            chatHistory.push({ type: 'received', data: aiResponse });

        } catch (error) {
            hideTypingIndicator();
            console.error('AI Processing Error:', error);
            appendMessage(chatbotAI.getErrorResponse(), 'received');
        }
    }

    function appendMessage(data, type, customClass = '') {
        let messageHTML = '';

        if (type === 'sent') {
            const formattedText = formatMessageText(escapeHtml(data));
            messageHTML = `<div class="message sent ${customClass}">${formattedText}</div>`;
        } else if (data && data.type === 'html') {
            // Tin nhắn kiểu HTML, không cần escape
            messageHTML = `<div class="message received ${customClass}">${data.text}</div>`;
        } else {
            let textToFormat = '';
            if (typeof data === 'string') {
                textToFormat = data;
            } else if (data && data.text) {
                textToFormat = data.text;
            } else if (data && data.message) { // Fallback cho object lỗi
                textToFormat = data.message;
            } else {
                textToFormat = 'Lỗi: Phản hồi không hợp lệ.';
            }
            const formattedText = formatMessageText(escapeHtml(textToFormat));
            messageHTML = `<div class="message received ${customClass}">${formattedText}</div>`;
        }

        chatBody.append(messageHTML);
        scrollToBottom();
    }

    function formatMessageText(text) {
        return text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>') // Bold
            .replace(/~~(.*?)~~/g, '<del>$1</del>') // Strikethrough
            .replace(/\n/g, '<br>'); // Line breaks
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function showTypingIndicator() {
        const typingHTML = `
            <div class="message received typing-indicator">
                <p>
                    <span></span>
                    <span></span>
                    <span></span>
                </p>
            </div>`;
        chatBody.append(typingHTML);
        scrollToBottom();
    }

    function hideTypingIndicator() {
        $('.typing-indicator').remove();
    }

    function scrollToBottom() {
        chatBody[0].scrollTo({
            top: chatBody[0].scrollHeight,
            behavior: 'smooth'
        });
    }

    // ============================================
    // UTILITIES
    // ============================================

    // Export for debugging
    window.chatbotDebug = {
        getHistory: () => chatHistory,
        getContext: () => conversationContext,
        resetContext: () => chatbotAI.contextManager.reset(),
        testIntent: (text) => chatbotAI.intentClassifier.classify(text, conversationContext),
        testExtract: (text) => chatbotAI.entityExtractor.extract(text)
    };

    console.log('🤖 Smart Chatbot AI initialized successfully!');
});