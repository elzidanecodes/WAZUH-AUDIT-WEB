
@extends('app')

@section('content')
<div class="container-fluid mt-5">
    <div class="card p-4 shadow-sm">
        <h2 class="mb-4 fw-bold">Data Laporan Wazuh</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
                <div>
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
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="table-search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for items">
                </div>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        {{-- <th class="px-6 py-3"></th> --}}
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Timestamp</th>
                        <th class="px-6 py-3">Host</th>
                        <th class="px-6 py-3">Source</th>
                        <th class="px-6 py-3">Process</th>
                        <th class="px-6 py-3">Message</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($alerts as $alert)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            {{-- <td class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-{{ $loop->index }}" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-{{ $loop->index }}" class="sr-only">checkbox</label>
                                </div>
                            </td> --}}
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ ($alerts->firstItem() ?? 0) + $loop->index }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $alert->timestamp ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $alert->host ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $alert->source ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $alert->process ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $alert->message ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="showFullLog('{{ $alert->id }}')" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1.5 dark:bg-blue-500 dark:hover:bg-blue-600">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data log ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Pagination -->
            @if ($alerts->hasPages())
            <div class="bg-white flex flex-col sm:flex-row justify-between items-center gap-4 px-4 py-3">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Showing <span class="font-medium">{{ $alerts->firstItem() }}</span> to <span class="font-medium">{{ $alerts->lastItem() }}</span> of <span class="font-medium">{{ $alerts->total() }}</span> results
                </div>
                <div class="shrink-0">
                    {{ $alerts->appends(request()->query())->onEachSide(1)->links() }}
                </div>
            </div>
            @endif
        </div>

       <!-- Full Log Modal -->
        <div id="fullLogModal" tabindex="-1" class="fixed inset-0 z-50 hidden items-center justify-center p-4 overflow-x-hidden overflow-y-auto bg-black/50">
            <div class="relative w-full max-w-3xl max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Full Log
                    </h3>
                    <button type="button" onclick="document.getElementById('fullLogModal').classList.add('hidden')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <tbody id="fullLogContent">
                        <!-- Dynamic rows here -->
                    </tbody>
                    </table>
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