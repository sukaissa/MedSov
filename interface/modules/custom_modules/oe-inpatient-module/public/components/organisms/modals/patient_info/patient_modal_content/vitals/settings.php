<?php
$vitals = [
    [
        'label' => 'Temperature',
        'desc' => 'Donec nunc est, bibendum at fermentum in, consequat quis urna.',
        'enabled' => true,
        'disabled' => false,
    ],
    [
        'label' => 'Heart Rate',
        'desc' => 'Donec nunc est, bibendum at fermentum in, consequat quis urna.',
        'enabled' => true,
        'disabled' => false,
    ],
    [
        'label' => 'Respiratory Rate',
        'desc' => 'Donec nunc est, bibendum at fermentum in, consequat quis urna.',
        'enabled' => true,
        'disabled' => false,
    ],
    [
        'label' => 'Blood Pressure',
        'desc' => 'Donec nunc est, bibendum at fermentum in, consequat quis urna.',
        'enabled' => false,
        'disabled' => true,
    ],
];
?>

<div id="patientModalVitalsSettingsContent" class="hidden mt-5">
    <div class="flex items-center justify-between">
        <button class="flex gap-4 items-center" onclick="showModalContent('vitals')">
            <img src="./assets/img/msv-back-icon.svg" alt="back" />
            <p class="font-medium">Back</p>
        </button>
        <div class="flex items-center gap-3">
            <p class="text-sm font-medium text-[#282224]">Last Update: <span class="font-[400]">May 1, 2025 • 15:48</span></p>
            <button class="w-[36px] h-[36px] rounded-md border bg-[#FAFAFA] flex items-center justify-center">
                <img src="./assets/img/msv-settings-icon.svg" alt="settings" class="w-4 h-4">
            </button>
        </div>
    </div>

    <div class="my-10 max-h-[300px] overflow-auto">
        <?php foreach ($vitals as $vital): ?>
            <div class="flex items-center justify-between py-4 border-b last:border-b-0">
                <div>
                    <div class="font-semibold text-[14px] text-[#282224]"><?php echo htmlspecialchars($vital['label']); ?></div>
                    <div class="text-[14px] text-[#282224] font-[300]">
                        <?php echo htmlspecialchars($vital['desc']); ?>
                    </div>
                </div>
                <!-- Toggle Switch -->
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox"
                        class="sr-only peer"
                        <?php echo $vital['enabled'] ? 'checked' : ''; ?>
                        <?php echo $vital['disabled'] ? 'disabled' : ''; ?>>
                    <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:bg-[#ED2024] transition
                        after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:border after:rounded-full after:h-6 after:w-6 after:transition-all
                        peer-checked:after:translate-x-6 after:shadow
                        relative"></div>
                </label>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md">
        Save Settings
    </button>
</div>