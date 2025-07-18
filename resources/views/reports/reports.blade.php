
@extends('app')

@section('content')
<div class="container-fluid mt-5">
    <div class="card p-4 shadow-sm">
        <h2 class="space-y-6 mb-4 fw-bold">Data Prediksi Serangan</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                {{-- Filter Dropdown --}}
                {{-- <div>
                    <button id="dropdownRadioButton" data-dropdown-toggle="dropdownRadio" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                        <svg class="w-3 h-3 text-gray-500 dark:text-gray-400 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                        </svg>
                        Last 30 days
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownRadio" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownRadioButton">
                            <li>
                                <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="filter-radio-example-1" type="radio" value="" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="filter-radio-example-1" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Last day</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input checked id="filter-radio-example-2" type="radio" value="" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="filter-radio-example-2" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Last 7 days</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="filter-radio-example-3" type="radio" value="" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="filter-radio-example-3" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Last 30 days</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="filter-radio-example-4" type="radio" value="" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="filter-radio-example-4" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Last month</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="filter-radio-example-5" type="radio" value="" name="filter-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="filter-radio-example-5" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Last year</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div> --}}
                <!-- Tombol Upload -->
                <form action="{{ route('reports.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-3">
                    @csrf
                    <label for="file-upload" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-700 cursor-pointer">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Upload File Log
                    </label>
                    
                    <input id="file-upload" type="file" name="files[]" accept=".log,.txt" multiple required class="hidden" onchange="this.form.submit()">
                </form>

                <form method="GET" action="{{ route('reports') }}" class="mb-4">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" id="table-search" value="{{ request('search') }}"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search description / label...">
                    </div>
                </form>

            </div>
            @if ($errors->has('file'))
                <p class="text-red-500 text-sm mt-2">{{ $errors->first('file') }}</p>
            @endif
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Timestamp</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Decoder</th>
                        <th class="px-6 py-3">Hasil Prediksi</th>
                        {{-- <th class="px-6 py-3">Source</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $log->timestamp }}</td>
                            <td class="px-6 py-4">{{ $log->description }}</td>
                            <td class="px-6 py-4">{{ $log->decoder }}</td>
                            <td class="px-6 py-4">
                                @if ($log->predicted_label === 'brute_force')
                                    <span class="bg-yellow-200 text-yellow-800 text-xs font-medium px-2 py-1 rounded">Brute Force</span>
                                @elseif ($log->predicted_label === 'ddos')
                                    <span class="bg-red-200 text-red-800 text-xs font-medium px-2 py-1 rounded">DDoS</span>
                                @else
                                    <span class="bg-green-200 text-green-800 text-xs font-medium px-2 py-1 rounded">Normal</span>
                                @endif
                            </td>
                            {{-- <td class="px-6 py-4 italic text-gray-400">{{ $log->source ?? '-' }}</td> --}}
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Belum ada data prediksi.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
            <!-- Pagination -->
            @if ($logs->hasPages())
            <div class="bg-white flex flex-col sm:flex-row justify-between items-center gap-4 px-4 py-3">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Showing <span class="font-medium">{{ $logs->firstItem() }}</span> to <span class="font-medium">{{ $logs->lastItem() }}</span> of <span class="font-medium">{{ $logs->total() }}</span> results
                </div>
                <div class="shrink-0">
                    {{ $logs->appends(request()->query())->onEachSide(1)->links() }}
                </div>
            </div>
            @endif
        </div>
       
        {{-- Statistik MTTD dan MTTR --}}   
        <div class="">
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 rounded-t-lg bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800" id="defaultTab" data-tabs-toggle="#defaultTabContent" role="tablist">
                    <li class="me-2">
                        <button id="about-tab" data-tabs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="true" class="inline-block p-4 text-blue-600 rounded-ss-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700 dark:text-blue-500">Statistik</button>
                    </li>
                    </li>
                </ul>
                <div id="defaultTabContent">
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel" aria-labelledby="about-tab">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">Statistik Deteksi Serangan</h2>

                        @if($stat)
                            <ul class="space-y-2 text-gray-700 dark:text-gray-300">
                                <li>📌 <strong>MTTD:</strong> {{ $stat->mttd_menit }} menit</li>
                                <li>📌 <strong>MTTR:</strong> {{ $stat->mttr_menit }} menit</li>
                                <li>📌 <strong>Total Event:</strong> {{ $stat->total_event }}</li>
                                <li>📅 <strong>Batch Terakhir:</strong> {{ \Carbon\Carbon::parse($stat->dihitung_pada)->format('d M Y H:i:s') }}</li>
                            </ul>
                        @else
                            <p class="text-red-600 dark:text-red-400">Data statistik belum tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </div>

    </div>

</div>


@endsection

@section('scripts')
<script>
function showFullLog(logId) {
    fetch(`/log/${logId}`)
        .then(res => res.json())
        .then(data => {
            const tableBody = document.getElementById('fullLogContent');
            tableBody.innerHTML = '';

            for (const key in data) {
                const row = `
                    <tr>
                        <td class="px-4 py-2 font-medium text-gray-700 dark:text-white">${key}</td>
                        <td class="px-4 py-2 text-gray-900 dark:text-gray-300">${JSON.stringify(data[key])}</td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            }

            document.getElementById('fullLogModal').classList.add('flex');
            document.getElementById('fullLogModal').classList.remove('hidden');

        });
}
</script>

@endsection