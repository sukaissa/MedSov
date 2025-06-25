<?php
// Communication Section
function render_communication($data = [])
{
?>
    <fieldset class="border p-3 mb-4">
        <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Communication</legend>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:3%"></th>
                        <th style="width:60%"> </th>
                        <th class="text-center" style="width:10%">Yes</th>
                        <th class="text-center" style="width:14%">Sometimes</th>
                        <th class="text-center" style="width:13%">Not Yet</th>
                        <th style="width:5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $questions = [
                        1 => 'Does your baby sometimes make throaty or gurgling sounds?',
                        2 => 'Does your baby make cooing sounds such as “ooo,” “gah,” and “aah”?',
                        3 => 'When you speak to your baby, does she make sounds back to you?',
                        4 => 'Does your baby smile when you talk to him?',
                        5 => 'Does your baby chuckle softly?',
                        6 => 'After you have been out of sight, does your baby smile or get excited when she sees you?'
                    ];
                    foreach ($questions as $num => $text) {
                        $field = "comm_{$num}";
                        $val = $data[$field] ?? '';
                        echo "<tr>";
                        echo "<td>{$num}.</td>";
                        echo "<td>{$text}</td>";
                        foreach ([['yes', 'Yes'], ['sometimes', 'Sometimes'], ['not_yet', 'Not Yet']] as [$v, $label]) {
                            $id = "comm_{$num}_{$v}";
                            $checked = ($val === $v) ? 'checked' : '';
                            echo "<td class=\"text-center\">";
                            echo "<input class=\"form-control-input\" type=\"radio\" name=\"comm_{$num}\" id=\"{$id}\" value=\"{$v}\" {$checked}>";
                            echo "</td>";
                        }
                        echo "<td></td></tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right font-weight-medium" style="font-size:1.1rem;">COMMUNICATION TOTAL</td>
                        <td>
                            <input type="text" class="form-control form-control-sm text-center" name="comm_total" id="comm_total" style="width:5em;" readonly>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </fieldset>
<?php
}
