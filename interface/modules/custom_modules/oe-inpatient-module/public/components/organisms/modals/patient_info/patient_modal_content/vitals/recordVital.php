<?php

use OpenEMR\Modules\InpatientModule\VitalQuery;
use OpenEMR\Modules\InpatientModule\InpatientQuery;

require_once __DIR__ . "/../../../../../../../../../../globals.php";
require_once __DIR__ . "/../../../../../sql/VitalQuery.php";
require_once __DIR__ . "/../../../../../sql/InpatientQuery.php";

$vitalQuery = new VitalQuery();
$inpatientQuery = new InpatientQuery();

$pid = isset($_GET['pid']) ? $_GET['pid'] : null;
$inpatientData = $pid ? $inpatientQuery->getInpatientByPid($pid) : null;

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
                'name' => 'pulse',
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
    [
        'label' => 'SpO2',
        'fields' => [
            [
                'label' => 'SpO2 (%)',
                'name' => 'spo_2',
                'required' => true,
                'placeholder' => '0',
                'labelClass' => 'text-black'
            ]
        ]
    ],
    [
        'label' => 'Height',
        'fields' => [
            [
                'label' => 'Height (cm)',
                'name' => 'height',
                'required' => false,
                'placeholder' => '0',
                'labelClass' => 'text-black'
            ]
        ]
    ],
    [
        'label' => 'Weight',
        'fields' => [
            [
                'label' => 'Weight (kg)',
                'name' => 'weight',
                'required' => false,
                'placeholder' => '0',
                'labelClass' => 'text-black'
            ]
        ]
    ],
    [
        'label' => 'Fluid Input',
        'fields' => [
            [
                'label' => 'Fluid Input (ml)',
                'name' => 'fluid_input',
                'required' => false,
                'placeholder' => '0',
                'labelClass' => 'text-black'
            ]
        ]
    ],
    [
        'label' => 'Fluid Output',
        'fields' => [
            [
                'label' => 'Fluid Output (ml)',
                'name' => 'fluid_output',
                'required' => false,
                'placeholder' => '0',
                'labelClass' => 'text-black'
            ]
        ]
    ],
    [
        'label' => 'Pain Score',
        'fields' => [
            [
                'label' => 'Pain Score (0-10)',
                'name' => 'pain_score',
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

            // Get already selected vital indices (excluding current form)
            const selectedIndices = vitalForms
                .filter((_, i) => i !== idx)
                .map(f => f.vitalIndex);

            // Form wrapper
            const formDiv = document.createElement('div');
            formDiv.className = "mb-8 border-b pb-8 last:border-b-0 last:pb-0";

            // Dropdown with filtered options
            const selectId = `vitalSignSelect_${idx}`;
            let selectHtml = `
            <label class=\"block font-semibold text-[14px] mb-2\" for=\"${selectId}\">
                Vital Sign<span class=\"text-[#ED2024]\">*</span>
            </label>
            <div class=\"relative mb-6\">
                <select id=\"${selectId}\" name=\"vitalSign[]\" class=\"w-full border rounded-md px-4 py-3 text-[14px] font-[300] text-[#282224] focus:outline-none appearance-none pr-10\"
                    onchange=\"onVitalChange(${idx}, this.value)\">
                    ${vitalSigns.map((v, i) => {
                        // Show option if it's the current selection OR if it's not already selected by another form
                        if (i === form.vitalIndex || !selectedIndices.includes(i)) {
                            return `<option value=\"${i}\" ${i == form.vitalIndex ? 'selected' : ''}>${v.label}</option>`;
                        }
                        return '';
                    }).join('')}
                </select>
                <span class=\"pointer-events-none absolute right-4 top-1/2 transform -translate-y-1/2 text-[#ED2024]\">
                    <svg width=\"20\" height=\"20\" fill=\"none\" viewBox=\"0 0 24 24\">
                        <path stroke=\"#ED2024\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6 9l6 6 6-6\" />
                    </svg>
                </span>
            </div>
        `;
            formDiv.innerHTML = selectHtml;

            // Fields (rest remains the same)
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
        // Get already selected vital indices
        const selectedIndices = vitalForms.map(f => f.vitalIndex);

        // Find the first available vital sign that hasn't been selected
        let availableIndex = 0;
        for (let i = 0; i < vitalSigns.length; i++) {
            if (!selectedIndices.includes(i)) {
                availableIndex = i;
                break;
            }
        }

        // Only add if there are available vital signs
        if (selectedIndices.length < vitalSigns.length) {
            vitalForms.push({
                vitalIndex: availableIndex,
                values: {}
            });
            renderVitalForms();
        } else {
            alert('All vital signs have been selected.');
        }
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

    <form class="my-8 max-h-[400px] overflow-auto" method="POST" action="<?php echo $_SERVER['PHP_SELF'] . '?pid=' . urlencode($pid) . '&vitals=1'; ?>">
        <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($pid); ?>">
        <input type="hidden" name="admission_id" value="<?php echo $inpatientData['id'] ?? ''; ?>">
        <input type="hidden" name="new_vital_record" value="1">
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