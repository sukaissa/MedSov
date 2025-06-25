<?php
// Fine Motor Section
function render_fine_motor($data = [])
{
?>
    <fieldset class="border p-3 mb-4">
        <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Fine Motor</legend>
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
                        1 => 'Is your baby’s hand usually tightly closed when he is awake?<span class="fst-italic small">(If your baby used to do this but no longer does, mark “yes.”)</span>',
                        2 => 'Does your baby grasp your finger if you touch the palm of her hand?',
                        3 => 'When you put a toy in his hand, does your baby hold it in his hand briefly?',
                        4 => 'Does your baby touch her face with her hands?',
                        5 => 'Does your baby hold his hands open or partly open when he is awake (rather than in fists, as they were when he was a newborn)?',
                        6 => 'Does your baby grab or scratch at her clothes?'
                    ];
                    foreach ($questions as $num => $text) {
                        $field = "fine_{$num}";
                        $val = $data[$field] ?? '';
                        echo "<tr>";
                        echo "<td>{$num}.</td>";
                        echo "<td>{$text}</td>";
                        foreach ([['yes', 'Yes'], ['sometimes', 'Sometimes'], ['not_yet', 'Not Yet']] as [$v, $label]) {
                            $id = "fine_{$num}_{$v}";
                            $checked = ($val === $v) ? 'checked' : '';
                            echo "<td class=\"text-center\">";
                            echo "<input class=\"form-control-input\" type=\"radio\" name=\"fine_{$num}\" id=\"{$id}\" value=\"{$v}\" {$checked}>";
                            echo "</td>";
                        }
                        if ($num == 5) {
                            echo '<td class="text-center align-middle" style="font-size:1.2em;">*</td>';
                        } else {
                            echo '<td></td>';
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right font-weight-medium" style="font-size:1.1rem;">FINE MOTOR TOTAL</td>
                        <td>
                            <input type="text" class="form-control form-control-sm text-center" name="fine_total" id="fine_total" style="width:5em;" readonly>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="small text-muted mt-2">
                *If Fine Motor item 5 is marked “yes,” mark Fine Motor item 1 as “yes.”
            </div>
        </div>
    </fieldset>
<?php
}
