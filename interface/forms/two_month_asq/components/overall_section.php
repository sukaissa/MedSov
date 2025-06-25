<?php
function render_overall_section($data = [])
{
?>
    <fieldset class="border p-3 mb-4">
        <legend class="float-none w-auto px-2 font-weight-medium text-center w-100">Overall</legend>
        <div class="mb-2 fst-italic">Parents and providers may use the space below for additional comments.</div>
        <?php
        $questions = [
            1 => [
                'label' => 'Did your baby pass the newborn hearing screening test? If no, explain:',
                'yes' => 'Yes',
                'no' => 'No'
            ],
            2 => [
                'label' => 'Does your baby move both hands and both legs equally well? If no, explain:',
                'yes' => 'Yes',
                'no' => 'No'
            ],
            3 => [
                'label' => 'Does either parent have a family history of childhood deafness, hearing impairment, or vision problems? If yes, explain:',
                'yes' => 'Yes',
                'no' => 'No'
            ],
            4 => [
                'label' => 'Has your baby had any medical problems? If yes, explain:',
                'yes' => 'Yes',
                'no' => 'No'
            ],
            5 => [
                'label' => 'Do you have concerns about your baby’s behavior (for example, eating, sleeping)? If yes, explain:',
                'yes' => 'Yes',
                'no' => 'No'
            ],
            6 => [
                'label' => 'Does anything about your baby worry you? If yes, explain:',
                'yes' => 'Yes',
                'no' => 'No'
            ],
        ];
        foreach ($questions as $i => $q) {
            $val = $data["overall_{$i}"] ?? '';
            $comment = $data["overall_{$i}_comment"] ?? '';
        ?>
            <div class="mb-4">
                <div class="row align-items-center mb-2">
                    <div class="col-md-8">
                        <label class="form-label mb-0"><?php echo $i . '. ' . $q['label']; ?></label>
                    </div>
                    <div class="col-md-4 d-flex justify-content-end">
                        <div class="form-control-inline mr-2">
                            <input class="form-control-input" type="radio" name="overall_<?php echo $i; ?>" id="overall_<?php echo $i; ?>_yes" value="yes" <?php if ($val === 'yes') echo 'checked'; ?>>
                            <label class="form-control-label" for="overall_<?php echo $i; ?>_yes">Yes</label>
                        </div>
                        <div class="form-control-inline">
                            <input class="form-control-input" type="radio" name="overall_<?php echo $i; ?>" id="overall_<?php echo $i; ?>_no" value="no" <?php if ($val === 'no') echo 'checked'; ?>>
                            <label class="form-control-label" for="overall_<?php echo $i; ?>_no">No</label>
                        </div>
                    </div>
                </div>
                <textarea class="form-control mb-3 rounded-4" id="overall_<?php echo $i; ?>_comment" name="overall_<?php echo $i; ?>_comment" rows="2" style="resize:vertical;"><?php echo htmlspecialchars($comment); ?></textarea>
            </div>
        <?php } ?>
    </fieldset>
<?php
}
