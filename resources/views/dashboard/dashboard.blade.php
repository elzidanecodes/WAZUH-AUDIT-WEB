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
            <div class="w-14 h-14 flex items-center justify-center p-2 bg-blue-100 text-blue-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="bell"><path fill="currentColor" d="M18,13.18V10a6,6,0,0,0-5-5.91V3a1,1,0,0,0-2,0V4.09A6,6,0,0,0,6,10v3.18A3,3,0,0,0,4,16v2a1,1,0,0,0,1,1H8.14a4,4,0,0,0,7.72,0H19a1,1,0,0,0,1-1V16A3,3,0,0,0,18,13.18ZM8,10a4,4,0,0,1,8,0v3H8Zm4,10a2,2,0,0,1-1.72-1h3.44A2,2,0,0,1,12,20Zm6-3H6V16a1,1,0,0,1,1-1H17a1,1,0,0,1,1,1Z"></path></svg>
            </div>
        </div>
    </div>

    {{-- Total Reports --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-1">{{ $totalReportsFormatted }}</h3>
                <p class="text-gray-500 text-sm">Total Reports</p>
                <span class="inline-flex items-center text-xs bg-green-100 text-green-600 font-medium px-2.5 py-0.5 rounded">
                    <i class="ti ti-arrow-badge-up mr-1"></i> 
                    {{ number_format(abs($percentageChangeReports), 2) }}%
                </span>
            </div>
            <div class="w-14 h-14 flex items-center justify-center p-3 bg-green-100 text-green-600 rounded-full">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="m20 8-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z"></path></svg>
            </div>
        </div>
    </div>

    {{-- Total Expenses --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-1">{{ $bruteForceCountFormatted }}</h3>
                <p class="text-gray-500 text-sm">Total Brute Force</p>
                <span class="inline-flex items-center text-xs bg-red-100 text-red-600 font-medium px-2.5 py-0.5 rounded">
                    <i class="ti ti-arrow-badge-up mr-1"></i> 5.62%
                </span>
            </div>
            <div class="w-12 h-12 flex items-center justify-center bg-yellow-100 text-yellow-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" id="shield" width="100" height="100" fill="currentColor" version="1.1" viewBox="0 0 100 100">
                  <g id="layer1" transform="translate(0 -952.362)">
                    <path id="path15438" d="m 50.196377,970.37485 a 1.5043353,1.4942442 0 0 0 -1.233658,0.6716 c -2.738175,3.9713 -11.417261,7.34737 -21.347025,7.40573 a 1.5043353,1.4942442 0 0 0 -0.0588,0 1.5043353,1.4942442 0 0 0 -0.195199,-0.0204 1.5043353,1.4942442 0 0 0 -1.479618,1.19072 c 0,0 -1.500797,6.74949 -2.252616,14.91315 -0.751859,8.16385 -0.906859,17.72395 2.393136,23.89635 2.472136,4.6239 8.321266,8.3404 13.542958,11.1693 4.829712,2.6165 8.813045,4.2 9.439844,4.4467 a 1.5043353,1.4942442 0 0 0 0.995518,0.3123 1.5043353,1.4942442 0 0 0 1.007239,-0.3201 1.5043353,1.4942442 0 0 0 0.006,0 c 0.652579,-0.2564 4.616112,-1.828 9.428124,-4.4349 5.221672,-2.8289 11.062982,-6.5454 13.535138,-11.1693 3.299994,-6.1724 3.144975,-15.7325 2.393116,-23.89635 -0.751859,-8.16366 -2.252576,-14.91315 -2.252576,-14.91315 a 1.5043353,1.4942442 0 0 0 -1.518678,-1.19072 1.5043353,1.4942442 0 0 0 -0.125,0 c -9.540984,-0.038 -17.92289,-3.23493 -20.847285,-7.09347 a 1.5043353,1.4942442 0 0 0 -1.432778,-0.98004 z m -0.0274,3.89236 c 4.193413,4.42323 12.24024,6.91019 21.225985,7.12867 0.30114,1.42257 1.346778,6.511 1.983237,13.42181 0.732479,7.95281 0.579679,17.28921 -2.057417,22.22151 -1.809177,3.3841 -7.288768,7.2212 -12.32098,9.9474 -4.555432,2.468 -8.257306,3.95 -8.998685,4.2436 -0.741418,-0.2937 -4.443252,-1.7756 -8.998705,-4.2436 -5.032212,-2.7262 -10.511762,-6.5633 -12.320979,-9.9474 -2.637096,-4.9323 -2.789816,-14.2687 -2.057417,-22.22151 0.636159,-6.90741 1.681357,-11.99164 1.983237,-13.41801 9.141745,-0.21772 17.311751,-2.70322 21.561724,-7.13247 z" ></path>
                    <path id="ellipse15762" d="m 49.999997,986.36217 c -8.818805,0 -15.999973,7.18119 -15.999973,15.99993 0,8.8188 7.181168,16 15.999973,16 8.818746,0 15.999954,-7.1812 15.999974,-16 0,-8.81874 -7.181228,-15.99993 -15.999974,-15.99993 z m 0,2.99999 c 3.056195,0 5.854551,1.0536 8.070287,2.8086 l -18.26169,18.26174 c -1.756157,-2.2162 -2.808575,-5.013 -2.808575,-8.0704 0,-7.19735 5.80251,-12.99994 12.999978,-12.99994 z m 10.191384,4.92979 c 1.754997,2.2156 2.808595,5.014 2.808595,8.07015 0,7.1976 -5.802551,13 -12.999979,13 -3.055395,0 -5.85487,-1.0544 -8.070306,-2.8086 l 18.26169,-18.26155 z"></path>
                  </g>
                </svg>
            </div>
        </div>
    </div>

    {{-- Investments --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-2xl font-bold mb-1">{{ $ddosCountFormatted }}</h3>
                <p class="text-gray-500 text-sm">Total DDos</p>
                <span class="inline-flex items-center text-xs bg-green-100 text-green-600 font-medium px-2.5 py-0.5 rounded">
                    <i class="ti ti-arrow-badge-up mr-1"></i> 2.53%
                </span>
            </div>
            <div class="w-14 h-14 flex items-center justify-center bg-red-100 p-2 text-red-600 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" id="database-shield" fill="currentColor">
                  <path d="M21.76 16a.76.76 0 0 1-1.52 0 .76.76 0 0 1 1.52 0Zm2.24-.76a.76.76 0 0 0 0 1.52.76.76 0 0 0 0-1.52Zm3 0a.76.76 0 0 0 0 1.52.76.76 0 0 0 0-1.52Zm-6 15.52a.76.76 0 0 0 0-1.52.76.76 0 0 0 0 1.52Zm3 0a.76.76 0 0 0 0-1.52.76.76 0 0 0 0 1.52Zm3 0a.76.76 0 0 0 0-1.52.76.76 0 0 0 0 1.52Zm0-7a.76.76 0 0 0 0-1.52.76.76 0 0 0 0 1.52Zm-3 0a.76.76 0 0 0 0-1.52.76.76 0 0 0 0 1.52Zm21 18.53a3.24 3.24 0 1 1-4.3-3.06c-.033-.196.095-.736-.24-.73h-2.23A2.232 2.232 0 0 1 36 36.27v-2.21a31.76 31.76 0 0 1-12 9.41 31.762 31.762 0 0 1-12-9.41v2.21a2.232 2.232 0 0 1-2.23 2.23H7.54c-.326-.01-.214.538-.24.73a3.24 3.24 0 1 1-2-.04 2.327 2.327 0 0 1 2.24-2.69h2.23a.226.226 0 0 0 .23-.23V31.5a.858.858 0 0 1 .05-.23 32.939 32.939 0 0 1-4.93-18.95 1.001 1.001 0 0 1 .59-.92l2.84-1.24V8.5a.989.989 0 0 0-.88-.97 3.025 3.025 0 0 1-5.22-2.04 3.012 3.012 0 1 1 6.02.17 3.206 3.206 0 0 1 2.08 3.63L23.6 3.58a1.01 1.01 0 0 1 .8 0l13.05 5.71a3.213 3.213 0 0 1 2.08-3.63 3.012 3.012 0 1 1 6.02-.17 3.025 3.025 0 0 1-5.22 2.04.986.986 0 0 0-.88.97v1.66l2.84 1.24a1.002 1.002 0 0 1 .59.92 32.94 32.94 0 0 1-4.93 18.95.856.856 0 0 1 .05.23v4.77a.226.226 0 0 0 .23.23h2.23a2.325 2.325 0 0 1 2.24 2.69 3.24 3.24 0 0 1 2.3 3.1ZM33.5 27h-19a5.16 5.16 0 0 0 5 6h9a5.161 5.161 0 0 0 5-6Zm0-6h-19v4h19Zm0-3a5.002 5.002 0 0 0-5-5h-9a5.161 5.161 0 0 0-5 6h19ZM21 23.76a.76.76 0 0 0 0-1.52.76.76 0 0 0 0 1.52Z"></path>
                </svg>
            </div>
        </div>
    </div>

</div>

<div class="flex flex-col md:flex-row gap-6 mb-6">

  {{-- Card 1 --}}
  <div class="w-full md:w-3/3 bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6 flex flex-col justify-between">
    <div class="flex justify-between">
      <div>
        <h5 id="total-alerts" class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2">-</h5>
        <p class="text-base font-normal text-gray-500 dark:text-gray-400">Alert this week</p>
      </div>
      <div id="percent-change" class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500 dark:text-green-500 text-center">
        0.00%
        <svg class="w-3 h-3 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
        </svg>
      </div>
    </div>

    <div id="area-chart" class="w-full"></div>

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
          <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
              <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="loadChart('yesterday')">Yesterday</a></li>
              <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="loadChart('today')">Today</a></li>
              <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="loadChart('last_7_days')">Last 7 days</a></li>
              <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="loadChart('last_30_days')">Last 30 days</a></li>
              <li><a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" onclick="loadChart('last_90_days')">Last 90 days</a></li>
          </ul>
        </div>
        <a
          href="#"
          class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500 hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
          Predict Report
          <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
          </svg>
        </a>
      </div>
    </div>
  </div>

  {{-- Pie Chart 2 --}}
  
  <div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">

    <div class="flex justify-between items-start w-full">
        <div class="flex-col items-center">
          <div class="flex items-center mb-1">
              <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1">Attack Label</h5>
              <svg data-popover-target="chart-info" data-popover-placement="bottom" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z"/>
              </svg>
              <div data-popover id="chart-info" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                  <div class="p-3 space-y-2">
                      <h3 class="font-semibold text-gray-900 dark:text-white">Activity growth - Incremental</h3>
                      <p>Report helps navigate cumulative growth of community activities. Ideally, the chart should have a growing trend, as stagnating chart signifies a significant decrease of community activity.</p>
                      <h3 class="font-semibold text-gray-900 dark:text-white">Calculation</h3>
                      <p>For each date bucket, the all-time volume of activities is calculated. This means that activities in period n contain all activities up to period n, plus the activities generated by your community in period.</p>
                      <a href="#" class="flex items-center font-medium text-blue-600 dark:text-blue-500 dark:hover:text-blue-600 hover:text-blue-700 hover:underline">Read more <svg class="w-2 h-2 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg></a>
              </div>
              <div data-popper-arrow></div>
          </div>
        </div>
        <span class="text-sm text-gray-500 dark:text-gray-400">Total Predicted Labels (All Data)</span>
      </div>
      <div class="flex justify-end items-center">
        <button id="widgetDropdownButton" data-dropdown-toggle="widgetDropdown" data-dropdown-placement="bottom" type="button"  class="inline-flex items-center justify-center text-gray-500 w-8 h-8 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm"><svg class="w-3.5 h-3.5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
            <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
          </svg><span class="sr-only">Open dropdown</span>
        </button>
        {{-- <div id="widgetDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="widgetDropdownButton">
              <li>
                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 21">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279"/>
                  </svg>Edit widget
                </a>
              </li>
              <li>
                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z"/>
                    <path d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                  </svg>Download data
                </a>
              </li>
              <li>
                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5.953 7.467 6.094-2.612m.096 8.114L5.857 9.676m.305-1.192a2.581 2.581 0 1 1-5.162 0 2.581 2.581 0 0 1 5.162 0ZM17 3.84a2.581 2.581 0 1 1-5.162 0 2.581 2.581 0 0 1 5.162 0Zm0 10.322a2.581 2.581 0 1 1-5.162 0 2.581 2.581 0 0 1 5.162 0Z"/>
                  </svg>Add to repository
                </a>
              </li>
              <li>
                <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                    <path d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z"/>
                  </svg>Delete widget
                </a>
              </li>
            </ul>
      </div> --}}
    </div>
    </div>

    <!-- Line Chart -->
      <div class="py-6 w-full" id="pie-chart"></div>

      <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
        <div class="flex justify-between items-center pt-5">
          <!-- Button -->
          <button
            id="dropdownDefaultButton"
            data-dropdown-toggle="lastDaysdropdown"
            data-dropdown-placement="bottom"
            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
            type="button">
            All Time
          </button>
          
          <a
            href="#"
            class="uppercase text-sm font-semibold inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
            Traffic analysis
            <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
          </a>
        </div>
      </div>
  </div>

</div>


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="{{ asset('js/chartWeek.js') }}"></script>
<script src="{{ asset('js/chartPie.js') }}"></script>
<script>
    window.onload = () => {
        setTimeout(() => {
            loadChart('last_7_days');
        }, 300);
    };
</script>
@endsection

@endsection
