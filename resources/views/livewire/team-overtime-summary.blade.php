<div class="p-4">
    <div class="relative h-64">
        <canvas id="teamOtChart"></canvas>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Script to initialize Chart.js and listen for Livewire updates
        document.addEventListener('livewire:initialized', () => {
            const chartData = @json($chartData);
            const ctx = document.getElementById('teamOtChart').getContext('2d');
            
            // Initial Chart Configuration
            let chart = new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { 
                        y: { beginAtZero: true, title: { display: true, text: 'OT Hours' } }
                    }
                }
            });

            // Livewire listener to update the chart data if the component re-renders
            Livewire.on('chartDataUpdated', (data) => {
                chart.data = data;
                chart.update();
            });
        });
    </script>
</div>
