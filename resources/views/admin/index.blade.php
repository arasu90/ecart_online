<x-admin-layout>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a>Dashboard</h3>
        </div>
        <div class="panel-body">
            <div class="content-row">
                <h2 class="content-row-title">Top Order Products</h2>
                <div class="row">
                    <div class="col-md-3">
                        <div style="border: 1px dotted #37BC9B">
                            <h5>TodayOrder</h5>
                            <h3>{{ $todayOrders }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="border: 1px dotted #E9573F">
                            <h5>TodayOrderValue</h5>
                            <h3>{{ $todayOrdersValue }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="border: 1px dotted #967ADC">
                            <h5>MonthOrder</h5>
                            <h3>{{ $thisMonthOrders }}</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div style="border: 1px dotted #3BAFDA">
                            <h5>MonthOrderValue</h5>
                            <h3>{{ $thisMonthOrdersValue }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- panel body -->
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><a href="javascript:void(0);" class="toggle-sidebar"><span class="fa fa-angle-double-left" data-toggle="offcanvas" title="Maximize Panel"></span></a>Chart</h3>
        </div>
        <div class="panel-body">
            <div class="content-row">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="content-row-title">Top Products</h2>
                        <div style="border: 1px dotted #37BC9B">
                            <canvas id="topProoductBarChart"
                                width="370"
                                height="160">
                            </canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="content-row-title">Top Orders</h2>
                        <div style="border: 1px dotted #E9573F">
                        <canvas id="topOrderBarChart"
                                width="370"
                                height="160">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- panel body -->
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js">
    </script>
    <script>
        // Sample data for the chart
        let data = {
            labels: @json($barChartProductName),
            datasets: [{
                barPercentage: 0.5,
                label: 'Products',
                data: @json($barChartProductQty),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 206, 86, 0.9)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.8)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1,
                borderRadius: 10,
                hoverBackgroundColor: [
                    'rgba(34, 127, 188, 0.7)',
                    'rgba(183, 36, 68, 0.5)',
                    'rgba(197, 153, 39, 0.9)',
                    'rgba(41, 187, 187, 0.6)',
                    'rgba(90, 40, 191, 0.8)'
                ],
                hoverBorderColor: [
                    'rgba(12, 140, 224, 0.5)',
                    'rgba(237, 16, 64, 0.5)',
                    'rgba(232, 170, 12, 0.5)',
                    'rgba(14, 248, 248, 0.5)',
                    'rgba(86, 10, 238, 0.5)'
                ]
            }]
        };

        // Configuration options for the chart
        let options = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Get the canvas element
        let ctx = document.
        getElementById('topProoductBarChart').
        getContext('2d');

        // Create the styled bar chart
        let topProoductBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    </script>
    <script>
        // Sample data for the chart
        let orderdata = {
            labels: @json($barChartOrderValue),
            datasets: [{
                barPercentage: 0.5,
                label: 'Orders',
                data: @json($barChartOrderItem),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(255, 206, 86, 0.9)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.8)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1,
                borderRadius: 10,
                hoverBackgroundColor: [
                    'rgba(34, 127, 188, 0.7)',
                    'rgba(183, 36, 68, 0.5)',
                    'rgba(197, 153, 39, 0.9)',
                    'rgba(41, 187, 187, 0.6)',
                    'rgba(90, 40, 191, 0.8)'
                ],
                hoverBorderColor: [
                    'rgba(12, 140, 224, 0.5)',
                    'rgba(237, 16, 64, 0.5)',
                    'rgba(232, 170, 12, 0.5)',
                    'rgba(14, 248, 248, 0.5)',
                    'rgba(86, 10, 238, 0.5)'
                ]
            }]
        };

        // Configuration options for the chart
        let order_options = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Get the canvas element
        let order_ctx = document.
        getElementById('topOrderBarChart').
        getContext('2d');

        // Create the styled bar chart
        let topOrderBarChart = new Chart(order_ctx, {
            type: 'bar',
            data: orderdata,
            options: order_options
        });
    </script>
    @endpush
</x-admin-layout>