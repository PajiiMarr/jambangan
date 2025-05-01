<div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-zinc-900 shadow-md p-6">
    <div wire:ignore.self class="w-full h-150 sm-h-full">
        <!-- Year and Month Selectors -->
        <div class="flex gap-4 ms-4 mt-3">
            <select class="p-2 rounded" x-model="selectedYear" @change="updateChart">
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
            </select>
            <select class="p-2 rounded" x-model="selectedMonth" @change="updateChart">
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>
        </div>

        <!-- Chart Canvas -->
        <canvas id="myChart"></canvas>
    </div>
</div>