<!-- views/layouts/admin_footer.php -->
</main>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous" onerror="console.error('Failed to load jQuery from CDN')"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" onerror="console.error('Failed to load Bootstrap JS')"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js" onerror="console.error('Failed to load jQuery Validation')"></script>
<script>
    const BASE_URL = '<?php echo BASE_URL; ?>';
    console.log('BASE_URL:', BASE_URL);
</script>
<script src="<?php echo BASE_URL; ?>assets/js/admin.js" onerror="console.error('Failed to load admin.js')"></script>
<?php if (isset($include_chart_js) && $include_chart_js): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js" onerror="console.error('Failed to load Chart.js')"></script>
    <script>
        console.log('Chart.js loaded');
    </script>
<?php endif; ?>
<script>
    console.log('admin_footer.js loaded');
    
    let revenueChart = null;
    function drawRevenueChart(labels, data, chartType = 'line') {
    console.log('drawRevenueChart called with:', labels, data, chartType);
    const ctx = document.getElementById('revenueChart');
    if (!ctx) {
        console.error('Canvas #revenueChart not found');
        return;
    }
    
    console.log('Canvas found, creating chart');
    if (revenueChart) {
        console.log('Destroying old chart');
        revenueChart.destroy();
    }
    
    // Tính toán giá trị min và max để tạo thang đo hợp lý
    const maxValue = Math.max(...data);
    const minValue = Math.min(...data);
    const range = maxValue - minValue;
    
    // Tạo thang đo Y phù hợp
    let suggestedMax, stepSize;
    if (maxValue < 1000000) { // Dưới 1 triệu
        stepSize = 100000; // Bước nhảy 100k
        suggestedMax = Math.ceil(maxValue / stepSize) * stepSize;
    } else if (maxValue < 10000000) { // Dưới 10 triệu
        stepSize = 1000000; // Bước nhảy 1 triệu
        suggestedMax = Math.ceil(maxValue / stepSize) * stepSize;
    } else { // Trên 10 triệu
        stepSize = 5000000; // Bước nhảy 5 triệu
        suggestedMax = Math.ceil(maxValue / stepSize) * stepSize;
    }
    
    const actualChartType = chartType === 'area' ? 'line' : chartType;
    const fill = chartType === 'area';
    
    // Màu sắc theo loại biểu đồ
    let backgroundColor, borderColor;
    switch(chartType) {
        case 'area':
            backgroundColor = 'rgba(54, 162, 235, 0.3)';
            borderColor = 'rgba(54, 162, 235, 1)';
            break;
        case 'bar':
            backgroundColor = 'rgba(255, 99, 132, 0.7)';
            borderColor = 'rgba(255, 99, 132, 1)';
            break;
        default: // line
            backgroundColor = 'rgba(75, 192, 192, 0.2)';
            borderColor = 'rgba(75, 192, 192, 1)';
    }
    
    revenueChart = new Chart(ctx.getContext('2d'), {
        type: actualChartType,
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (VND)',
                data: data,
                backgroundColor: backgroundColor,
                borderColor: borderColor,
                borderWidth: 2,
                pointBackgroundColor: borderColor,
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: borderColor,
                pointRadius: actualChartType === 'line' ? 4 : 0,
                pointHoverRadius: actualChartType === 'line' ? 6 : 0,
                fill: fill,
                tension: actualChartType === 'line' ? 0.4 : 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: suggestedMax,
                    ticks: {
                        stepSize: stepSize,
                        callback: function(value) {
                            // Format số tiền hợp lý
                            if (value >= 1000000) {
                                return (value / 1000000).toFixed(1) + 'M VND';
                            } else if (value >= 1000) {
                                return (value / 1000).toFixed(0) + 'K VND';
                            } else {
                                return value.toLocaleString('vi-VN') + ' VND';
                            }
                        },
                        font: {
                            size: 12,
                            family: 'Arial'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Doanh thu (VND)',
                        font: { 
                            size: 14, 
                            family: 'Arial', 
                            weight: 'bold' 
                        },
                        color: '#333'
                    },
                    grid: {
                        color: 'rgba(200, 200, 200, 0.3)',
                        drawBorder: false
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Thời gian',
                        font: { 
                            size: 14, 
                            family: 'Arial', 
                            weight: 'bold' 
                        },
                        color: '#333'
                    },
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 11,
                            family: 'Arial'
                        },
                        maxRotation: 45,
                        minRotation: 0
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: { 
                            size: 13, 
                            family: 'Arial',
                            weight: '500'
                        },
                        boxWidth: 20,
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: { 
                        size: 14, 
                        family: 'Arial',
                        weight: 'bold'
                    },
                    bodyFont: { 
                        size: 13, 
                        family: 'Arial' 
                    },
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        title: function(context) {
                            return 'Ngày: ' + context[0].label;
                        },
                        label: function(context) {
                            const value = context.parsed.y;
                            return 'Doanh thu: ' + value.toLocaleString('vi-VN') + ' VND';
                        },
                        afterLabel: function(context) {
                            // Hiển thị phần trăm so với tổng doanh thu
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed.y / total) * 100).toFixed(1);
                            return 'Chiếm: ' + percentage + '% tổng doanh thu';
                        }
                    }
                }
            },
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            },
            hover: {
                mode: 'nearest',
                intersect: false,
                animationDuration: 300
            }
        }
    });
    
    console.log('Chart created successfully with max value:', maxValue, 'step size:', stepSize);
}

    if (typeof jQuery !== 'undefined') {
    $(document).ready(function () {
        console.log('jQuery ready - Revenue chart improvements loaded');
        
        // Xử lý sidebar collapse
        $('#sidebarCollapse').on('click', function () {
            $('.sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });

        if ($('#revenue-filter').length) {
            console.log('Revenue filter form found');

            // Function to show/hide filter groups based on selection
            function toggleFilterGroups() {
                const filterType = $('#filter_type').val();
                $('#range_filter_group').toggle(filterType === 'range');
                $('#month_filter_group').toggle(filterType === 'month');
                $('#year_filter_group').toggle(filterType === 'year');
            }

            // Loading state functions
            function showLoading() {
                $('#total-revenue').html('<i class="fas fa-spinner fa-spin"></i> Đang tải...');
                if (revenueChart) revenueChart.destroy();
                const canvas = document.getElementById('revenueChart');
                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = '#666';
                ctx.font = '16px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('Đang tải dữ liệu...', canvas.width / 2, canvas.height / 2);
            }

            function hideLoading() { /* No-op, handled by chart draw or error */ }

            // Function to fetch revenue data via AJAX
            function fetchRevenueData(params) {
                console.log('Fetching revenue data with params:', params);
                showLoading();

                $.ajax({
                    url: BASE_URL + 'admin.php?url=get_revenue_data',
                    method: 'GET',
                    data: params,
                    dataType: 'json',
                    timeout: 10000,
                    success: function(response) {
                        console.log("Revenue response:", response);
                        hideLoading();
                        if (response && typeof response.totalRevenue !== 'undefined') {
                            const formattedTotal = parseFloat(response.totalRevenue).toLocaleString('vi-VN');
                            $('#total-revenue').html('<strong>' + formattedTotal + ' VND</strong>');
                            if (response.data && response.data.length > 0) {
                                const chartType = $('#chart-type').val() || 'line';
                                drawRevenueChart(response.labels, response.data, chartType);
                            } else {
                                const canvas = document.getElementById('revenueChart');
                                const ctx = canvas.getContext('2d');
                                ctx.clearRect(0, 0, canvas.width, canvas.height);
                                ctx.fillStyle = '#999';
                                ctx.font = '18px Arial';
                                ctx.textAlign = 'center';
                                ctx.fillText('Không có dữ liệu cho lựa chọn này', canvas.width / 2, canvas.height / 2);
                            }
                        } else {
                            alert('Lỗi: Dữ liệu không hợp lệ');
                            $('#total-revenue').text('0 VND');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Revenue AJAX error:', status, error, xhr.responseText);
                        hideLoading();
                        let errorMsg = 'Lỗi kết nối server';
                        if (status === 'timeout') errorMsg = 'Timeout: Server phản hồi quá chậm';
                        else if (xhr.status === 404) errorMsg = 'Không tìm thấy service';
                        else if (xhr.status === 500) errorMsg = 'Lỗi server nội bộ';
                        alert(errorMsg + ': ' + error);
                        $('#total-revenue').text('0 VND');
                    }
                });
            }

            // Event listener for filter type change
            $('#filter_type').on('change', toggleFilterGroups);

            // Handle form submission
            $('#revenue-filter').on('submit', function(e) {
                e.preventDefault();
                console.log('Revenue filter form submitted');
                fetchRevenueData($(this).serialize());
            });

            // Handle chart type change without re-fetching data
            $('#chart-type').on('change', function() {
                const chart_type = $(this).val();
                if (revenueChart && revenueChart.data.datasets[0].data.length > 0) {
                    console.log('Redrawing chart with new type:', chart_type);
                    drawRevenueChart(revenueChart.data.labels, revenueChart.data.datasets[0].data, chart_type);
                }
            });

            // Handle filter reset
            $('#reset-filter').on('click', function() {
                console.log('Reset filter clicked');
                const today = new Date();
                const thirtyDaysAgo = new Date();
                thirtyDaysAgo.setDate(today.getDate() - 30);

                $('#filter_type').val('range');
                $('#start_date').val(thirtyDaysAgo.toISOString().split('T')[0]);
                $('#end_date').val(today.toISOString().split('T')[0]);
                $('#month').val((today.getMonth() + 1).toString().padStart(2, '0'));
                $('#year_month').val(today.getFullYear());
                $('#year_only').val(today.getFullYear());
                $('#chart-type').val('line');

                toggleFilterGroups();
                $('#revenue-filter').submit();
            });

            // Initial setup
            toggleFilterGroups();
            // Load default data on page load
            const defaultParams = 'filter_type=range&start_date=' + new Date(new Date().setDate(new Date().getDate() - 30)).toISOString().split('T')[0] + '&end_date=' + new Date().toISOString().split('T')[0] + '&chart_type=line';
            fetchRevenueData(defaultParams);
        }
    });
} else {
    console.error('jQuery is not loaded');
}
</script>

</body>
</html>