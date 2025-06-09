window.onload = function() {
    $(".updateBtn").click(function() {
        var id = $(this).data('id');
        var ward = $(this).data('ward');
        var bed = $(this).data('bed');
        $('#id').val(id);
        $('#ward_update').val(ward);
        $('#bed').val(bed);
    });

    $(".deleteBtn").click(function() {
        var id = $(this).data('id');
        $('#deleteId').val(id);
    });

    $('#ward').on('change', function(e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        let beds = [];

        <?php foreach ($beds as $bed) { ?>
            beds.push(<?php echo json_encode([
                            'id' => $bed['id'],
                            'number' => $bed['number'],
                            'bed_type' => $bed['bed_type'],
                            'ward_id' => $bed['ward_id'],
                            'price_per_day' => $bed['price_per_day'],
                            'availability' => $bed['availability'],
                        ]);
                        ?>);
        <?php
        }  ?>

        let filteredBeds = beds.filter(bed => bed.ward_id == valueSelected)
        $("#bed_new").empty().append("<option>Select = Bed</option>");
        $(filteredBeds).each(function(i) {
            $("#bed_new").append(`<option value='${filteredBeds[i].id}'> ${filteredBeds[i].number} | ${filteredBeds[i].bed_type} | ${filteredBeds[i].price_per_day} </option>`)
        });
    });

};