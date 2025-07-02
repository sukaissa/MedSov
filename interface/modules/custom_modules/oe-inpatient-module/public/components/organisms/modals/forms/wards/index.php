<div id="wardsForm" class="hidden pb-4">
    <form action="" method="POST">
        <input type="hidden" name="new" value="1">
        <div class="mt-6 flex justify-between items-center">
            <p class="text-[#282224] text-2xl font-semibold">New Ward</p>
        </div>
        <div class="flex flex-col gap-4 my-6  max-h-[400px] overflow-auto">
            <div>
                <label class="font-medium" for="">Name<span class="text-[#ED2024]">*</span></label>
                <input type="text" name="name"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="name">
            </div>

            <div>
                <label class="font-medium" for="">Short Name<span class="text-[#ED2024]">*</span></label>
                <input type="text" name="short_name"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="shortName">
            </div>
        </div>
        <button type="submit" class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md font-bold">Save</button>
    </form>
</div>