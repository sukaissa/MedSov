<?php
// Fine Motor Section
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
                <tr>
                    <td>1.</td>
                    <td>
                        Is your baby’s hand usually tightly closed when he is awake?
                        <span class="fst-italic small">(If your baby used to do this but no longer does, mark “yes.”)</span>
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_1" id="fine_1_yes" value="yes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_1" id="fine_1_sometimes" value="sometimes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_1" id="fine_1_not_yet" value="not-yet">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>
                        Does your baby grasp your finger if you touch the palm of her hand?
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_2" id="fine_2_yes" value="yes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_2" id="fine_2_sometimes" value="sometimes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_2" id="fine_2_not_yet" value="not-yet">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>
                        When you put a toy in his hand, does your baby hold it in his hand briefly?
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_3" id="fine_3_yes" value="yes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_3" id="fine_3_sometimes" value="sometimes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_3" id="fine_3_not_yet" value="not-yet">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Does your baby touch her face with her hands?</td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_4" id="fine_4_yes" value="yes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_4" id="fine_4_sometimes" value="sometimes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_4" id="fine_4_not_yet" value="not-yet">
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>
                        Does your baby hold his hands open or partly open when he is awake (rather than in fists, as they were when he was a newborn)?
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_5" id="fine_5_yes" value="yes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_5" id="fine_5_sometimes" value="sometimes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_5" id="fine_5_not_yet" value="not-yet">
                    </td>
                    <td class="text-center align-middle" style="font-size:1.2em;">*</td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td>Does your baby grab or scratch at her clothes?</td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_6" id="fine_6_yes" value="yes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_6" id="fine_6_sometimes" value="sometimes">
                    </td>
                    <td class="text-center">
                        <input class="form-control-input" type="radio" name="fine_6" id="fine_6_not_yet" value="not-yet">
                    </td>
                    <td></td>
                </tr>
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
