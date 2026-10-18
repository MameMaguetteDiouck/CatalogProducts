@extends('layouts.app')
@section('content')
    <div class="w-100 row w-100 content  h-100 mt-0  m-3 d-flex  justify-content-between align-items-center">
        <div class="d-flex row justify-content-center align-items-center">
            <div class="card cardB border-primary text-primary m-2 cardFils">
                <div class="card-body">
                    <p class="text-center">Aliments</p>
                    <p class="text-center">{{ $products->where('type', 'aliments')->count() }}</p>
                </div>
            </div>
            <div class="card cardB border-primary text-primary m-2 cardFils">
                <div class="card-body">
                    <p class="text-center">Cosmetiques</p>
                    <p class="text-center">{{ $products->where('type', 'cosmetiques')->count() }}</p>
                </div>
            </div>
            <div class="card cardB border-primary text-primary  m-3 cardFils">
                <div class="card-body">
                    <p class="text-center">Electroniques</p>
                    <p class="text-center">{{ $products->where('type', 'electronique')->count() }}</p>
                </div>
            </div>
            <div class="card cardB border-primary text-primary m-3 cardFils">
                <div class="card-body">
                    <p class="text-center">Habillements</p>
                    <p class="text-center">{{ $products->where('type', 'habillements')->count() }}</p>
                </div>
            </div>
            <div class="card cardB border-primary text-primary m-3 cardFils">
                <div class="card-body">
                    <p class="text-center">BTPs</p>
                    <p class="text-center">{{ $products->where('type', 'btps')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="h-75 d-flex justify-content-center align-items-center">
            <div class="chatBox w-50 mt-5">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('insertJS')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Alimentaires', 'Electroniques', 'Vestimentaires', 'Cosmétiques', 'BTP', ],
                datasets: [{
                    label: 'Produits',
                    data: @json($data),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        const pi = document.getElementById('pieChart').getContext('2d');

        new Chart(pie, {
            type: 'pie',
            data: {
                labels: Repartition des Stocks,
                datasets: [{
                    label: 'Répartition des stocks',
                    data: ,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                    ],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@endsection
