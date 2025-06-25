<?php
function render_personal_social($data = [])
{
?>
    <fieldset class="border p-3 mb-4">
        <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Personal-Social</legend>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:3%"></th>
                        <th style="width:60%"></th>
                        <th class="text-center" style="width:10%">Yes</th>
                        <th class="text-center" style="width:14%">Sometimes</th>
                        <th class="text-center" style="width:13%">Not Yet</th>
                        <th style="width:5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $questions = [
                        1 => 'Does your baby sometimes try to suck, even when she’s not feeding?',
                        2 => 'Does your baby cry when he is hungry, wet, tired, or wants to be held?',
                        3 => 'Does your baby smile at you?',
                        4 => 'When you smile at your baby, does she smile back?',
                        5 => 'Does your baby watch his hands?',
                        6 => 'When your baby sees the breast or bottle, does she seem to know she is about to be fed?'
                    ];
                    foreach ($questions as $num => $text) {
                        $field = "psoc_{$num}";
                        $val = $data[$field] ?? '';
                        echo "<tr>";
                        echo "<td>{$num}.</td>";
                        echo "<td>{$text}</td>";
                        foreach ([['yes', 'Yes'], ['sometimes', 'Sometimes'], ['not_yet', 'Not Yet']] as [$v, $label]) {
                            $id = "psoc_{$num}_{$v}";
                            $checked = ($val === $v) ? 'checked' : '';
                            echo "<td class=\"text-center\">";
                            echo "<input class=\"form-control-input\" type=\"radio\" name=\"psoc_{$num}\" id=\"{$id}\" value=\"{$v}\" {$checked}>";
                            echo "</td>";
                        }
                        echo "<td></td></tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right font-weight-medium" style="font-size:1.1rem;">PERSONAL-SOCIAL TOTAL</td>
                        <td>
                            <input type="text" class="form-control form-control-sm text-center" name="psoc_total" id="psoc_total" style="width:5em;" readonly>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </fieldset>
<?php
}
