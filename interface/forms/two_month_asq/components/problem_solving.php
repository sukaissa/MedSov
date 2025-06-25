<?php
function render_problem_solving($data = [])
{
?>
    <fieldset class="border p-3 mb-4">
        <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Problem Solving</legend>
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
                        1 => 'Does your baby look at objects that are 8-10 inches away?',
                        2 => 'When you move around, does your baby follow you with his eyes?',
                        3 => 'When you move a toy slowly from side to side in front of your baby’s face (about 10 inches away), does your baby follow the toy with her eyes, sometimes turning her head?',
                        4 => 'When you move a small toy up and down slowly in front of your baby’s face (about 10 inches away), does your baby follow the toy with his eyes?',
                        5 => 'When you hold your baby in a sitting position, does she look at a toy (about the size of a cup or rattle) that you place on the table or floor in front of her?',
                        6 => 'When you dangle a toy above your baby while he is lying on his back, does he wave his arms toward the toy?'
                    ];
                    foreach ($questions as $num => $text) {
                        $field = "ps_{$num}";
                        $val = $data[$field] ?? '';
                        echo "<tr>";
                        echo "<td>{$num}.</td>";
                        echo "<td>{$text}</td>";
                        foreach ([['yes', 'Yes'], ['sometimes', 'Sometimes'], ['not_yet', 'Not Yet']] as [$v, $label]) {
                            $id = "ps_{$num}_{$v}";
                            $checked = ($val === $v) ? 'checked' : '';
                            echo "<td class=\"text-center\">";
                            echo "<input class=\"form-control-input\" type=\"radio\" name=\"ps_{$num}\" id=\"{$id}\" value=\"{$v}\" {$checked}>";
                            echo "</td>";
                        }
                        echo "<td></td></tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right font-weight-medium" style="font-size:1.1rem;">PROBLEM SOLVING TOTAL</td>
                        <td>
                            <input type="text" class="form-control form-control-sm text-center" name="ps_total" id="ps_total" style="width:5em;" readonly>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </fieldset>
<?php
}
