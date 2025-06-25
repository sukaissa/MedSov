<?php
// Gross Motor Section
function render_gross_motor($data = [])
{
?>
    <fieldset class="border p-3 mb-4">
        <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Gross Motor</legend>
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
                        1 => 'While your baby is on his back, does he wave his arms and legs, wiggle, and squirm?',
                        2 => 'When your baby is on her tummy, does she turn her head to the side?',
                        3 => 'When your baby is on his tummy, does he hold his head up longer than a few seconds?',
                        4 => 'When your baby is on her back, does she kick her legs?',
                        5 => 'While your baby is on his back, does he move his head from side to side?',
                        6 => 'After holding her head up while on her tummy, does your baby lay her head back down on the floor, rather than let it drop or fall forward?'
                    ];
                    foreach ($questions as $num => $text) {
                        $field = "gross_{$num}";
                        $val = $data[$field] ?? '';
                        echo "<tr>";
                        echo "<td>{$num}.</td>";
                        echo "<td>{$text}</td>";
                        foreach ([['yes', 'Yes'], ['sometimes', 'Sometimes'], ['not_yet', 'Not Yet']] as [$v, $label]) {
                            $id = "gross_{$num}_{$v}";
                            $checked = ($val === $v) ? 'checked' : '';
                            echo "<td class=\"text-center\">";
                            echo "<input class=\"form-control-input\" type=\"radio\" name=\"gross_{$num}\" id=\"{$id}\" value=\"{$v}\" {$checked}>";
                            echo "</td>";
                        }
                        echo "<td></td></tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-right font-weight-medium" style="font-size:1.1rem;">GROSS MOTOR TOTAL</td>
                        <td>
                            <input type="text" class="form-control form-control-sm text-center" name="gross_total" id="gross_total" style="width:5em;" readonly>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </fieldset>
<?php
}
