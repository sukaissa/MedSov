<div id="patientModalTreatmentContent" class="hidden mt-5">
    <div class="flex justify-between items-center mb-6">
        <button class="flex gap-4 items-center" onclick="showModalContent('main')">
            <img src="./assets/img/msv-back-icon.svg" alt="back" />
            <p class="font-medium">Treatments</p>
        </button>

        <button class="flex text-[30px] rounded-md items-center bg-[#ED2024] w-[36px] h-[36px] text-white justify-center" onclick="showModalContent('addTreatment')">
            +
        </button>
    </div>

    <?php

    $dataSource = [
        [
            'id' => 'S001',
            'treatment' => 'Treatment Title Here',
            'interval' => 'Every Hour',
            'provider' => 'Jane Doe, RN, NP',
            'providerId' => '123456789',
            'status' => 'Active',
        ],
        [
            'id' => 'S001',
            'treatment' => 'Treatment Title Here',
            'interval' => 'Every Hour',
            'provider' => 'Jane Doe, RN, NP',
            'providerId' => '123456789',
            'status' => 'Active',
        ],
        [
            'id' => 'S001',
            'treatment' => 'Treatment Title Here',
            'interval' => 'Every Hour',
            'provider' => 'Jane Doe, RN, NP',
            'providerId' => '123456789',
            'status' => 'Active',
        ],
        [
            'id' => 'S001',
            'treatment' => 'Treatment Title Here',
            'interval' => 'Every Hour',
            'provider' => 'Jane Doe, RN, NP',
            'providerId' => '123456789',
            'status' => 'Active',
        ],
        [
            'id' => 'S001',
            'treatment' => 'Treatment Title Here',
            'interval' => 'Every Hour',
            'provider' => 'Jane Doe, RN, NP',
            'providerId' => '123456789',
            'status' => 'Active',
        ],
        [
            'id' => 'S001',
            'treatment' => 'Treatment Title Here',
            'interval' => 'Every Hour',
            'provider' => 'Jane Doe, RN, NP',
            'providerId' => '123456789',
            'status' => 'Active',
        ],
        [
            'id' => 'S001',
            'treatment' => 'Treatment Title Here',
            'interval' => 'Every Hour',
            'provider' => 'Jane Doe, RN, NP',
            'providerId' => '123456789',
            'status' => 'Active',
        ],
    ];


    $columns = [
        ['title' => 'Treatment', 'dataIndex' => 'treatment'],
        ['title' => 'Interval', 'dataIndex' => 'interval'],
        ['title' => 'Provider', 'dataIndex' => 'provider']
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
                                        <?php echo $record['treatment'] ?>
                                    </p>
                                    <p> <?php echo $record['status'] ?></p>
                                </td>
                                <td class="px-3 py-2 text-sm font-[300]">
                                    <p class="font-medium text-sm">
                                        <?php echo $record['interval'] ?>
                                    </p>
                                </td>
                                <td class="px-3 py-2 text-sm font-[300]">
                                    <p class="font-medium text-sm">
                                        <?php echo $record['provider'] ?>
                                    </p>
                                    <p> <?php echo $record['providerId'] ?></p>
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