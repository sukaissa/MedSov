<div id="visitorsRegistryForm" class="hidden pb-4">
    <form action="" method="POST" id="visitorForm">
        <input type="hidden" name="new_visit" value="1">
        <div class="mt-6 flex justify-between items-center">
            <p class="text-[#282224] text-2xl font-semibold"><?php echo xlt('New Visitors Registry') ?></p>
        </div>
        <div class="flex flex-col gap-4 my-6  max-h-[400px] overflow-auto">
            <div>
                <label class="font-medium" for=""><?php echo xlt('Visitor Name') ?><span class="text-[#ED2024]">*</span></label>
                <input type="text" name="visitor_name"
                    class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" id="visitor_name" required>
            </div>

            <div>
                <label class="font-medium" for=""><?php echo xlt('Patient Name') ?><span class="text-[#ED2024]">*</span></label>
                <select name="patient" id="patient" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" required>
                    <option value=""><?php echo xlt('Select Patient') ?></option>
                    <?php
                    if ($inpatients) {
                        foreach ($inpatients as $patient) {
                            $patientName = trim(($patient['fname'] ?? '') . ' ' . ($patient['mname'] ?? '') . ' ' . ($patient['lname'] ?? ''));
                            if (empty($patientName)) {
                                $patientName = 'Patient ID: ' . ($patient['patient_id'] ?? 'Unknown');
                            }

                            // Add bed/ward info if available
                            $bedInfo = '';
                            if (!empty($patient['bed_number'])) {
                                $bedInfo = ' - Bed: ' . $patient['bed_number'];
                            }
                            if (!empty($patient['ward_name'])) {
                                $bedInfo .= ' (' . $patient['ward_name'] . ')';
                            }

                            echo '<option value="' . htmlspecialchars($patient['patient_id'] ?? '') . '">' .
                                htmlspecialchars($patientName . $bedInfo) . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div>
                <label class="font-medium" for=""><?php echo xlt('Relationship') ?><span class="text-[#ED2024]">*</span></label>
                <select name="relationship_with_patient" id="relationship" class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" required>
                    <option value=""><?php echo xlt('Select Relationship') ?></option>

                    <optgroup label="<?php echo xlt('Immediate Family') ?>">
                        <option value="spouse"><?php echo xlt('Spouse') ?></option>
                        <option value="parent"><?php echo xlt('Parent') ?></option>
                        <option value="child"><?php echo xlt('Child') ?></option>
                        <option value="sibling"><?php echo xlt('Sibling') ?></option>
                    </optgroup>

                    <optgroup label="<?php echo xlt('Extended Family') ?>">
                        <option value="grandparent"><?php echo xlt('Grandparent') ?></option>
                        <option value="grandchild"><?php echo xlt('Grandchild') ?></option>
                        <option value="uncle"><?php echo xlt('Uncle') ?></option>
                        <option value="aunt"><?php echo xlt('Aunt') ?></option>
                        <option value="cousin"><?php echo xlt('Cousin') ?></option>
                        <option value="nephew"><?php echo xlt('Nephew') ?></option>
                        <option value="niece"><?php echo xlt('Niece') ?></option>
                        <option value="in-law"><?php echo xlt('In-law') ?></option>
                    </optgroup>

                    <optgroup label="<?php echo xlt('Non-Family') ?>">
                        <option value="friend"><?php echo xlt('Friend') ?></option>
                        <option value="colleague"><?php echo xlt('Colleague') ?></option>
                        <option value="neighbor"><?php echo xlt('Neighbor') ?></option>
                        <option value="guardian"><?php echo xlt('Guardian') ?></option>
                        <option value="caregiver"><?php echo xlt('Caregiver') ?></option>
                    </optgroup>

                    <optgroup label="<?php echo xlt('Professional') ?>">
                        <option value="pastor"><?php echo xlt('Pastor/Clergy') ?></option>
                        <option value="lawyer"><?php echo xlt('Lawyer') ?></option>
                        <option value="social_worker"><?php echo xlt('Social Worker') ?></option>
                    </optgroup>

                    <option value="other"><?php echo xlt('Other') ?></option>
                </select>
            </div>

            <div class="grid grid-cols-2 w-full gap-4">
                <div class="col-span-1">
                    <label class="font-medium" for=""> <?php echo xlt('Time In') ?><span class="text-[#ED2024]">*</span></label>
                    <input type="time" name="time_in"
                        class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" required>
                </div>
                <div class="col-span-1">
                    <label class="font-medium" for=""><?php echo xlt('Time Out') ?><span class="text-[#ED2024]">*</span></label>
                    <input type="time" name="time_out"
                        class="w-full h-[56px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" required>
                </div>
            </div>

            <div>
                <label class="font-medium" for=""><?php echo xlt('Reason For Visit') ?><span class="text-[#ED2024]">*</span></label>
                <textarea name="comment" id="comment" class="w-full h-[80px] px-5 rounded-md text-sm border border-[#8C898A] text-[#282224]" required></textarea>
            </div>
        </div>
        <button type="submit" class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md font-bold"><?php echo xlt('Save') ?></button>
    </form>
</div>

<script>
    // Client-side validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('visitorForm');

        if (form) {
            form.addEventListener('submit', function(e) {
                let errors = [];

                // Validate visitor name
                const visitorName = document.getElementById('visitor_name').value.trim();
                if (!visitorName) {
                    errors.push('Visitor name is required');
                } else if (visitorName.length < 2) {
                    errors.push('Visitor name must be at least 2 characters long');
                }

                // Validate patient selection
                const patient = document.getElementById('patient').value;
                if (!patient) {
                    errors.push('Please select a patient');
                }

                // Validate relationship
                const relationship = document.getElementById('relationship').value;
                if (!relationship) {
                    errors.push('Please select a relationship');
                }

                // Validate time in
                const timeIn = document.querySelector('input[name="time_in"]').value;
                if (!timeIn) {
                    errors.push('Time in is required');
                }

                // Validate time out
                const timeOut = document.querySelector('input[name="time_out"]').value;
                if (!timeOut) {
                    errors.push('Time out is required');
                } else if (timeIn && timeOut <= timeIn) {
                    errors.push('Time out must be after time in');
                }

                // Validate reason for visit
                const comment = document.getElementById('comment').value.trim();
                if (!comment) {
                    errors.push('Reason for visit is required');
                } else if (comment.length < 5) {
                    errors.push('Reason for visit must be at least 5 characters long');
                }

                // Show errors and prevent submission
                if (errors.length > 0) {
                    e.preventDefault();
                    alert(errors.join('\n'));
                    return false;
                }
            });
        }
    });
</script>