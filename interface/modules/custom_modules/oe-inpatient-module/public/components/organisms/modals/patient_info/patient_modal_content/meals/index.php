<div id="patientModalMealsContent" class="hidden mt-5">
    <div class="flex justify-between items-center mb-6">
        <button class="flex gap-4 items-center" onclick="showModalContent('main', true, ['meals']);">
            <img src="./assets/img/msv-back-icon.svg" alt="back" />
            <p class="font-medium">Meals</p>
        </button>

        <button class="flex text-[25px] rounded-md items-center bg-[#ED2024] w-[36px] h-[36px] text-white justify-center" onclick="showModalContent('addMeals')">
            +
        </button>
    </div>

    <?php

    $dataSource = [
        [
            'id' => 'S001',
            'meal' => 'Breakfast',
            'staff' => 'Jane Doe, RN, NP',
            'date' => '2021-01-01',
        ],
        [
            'id' => 'S001',
            'meal' => 'Breakfast',
            'staff' => 'Jane Doe, RN, NP',
            'date' => '2021-01-01',
        ],
        [
            'id' => 'S001',
            'meal' => 'Breakfast',
            'staff' => 'Jane Doe, RN, NP',
            'date' => '2021-01-01',
        ],
        [
            'id' => 'S001',
            'meal' => 'Breakfast',
            'staff' => 'Jane Doe, RN, NP',
            'date' => '2021-01-01',
        ],

    ];


    $columns = [
        ['title' => 'Meal', 'dataIndex' => 'meal'],
        ['title' => 'Staff', 'dataIndex' => 'staff'],
        ['title' => 'Request Date', 'dataIndex' => 'date']
    ];
    $isLoading = false;
    $responsive = true;


    ?>

    <div class="max-h-[400px] overflow-auto">
        <?php if ($isLoading): ?>
            <table class="table-fixed w-full">
                <thead>
                    <tr class="h-10">
                        <?php foreach ($columns as $column): ?>
                            <th class="text-left px-4 text-gray-600 text-sm font-normal">
                                <?php echo htmlspecialchars($column['title']); ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colSpan="<?php echo count($columns); ?>" class="text-center py-4 text-gray-500">
                            <div>Loading...</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <table class="<?php echo $responsive ? 'table-auto' : 'table-fixed'; ?> w-full border-collapse">
                <thead class=" min-w-full  sticky top-0">
                    <tr class="h-[50px] border-b-[6px]">
                        <?php foreach ($columns as $column): ?>
                            <th class="text-left px-4 text-[#282224] bg-white text-sm font-[500]">
                                <?php echo htmlspecialchars($column['title']); ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <?php if (count($dataSource) > 0): ?>
                    <tbody>
                        <?php foreach ($dataSource as $index => $record): ?>
                            <tr class="border-b h-[60px] border-b-[#E7E7E7] hover:bg-[#ED2024] font-[300] text-[#282224] hover:text-white transition-all duration-200 ease-in-out cursor:pointer"
                                onclick="showPatientDetailsModal()">


                                <td class="px-3 py-2 text-sm font-[300]">
                                    <p class="font-medium text-sm">
                                        <?php echo $record['meal'] ?>
                                    </p>

                                </td>
                                <td class="px-3 py-2 text-sm font-[300]">
                                    <p class="font-medium text-sm">
                                        <?php echo $record['staff'] ?>
                                    </p>
                                </td>
                                <td class="px-3 py-2 text-sm font-[300]">
                                    <p class="font-medium text-sm">
                                        <?php echo $record['date'] ?>
                                    </p>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                <?php else: ?>
                    <tbody>
                        <tr>
                            <td colSpan="<?php echo count($columns); ?>" class="text-center py-4 text-gray-500 text-sm">
                                No data available.
                            </td>
                        </tr>
                    </tbody>
                <?php endif; ?>
            </table>
        <?php endif; ?>
    </div>

</div>