@extends('app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">


    {{-- Total Alert --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-1">{{ $alertCountFormatted }}</h3>
                <p class="text-gray-500 text-sm">Total Alert</p>
                <span class="inline-flex items-center text-xs bg-green-100 text-green-600 font-medium px-2.5 py-0.5 rounded">
                    <i class="ti ti-arrow-badge-up mr-1"></i>
                    {{ number_format(abs($percentageChange), 2) }}%
                </span>
            </div>
            <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                <iconify-icon icon="iconamoon:credit-card-duotone" class="text-2xl"></iconify-icon>
            </div>
        </div>
    </div>

    {{-- Total Income --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-1">$75.09k</h3>
                <p class="text-gray-500 text-sm">Total Income</p>
                <span class="inline-flex items-center text-xs bg-green-100 text-green-600 font-medium px-2.5 py-0.5 rounded">
                    <i class="ti ti-arrow-badge-up mr-1"></i> 7.36%
                </span>
            </div>
            <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-600 rounded-full">
                <iconify-icon icon="iconamoon:store-duotone" class="text-2xl"></iconify-icon>
            </div>
        </div>
    </div>

    {{-- Total Expenses --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-1">$62.8k</h3>
                <p class="text-gray-500 text-sm">Total Expenses</p>
                <span class="inline-flex items-center text-xs bg-red-100 text-red-600 font-medium px-2.5 py-0.5 rounded">
                    <i class="ti ti-arrow-badge-up mr-1"></i> 5.62%
                </span>
            </div>
            <div class="w-12 h-12 flex items-center justify-center bg-green-100 text-green-600 rounded-full">
                <iconify-icon icon="iconamoon:3d-duotone" class="text-2xl"></iconify-icon>
            </div>
        </div>
    </div>

    {{-- Investments --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-1">$6.4k</h3>
                <p class="text-gray-500 text-sm">Investments</p>
                <span class="inline-flex items-center text-xs bg-green-100 text-green-600 font-medium px-2.5 py-0.5 rounded">
                    <i class="ti ti-arrow-badge-up mr-1"></i> 2.53%
                </span>
            </div>
            <div class="w-12 h-12 flex items-center justify-center bg-yellow-100 text-yellow-600 rounded-full">
                <iconify-icon icon="iconamoon:3d-duotone" class="text-2xl"></iconify-icon>
            </div>
        </div>
    </div>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

  {{-- Card 1 --}}
  <div class="w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6 flex flex-col justify-between">
    <div class="flex justify-between">
      <div>
        <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">{{ $alertCountFormatted }}</h5>
        <p class="text-base font-normal text-gray-500 dark:text-gray-400">Alert this week</p>
      </div>
      <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
        {{ number_format(abs($percentageChange), 2) }}%
        <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
        </svg>
      </div>
    </div>
    <div id="area-chart" class="my-4"></div>
    <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
      <div class="flex justify-between items-center pt-5">
        <!-- Button -->
        <button
          id="dropdownDefaultButton1"
          data-dropdown-toggle="lastDaysdropdown1"
          data-dropdown-placement="bottom"
          class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
          type="button">
          Last 7 days
          <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
          </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="lastDaysdropdown1" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
          <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton1">
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 7 days</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 30 days</a>
            </li>
            <li>
              <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 90 days</a>
            </li>
          </ul>
        </div>
        <a
          href="#"
          class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
          Users Report
          <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
          </svg>
        </a>
      </div>
    </div>
  </div>

  {{-- Card 2 --}}
  <div class="w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6 flex flex-col justify-between">
    <div class="flex justify-between">
      <div>
        <h5 class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">{{ $alertCountFormatted }}</h5>
        <p class="text-base font-normal text-gray-500 dark:text-gray-400">Alert this week</p>
      </div>
      <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
        {{ number_format(abs($percentageChange), 2) }}%
        <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
        </svg>
      </div>
    </div>
    <div id="area-chart" class="my-4"></div>
    <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
      <div class="flex justify-between items-center pt-5">
        <!-- Button -->
        <button
          id="dropdownDefaultButton2"
          data-dropdown-toggle="lastDaysdropdown2"
          data-dropdown-placement="bottom"
          class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
          type="button">
          Last 7 days
          <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
          </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="lastDaysdropdown2" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
  <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton2">
    <li><a href="#" onclick="event.preventDefault(); loadChart('yesterday')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Yesterday</a></li>
    <li><a href="#" onclick="event.preventDefault(); loadChart('today')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Today</a></li>
    <li><a href="#" onclick="event.preventDefault(); loadChart('week')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 7 days</a></li>
    <li><a href="#" onclick="event.preventDefault(); loadChart('month')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 30 days</a></li>
    <li><a href="#" onclick="event.preventDefault(); loadChart('year')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Last 90 days</a></li>
  </ul>
</div>

        <a
          href="#"
          class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
          Users Report
          <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
          </svg>
        </a>
      </div>
    </div>
  </div>

</div>


@push('scripts')
<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- Include your chart script -->
<script src="{{ asset('js/chartWeek.js') }}"></script>
<script>
    // Initialize charts when page loads
    document.addEventListener('DOMContentLoaded', function() {
        loadChart('week', 'area-chart');

    });
</script>
@endpush



@endsection
