<?php
// Example notes array. Replace with your actual data source.
$notes = [
    [
        'role' => 'sender',
        'type' => 'NURSING SHIFT NOTE',
        'author' => 'Joanne Petal, RN',
        'avatar' => './assets/img/patient.png',
        'datetime' => 'May 6, 2025 • 2:14 AM',
        'content' => 'Sender note: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque dui lorem, tincidunt vel ornare in, ornare et risus. Ut pellentesque, elit vel commodo pellentesque, leo libero fringilla leo, non viverra odio elit nec tortor.'
    ],
    [
        'role' => 'receiver',
        'type' => 'PROGRESS NOTE',
        'author' => 'Dr. Daniel Evans',
        'avatar' => './assets/img/patient.png',
        'datetime' => 'May 6, 2025 • 1:32 AM',
        'content' => 'Receiver note: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque dui lorem, tincidunt vel ornare in, ornare et risus. Ut pellentesque, elit vel commodo pellentesque, leo libero fringilla leo, non viverra odio elit nec tortor.'
    ],
];
?>

<div id="patientModalNotesContent" class="hidden mt-5">
    <!-- Back Button -->
    <button class="flex gap-4 items-center mb-6" onclick="showModalContent('main')">
        <img src="./assets/img/msv-back-icon.svg" alt="back" />
        <p class="font-medium">Back</p>
    </button>

    <!-- Notes List -->
    <div class="flex flex-col gap-6 overflow-auto max-h-[300px]">
        <?php foreach ($notes as $note): ?>
            <?php if ($note['role'] === 'sender'): ?>
                <!-- Sender Note (Left) -->
                <div class="relative bg-white rounded-xl border border-gray-200 h-[191px] p-6 shadow-sm ml-10">
                    <div class="absolute -left-[35px]">
                        <img src="<?php echo htmlspecialchars($note['avatar']); ?>" alt="avatar" class="w-12 h-12 rounded-full object-cover" />
                    </div>
                    <div class="flex-1 text-[#282224]">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <span class="text-xs ml-2"><?php echo htmlspecialchars($note['type']); ?></span>
                                <div class="text-[16px]"><?php echo htmlspecialchars($note['author']); ?></div>
                            </div>
                            <div class="text-[10px] mt-2">
                                <?php echo htmlspecialchars($note['datetime']); ?>
                            </div>
                        </div>
                        <div class="mt-2 font-[300] text-[14px]">
                            <?php echo htmlspecialchars($note['content']); ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Receiver Note (Right) -->
                <div class="relative bg-gray-50 rounded-xl border border-gray-200 h-[191px] p-6 shadow-sm mr-10">
                    <div class="flex-1 text-[#282224]">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <span class="text-xs ml-2"><?php echo htmlspecialchars($note['type']); ?></span>
                                <div class="text-[16px]"><?php echo htmlspecialchars($note['author']); ?></div>
                            </div>
                            <div class="text-[10px] mt-2">
                                <?php echo htmlspecialchars($note['datetime']); ?>
                            </div>
                        </div>
                        <div class="mt-2 font-[300] text-[14px]">
                            <?php echo htmlspecialchars($note['content']); ?>
                        </div>
                    </div>
                    <div class="absolute -right-[35px] top-[30px]">
                        <img src="<?php echo htmlspecialchars($note['avatar']); ?>" alt="avatar" class="w-12 h-12 rounded-full object-cover" />
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Note Type Selector and Action Buttons -->
    <div class="flex items-center gap-2 mt-8">
        <select class="flex-1 border border-[#D9D9D9] rounded-md px-4 py-2 text-[#8C898A] focus:outline-none focus:ring-2 focus:ring-[#ED2024]">
            <option>Select Note Type</option>
            <option>Nursing Shift Note</option>
            <option>Progress Note</option>
            <!-- Add more options as needed -->
        </select>
        <button class="w-10 h-10 flex items-center justify-center rounded-md border border-gray-300 hover:bg-gray-200 transition">
            <img src="./assets/img/msv-notes-icon.svg" alt="notes icon" class="w-3 h-4" />
        </button>
        <button class="bg-[#ED2024] p-2 rounded-md text-white hover:bg-red-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>