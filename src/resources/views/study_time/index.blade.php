<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>webapp-ph4</title>
    @vite('resources/css/app.css')
</head>

<body>
    <header class="h-20 flex justify-between items-center px-10">
        <div class="flex items-center gap-4">
            <img src="/img/logo.svg" alt="logo">
            <p class="text-[#97b9d1]">{{ $currentWeek }}th week</p>
        </div>
        <button id="openModalButton" class="bg-gradient-to-r text-white from-blue-500 to-blue-100 px-20 py-2 rounded-xl">記録・投稿</button>
    </header>
    <main class="bg-gray-200">
        <div class="flex justify-center pt-4">
            <div class="w-1/2">
                <div class="flex justify-center">
                    <div class="bg-white">
                        <p class="text-[#0f71bc] text-3xl">Today</p>
                        <p>{{ $todayStudyHour }}</p>
                        <p class="text-[#3ccfff]">hour</p>
                    </div>
                    <div class="bg-white">
                        <p class="text-[#0f71bc] text-3xl">Month</p>
                        <p>{{ $monthStudyHour }}</p>
                        <p class="text-[#3ccfff]">hour</p>
                    </div>
                    <div class="bg-white">
                        <p class="text-[#0f71bc] text-3xl">Total</p>
                        <p>{{ $totalStudyHour }}</p>
                        <p class="text-[#3ccfff]">hour</p>
                    </div>
                </div>
                <canvas id="studyHoursGraph">
                    Canvas not supported...
                </canvas>
            </div>
            <div class="flex w-1/2 gap-[2%] px-4">
                <div class="bg-white w-[49%] rounded-2xl">
                    <p>学習言語</p>
                    <div id="languagesChartWrapper">
                        <canvas id="languagesPieChart">
                            Canvas not supported...
                        </canvas>
                    </div>
                </div>
                <div class="bg-white w-[49%] rounded-2xl">
                    <p>学習コンテンツ</p>
                    <div id="contentsChartWrapper">
                        <canvas id="contentsPieChart">
                            Canvas not supported...
                        </canvas>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-center">{{ $displayYear }}年{{ $displayMonth }}月</p>
    </main>
    <footer></footer>
    <div id="modal" style="background-color: rgba(0, 0, 0, 0.3);" class="fixed w-full h-screen hidden top-0 justify-center items-center">
        <div class="bg-white w-4/5 opacity-100">
            <div id="modalCloseButton">
                <i class="fas fa-times"></i>
            </div>
            <h2>学習時間の記録</h2>

            <form action="{{ route('study_time.store') }}" method="post">
                @csrf
                <p>学習日</p>
                <input type="date" name="date" required>
                <p>学習言語</p>
                <select name="languages">
                    <option value="1">HTML</option>
                    <option value="2">CSS</option>
                    <option value="3">JavaScript</option>
                    <option value="4">PHP</option>
                    <option value="5">Laravel</option>
                </select>
                <p>学習コンテンツ</p>
                <select name="contents">
                    <option value="1">ドットインストール</option>
                    <option value="2">Progate</option>
                    <option value="3">Udemy</option>
                    <option value="4">書籍</option>
                    <option value="5">その他</option>
                </select>
                <p>学習時間</p>
                <input type="number" name="time" required>
                <button type="submit" class="block mx-auto p-4 text-white bg-gradient-to-r from-blue-500 to-blue-100">記録</button>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.1.0"></script>
    <script src="https://kit.fontawesome.com/afb3b2864c.js" crossorigin="anonymous"></script>
    <script src="/js/chart.js"></script>
    <script src="/js/modal.js"></script>
</body>

</html>
