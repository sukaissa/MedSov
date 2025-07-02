<?php
// Define all available vital signs and their fields
$vitalSigns = [
    [
        'label' => 'Blood Pressure',
        'fields' => [
            [
                'label' => 'Systolic Pressure',
                'name' => 'systolic',
                'required' => true,
                'placeholder' => '0',
                'labelClass' => 'text-black'
            ],
            [
                'label' => 'Diastolic Pressure',
                'name' => 'diastolic',
                'required' => true,
                'placeholder' => '0',
                'labelClass' => 'text-[#1A174B]'
            ]
        ]
    ],
    [
        'label' => 'Temperature',
        'fields' => [
            [
                'label' => 'Temperature (°C)',
                'name' => 'temperature',
                'required' => true,
                'placeholder' => '0',
                'labelClass' => 'text-black'
            ]
        ]
    ],
    [
        'label' => 'Heart Rate',
        'fields' => [
            [
                'label' => 'Heart Rate (bpm)',
                'name' => 'heart_rate',
                'required' => true,
                'placeholder' => '0',
                'labelClass' => 'text-black'
            ]
        ]
    ],
    [
        'label' => 'Respiratory Rate',
        'fields' => [
            [
                'label' => 'Respiratory Rate (bpm)',
                'name' => 'respiratory_rate',
                'required' => true,
                'placeholder' => '0',
                'labelClass' => 'text-black'
            ]
        ]
    ],
];
?>
<script>
    const vitalSigns = <?php echo json_encode($vitalSigns); ?>;
    let vitalForms = [{
        vitalIndex: 0,
        values: {}
    }];

    function renderVitalForms() {
        const container = document.getElementById('vitalFormsContainer');
        container.innerHTML = '';
        vitalForms.forEach((form, idx) => {
            const vital = vitalSigns[form.vitalIndex];
            // Form wrapper
            const formDiv = document.createElement('div');
            formDiv.className = "mb-8 border-b pb-8 last:border-b-0 last:pb-0";
            // Dropdown
            const selectId = `vitalSignSelect_${idx}`;
            let selectHtml = `
            <label class=\"block font-semibold text-[14px] mb-2\" for=\"${selectId}\">
                Vital Sign<span class=\"text-[#ED2024]\">*</span>
            </label>
            <div class=\"relative mb-6\">
                <select id=\"${selectId}\" name=\"vitalSign[]\" class=\"w-full border rounded-md px-4 py-3 text-[14px] font-[300] text-[#282224] focus:outline-none appearance-none pr-10\"
                    onchange=\"onVitalChange(${idx}, this.value)\">
                    ${vitalSigns.map((v, i) =>
                        `<option value=\"${i}\" ${i == form.vitalIndex ? 'selected' : ''}>${v.label}</option>`
                    ).join('')}
                </select>
                <span class=\"pointer-events-none absolute right-4 top-1/2 transform -translate-y-1/2 text-[#ED2024]\">
                    <svg width=\"20\" height=\"20\" fill=\"none\" viewBox=\"0 0 24 24\">
                        <path stroke=\"#ED2024\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6 9l6 6 6-6\" />
                    </svg>
                </span>
            </div>
        `;
            formDiv.innerHTML = selectHtml;

            // Fields
            const fieldsDiv = document.createElement('div');
            fieldsDiv.className = "flex gap-4 mb-8";
            vital.fields.forEach(field => {
                const fieldId = `${field.name}_${idx}`;
                const value = form.values[field.name] || '';
                fieldsDiv.innerHTML += `
                <div class=\"flex-1\">
                    <label class=\"block font-semibold text-[18px] mb-2 ${field.labelClass}\">
                        ${field.label}${field.required ? '<span class=\\"text-[#ED2024]\\">*</span>' : ''}
                    </label>
                    <input
                        type=\"number\"
                        name=\"${field.name}[]\"
                        class=\"w-full border rounded-md px-4 py-4 text-[14px] font-[300] text-[#C6C6C6] focus:outline-none\"
                        placeholder=\"${field.placeholder}\"
                        min=\"0\"
                        value=\"${value}\"
                        ${field.required ? 'required' : ''}
                        id=\"${fieldId}\"
                    />
                </div>
            `;
            });
            formDiv.appendChild(fieldsDiv);
            container.appendChild(formDiv);
        });
    }

    function onVitalChange(formIdx, vitalIdx) {
        vitalForms[formIdx].vitalIndex = parseInt(vitalIdx);
        vitalForms[formIdx].values = {}; // reset values
        renderVitalForms();
    }

    function addVitalForm() {
        vitalForms.push({
            vitalIndex: 0,
            values: {}
        });
        renderVitalForms();
    }

    window.addEventListener('DOMContentLoaded', () => {
        renderVitalForms();
    });
</script>

<div id="patientModalRecordVitalsContent" class="hidden mt-5">
    <div class="flex items-center justify-between">
        <button class="flex gap-4 items-center" onclick="showModalContent('vitals')">
            <img src="./assets/img/msv-back-icon.svg" alt="back" />
            <p class="font-medium">Record Vitals</p>
        </button>

    </div>

    <form class="my-8 max-h-[400px] overflow-auto">
        <div id="vitalFormsContainer"></div>
        <!-- Add Button -->
        <button type="button" onclick="addVitalForm()" class="w-full h-[50px] border rounded-md py-6 flex items-center justify-center text-[24px] border-[#8C898A] text-[#C6C6C6] bg-white">
            +
        </button>
        <button
            type="submit"
            class="bg-[#ED2024] w-full h-[50px] text-white px-4 py-2 rounded-md mt-8">
            Record Vitals
        </button>
    </form>
</div>