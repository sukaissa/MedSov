window.onload = function () {
  $(".nurseNoteBtn").click(function () {
    var admission_id = $(this).data("admission_id");
    var pid = $(this).data("pid");
    $("#note_admission_id").val(admission_id);
    $("#note_pid").val(pid);
  });

  $(".vitalBtn").click(function () {
    var admission_id = $(this).data("admission_id");
    var pid = $(this).data("pid");
    $("#vit_admission_id").val(admission_id);
    $("#vit_pid").val(pid);
  });

  $(".setTreatmBtn").click(function () {
    var admission_id = $(this).data("admission_id");
    var patient_id = $(this).data("pid");
    $("#admission_id").val(admission_id);
    $("#patient_id").val(patient_id);
  });

  $(".deleteBtn").click(function () {
    var id = $(this).data("id");
    $("#deleteId").val(id);
  });

  $(".changeStatusBtn").click(function () {
    var id = $(this).data("id");
    var status = $(this).data("status");
    $("#deleteId").val(id);
  });

  $(".dischBtn").click(function () {
    var id = $(this).data("id");
    var bed_id = $(this).data("bed_id");
    $("#dis_admission_id").val(id);
    $("#dis_bed_id").val(bed_id);
  });

  $(".time_interval").change(function () {
    var action_end_time = $(this).val();
    var action_start_time = $("#action_start_time").val();
    var reslt = action_end_time - action_start_time;
    $("#time_interval").val(reslt);
  });

  // search drug code
  $(".select_pat").select2({
    dropdownParent: $("#setTreatment"),
    ajax: {
      url: "ajax_search.php",
      dataType: "json",
      type: "GET",
      data: function (params) {
        return {
          q: params.term, // search term
          page: params.page,
          search: "search_for_drugs",
        };
      },

      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: data.patients,
          pagination: {
            more: params.page * 30 < data.total_count,
          },
        };
      },
      cache: true,
    },
    minimumInputLength: 3,
    templateResult: formatOpt,
    templateSelection: formatRepoSelection,
  });

  function formatOpt(repo) {
    if (repo.loading) {
      return repo.text;
    }
    var $container = $(
      "<option class='select_pat clearfix' value='" +
        repo.id +
        "'>" +
        repo.name +
        "</option>"
    );
    return $container;
  }

  function formatRepoSelection(repo) {
    return repo.fname + " " + repo.mname + " " + repo.lname;
  }
};
